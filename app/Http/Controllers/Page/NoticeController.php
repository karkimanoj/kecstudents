<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notice;
use Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::paginate(12);
        return view('pages.notices.index', ['notices' => $notices]); 

    }

    public function show($id)
    {
        $notice = Notice::findOrFail($id);
        abort_if(!$notice, 404);
        return view('pages.notices.show', ['notice' => $notice]);
    }
}
