<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Anonses;
use App\User;
use App\Pages;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        $posts = Post::where('status', 0)->orderBy('id', 'desc')->take(9)->get();

        return view('pages.index', ['posts'=>$posts]);
    }

    public function show($slug) {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('post'));
    }

    public function anons($id) {
        $anons = Anonses::where('id', $id)->firstOrFail();

        return view('pages.anons', compact('anons'));
    }

    public function pages($slug) {
        $pages = Pages::where('slug', $slug)->firstOrFail();

        return view('pages.pages', compact('pages'));
    }
}
