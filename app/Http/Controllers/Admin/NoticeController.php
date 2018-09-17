<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notice;
use App\Img;
use Auth;
use Image;
use Validator;
use Session;
use Storage;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notice::latest()->paginate(15);
        return view('manage.notices.index', ['notices' => $notices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('manage.notices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|max:5120'
        ])->validate();
        
        $notice = new Notice;
        $notice->title = trim($request->title);
        $notice->content = trim($request->content);

         
        //dd($request);
         if(Auth::user()->notices()->save($notice) ) //$notice->save()
         {  
            if($request->hasFile('images'))
            {
                for ($i=0; $i < count($request->file('images')) ; $i++) 
                { 
                  if ($request->file('images')[$i]->isValid())
                  {
                    $img=$request->file('images')[$i];
                    $ext=$img->extension();
                    $img_name=time().rand(0,999).'.'.$ext;
                     $upload_dir='images/notice/';
                    $path='images/notice/'.$img_name;


                    if (!file_exists(public_path('images/notice'))) 
                        Storage::makeDirectory($upload_dir, 0775, true);
                
                    Image::make($img)->resize(720, 720,
                        function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save(public_path($path));

                    $images[$i]=new Img;
                    $images[$i]->filepath = $path;
                   }
                }
                if(count($images)) $notice->imgs()->saveMany($images);   
            }

            
            Session::flash('success', 'succesfully uploaded new notice');
            return redirect()->route('notices.show', $notice->id);

         }  else
            return back()->withErrors('Sorry ! failed to upload new notice '.$notice->title);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notice = Notice::findOrFail($id);
        abort_if(!$notice, 404);
        return view('manage.notices.show', ['notice' => $notice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        abort_if(!$notice, 404);

        if(Auth::user()->owns($notice))
        return view('manage.notices.edit', ['notice' => $notice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $notice = Notice::findOrFail($id);
        if(Auth::user()->owns($notice))
        {
            Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|max:5120'
            ])->validate();
            
            $notice->title = trim($request->title);
            $notice->content = trim($request->content);

            
            //dd($request);
             if(Auth::user()->notices()->save($notice) ) //$notice->save()
             {  
                if($request->hasFile('images'))
                {   
                    $flag = 0;
                    for ($i=0; $i < count($request->file('images')) ; $i++) 
                    { 
                      if ($request->file('images')[$i]->isValid())
                      { 

                        $img=$request->file('images')[$i];
                        $ext=$img->extension();
                        $img_name=time().rand(0,999).'.'.$ext;
                         $upload_dir='images/notice/';
                        $path='images/notice/'.$img_name;


                        if (!file_exists(public_path('images/notice'))) 
                            Storage::makeDirectory($upload_dir, 0775, true);
                    
                        Image::make($img)->resize(720, 720,
                            function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->save(public_path($path));

                        $images[$i]=new Img;
                        $images[$i]->filepath = $path;
                        $flag = 1;
                       }
                    }

                    if($flag == 1)
                    {
                        if( count($notice->imgs) )
                        {   
                            foreach($notice->imgs as $img) 
                            Storage::delete($img->filepath);

                            $notice->imgs()->delete();
                            $notice->imgs()->saveMany($images);
                        }    
                    }    
                } 

               
                Session::flash('success', 'succesfully upodated notice '.$notice->title);
                return redirect()->route('notices.show', $id);

             }  else
                return back()->withErrors('Sorry ! failed to upodate notice '.$notice->title);
        } else
        return back()->withErrors('you are not the owner of notice '.$notice->title);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {  
         $notice = Notice::findOrFail($id);

        if(Auth::user()->owns($notice)) 
        {   
            if($notice->delete()) 
            { 
                if( count($notice->imgs) )
                {   
                    foreach($notice->imgs as $img) 
                    Storage::delete($img->filepath);

                    $notice->imgs()->delete();
                }                   
                Session::flash('success', 'succesfully deleted notice '.$notice->title);
                return redirect()->route('notices.index');

            } else
                return back()->withErrors('Error occured in deleting the notice '.$notice->title);
        }  else
             return back()->withErrors('you dont have permission to delete this notice');               
    }

}
