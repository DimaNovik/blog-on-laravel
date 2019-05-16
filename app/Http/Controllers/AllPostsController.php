<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class AllPostsController extends Controller
{
    public function index() {
        $posts = Post::where('status', 0)->paginate(9);

        return view('pages.allposts.index', ['posts'=>$posts]);
    }
}
