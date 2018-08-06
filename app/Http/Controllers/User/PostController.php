<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use App\Post;
use App\Img;
use App\User;
use App\Faculty;
use Auth;
use Image;
use Validator;
use Session;
use Storage;
use Notification;
use App\Notifications\PostNotification;

class PostController extends Controller
{   
    public function __construct()
    {
        $this->middleware('permission:create-posts', ['only' => ['create', 'store'] ]);
        $this->middleware('permission:update-posts', [ 'only' => ['edit', 'update'] ]);
        $this->middleware('permission:destroy-posts', [ 'only' => ['destroy',] ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Auth::user()->posts()->with('tags')->get();
        //dd($posts);
        return view('user.posts.index', [ 'posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $tags = Tag::all();
        return view('user.posts.create', [
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  // dd($request);
        if($request->submit == 'Yes')
        {  
            Validator::make($request->all(), [
            'content' => 'required|max:10000',
            'tags' => 'required|array|max:20',
            'tags.*' => 'required|max:255|string',
            'image' => 'nullable|file|image|max:5120',
            
            'faculty' => 'sometimes|required|array|max:12',
            'faculty.*' => 'required|string',
            'start_rollno' => 'sometimes|array|max:12',
            'start_rollno.*' =>'required_with:faculty.*|integer|min:0|max:400',
            'end_rollno' => 'sometimes|required_with:start_rollno|array|max:12',
            'end_rollno.*' => 'required_with:faculty.*|integer|min:0|max:400',
            'year' => 'sometimes|required|array|max:12',
            'year.*' => ' required_with:faculty.*|integer',
            'ind_rollno' => 'sometimes|nullable|array|max:40',
            'ind_rollno.*' => 'nullable|alpha_num|size:10'
            ])->validate();

            $roll_no=[];
            $college = strtoupper(session('tenant'));
            for($i=0; $i<count($request->faculty); $i++)
            {  
                //to check and setup roll no's range for diffrent conditions
                /*
                if($request->start_rollno[$i]==NULL ||  $request->end_rollno[$i]==NULL)
                    $roll_flag = 'all';
                else if($request->start_rollno[$i] &&  $request->end_rollno[$i])
                    {
                    if($request->end_rollno[$i] < $request->start_rollno[$i])
                       $request->end_rollno[$i]= $request->start_rollno[$i];
                    }
                else if($request->start_rollno[$i])
                    $request->end_rollno[$i] = $request->start_rollno[$i];
                else
                     $request->start_rollno[$i]  = $request->end_rollno[$i];
                 */
                 if($request->end_rollno[$i] < $request->start_rollno[$i])
                       $request->end_rollno[$i]= $request->start_rollno[$i];
                   
                   $faculties=[]; 
                if($request->faculty[$i] == 'All')
                    $faculties = Faculty::pluck('name');
                 else
                 $faculties[] =  Faculty::findOrFail(2)->value('name');
                //dd($faculties);
                for($k=0; $k<count($faculties); $k++)
                {
                    for($j=$request->start_rollno[$i]; $j<=$request->end_rollno[$i]; $j++ )
                    {   
                        $no = str_pad($j, 3, '0', STR_PAD_LEFT);
                        $roll_no[]=$college.$no.$faculties[$k].$request->year[$i];
                    }
                }
            }      

            $users = User::whereIn('roll_no', $roll_no)->get();
             
             if($request->ind_rollno) 
             {  
                foreach($request->ind_rollno as $roll) 
                    $i_rollno[] = $college.$roll;
                
                if($i_users = User::whereIn('roll_no', $i_rollno)->get())
                    (count($users)) ? $users->merge($i_users) : $users = $i_users;
                                  
             }
            //dd($users);
                            
        }else
        {
              Validator::make($request->all(), [
            'content' => 'required|max:10000',
            'tags' => 'required|array|max:20',
            'tags.*' => 'required|max:255|string',
            'image' => 'nullable|file|image|max:5120'
            ])->validate();
        }

        $post= new Post;

        $post->content=$request->content;
        $post->author_id=Auth::user()->id;

        $tag_ids=[]; 
       //inserting new tags created by user
        if($post->save())
        {  
                
            foreach($request->tags as $tag)
            {   
                $string=str_split($tag);
                if($string[0]=='@')
                {   
                    $string=array_slice($string, 1);
                    $ntag=implode($string);

                    $new_tag=new Tag;
                    $new_tag->name=$ntag;
                    $new_tag->created_by=Auth::user()->id;
                    //dd($new_tag->name);
                    $new_tag->save();

                    array_push($tag_ids,  $new_tag->id);
                }
                else
                    array_push($tag_ids,  $tag);
            }//end inserting new tags

         
             $msg = '';
            //save image
            if($request->hasfile('image') && $request->file('image')->isValid())
            {

                $image=$request->file('image');
                $ext=$image->extension();
                $img_name=time().rand(0,999).'.'.$ext;
                $dir='images/posts';
                $path = 'images/posts/'.$img_name;

                if (!file_exists(public_path($dir))) 
                {
                    Storage::makeDirectory($dir, 0775, true);
                }

               Image::make($image)->resize(720, 720,
                                        function ($constraint) {
                                           $constraint->aspectRatio();
                                            $constraint->upsize();
                                        })->save(public_path($path));

               //$post->imgs()->create([ 'filepath' => 'images/posts/555555555.png' ]);

                //dd($path);
                //$comment = new App\Comment(['message' => 'A new comment.']);
                $img=new Img;
                $img->filepath=$path;
               
                 if( !($post->imgs()->save($img)) )
                    $msg = '. Also Error in uploading image.';
            }


            if($post->tags()->sync($tag_ids, false))
            {   
            
                Session::flash('success', 'successfully added new post to discussions and forums'.$msg);

                if($request->submit == 'Yes')
                {
                  $when = now()->addSeconds(10);
                  $data['owner'] = Auth::user()->name;
                  $data['url'] = route('user.posts.show', $post->slug);
                  Notification::send($users->unique(), (new PostNotification($post, $data))->delay($when));
                }
            
               return redirect()->route('user.posts.show', $post->slug);
            }
            else
                return back()->withErrors('problem  adding tags to the post '.$msg);

        }else
                return back()->withErrors('problem  adding new post to discussions and forums');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with('tags')->first();
        abort_if(!$post, 404);
        $post->increment('view_count');
        return view('user.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->with(['tags', 'imgs'])->first();
        if(Auth::user()->owns($post, 'author_id'))
        { 
            $tags = Tag::all();
            return view('user.posts.edit', ['post' => $post, 'tags' => $tags]);
        } else
         return back()->withErrors('Permission denied. You are not the owner of this post');   
            
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->with('tags')->first();

        if(Auth::user()->owns($post, 'author_id'))
        {    
            Validator::make($request->all(), [
                'content' => 'required|max:10000',
                'tags' => 'required|array|max:20',
                'tags.*' => 'required|max:255|string',
                'image' => 'nullable|file|image|max:5120'
            ])->validate();

            $post->content=$request->content;

            $tag_ids=[]; 
           //inserting new tags created by user
            if($post->save())
            {  
                foreach($request->tags as $tag)
                {   
                    $string=str_split($tag);
                    if($string[0]=='@')
                    {   
                        $string=array_slice($string, 1);
                        $ntag=implode($string);

                        $new_tag=new Tag;
                        $new_tag->name=$ntag;
                        $new_tag->created_by=Auth::user()->id;
                        //dd($new_tag->name);
                        $new_tag->save();

                        array_push($tag_ids,  $new_tag->id);
                    }
                    else
                        array_push($tag_ids,  $tag);
                }//end inserting new tags

             
                 $msg = '';
                //save image
                if($request->hasfile('image') && $request->file('image')->isValid())
                {   
                    Storage::delete($post->imgs()->first()->filepath);
                    Img::where('imagable_id', $post->id)->where('imagable_type', 'App\Post')->delete();
                    

                    $image=$request->file('image');
                    $ext=$image->extension();
                    $img_name=time().rand(0,999).'.'.$ext;
                    $dir='images/posts';
                    $path = 'images/posts/'.$img_name;

                    if (!file_exists(public_path($dir))) 
                    {
                        Storage::makeDirectory($dir, 0775, true);
                    }

                   Image::make($image)->resize(600, 350,
                                            function ($constraint) {
                                                $constraint->upsize();
                                            })->save(public_path($path));

                   $img=new Img;
                    $img->filepath=$path;
                   
                     if( !($post->imgs()->save($img)) )
                        $msg = '. Also Error in uploading image.';
                }


                if($post->tags()->sync($tag_ids, false))
                {
                    Session::flash('success', 'successfully updated the post to discussions and forums'.$msg);
                    return redirect()->route('user.posts.show', $post->slug);
                }
                else
                    return back()->withErrors('Error occured in adding tags to the post '.$msg);

            }else
                    return back()->withErrors('Error occured in updated the post ');
        } else
         return back()->withErrors('Permission denied. You are not the owner of this post');       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {  
        $post = Post::where('slug', $slug)->with(['tags', 'imgs'])->first();

        if(Auth::user()->owns($post, 'author_id')) 
        {   
            if($post->delete()) 
            { 
                if( count($post->imgs) )
                {   
                    foreach($post->imgs as $img) 
                    Storage::delete($img->filepath);

                    $post->imgs()->delete();
                }    
                if(count($post->tags)) $post->tags()->detach();
                
                Session::flash('success', 'file '.$post->slug.' was successfully deleted');
                return redirect()->route('user.posts.index');

            } else
                return back()->withErrors('Error occured in deleting the post ');


        }  else
             return back()->withErrors('you dont have permission to delete this project');       

        
    }
}
