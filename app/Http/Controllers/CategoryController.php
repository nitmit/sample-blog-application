<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class CategoryController extends Controller
{
    public function showCategoryPosts($id){
        $post = new Post;
        $posts = $post->getPostsByCategory($id);
        $category = Category::find($id);
        return view('posts.by_category', compact('posts', 'category'));
    }
}