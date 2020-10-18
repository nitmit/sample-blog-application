<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class sharedData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $categories = Category::withCount('posts')->get();
        \View::share ( 'categories', $categories );
        
        $popularPosts = Post::with('user', 'category')->inRandomOrder()->limit(3)->get();
        \View::share ( 'popularPosts', $popularPosts );
        return $next($request);
    }
}