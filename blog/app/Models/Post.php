<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;
    public function getAllPosts()
    {
        return self::with('user', 'category')
        ->orderBy('created_at', 'desc')->paginate(5);
    }
    
    public function getAllUserPosts($userId){
        return self::where('user_id', $userId)->with('user', 'category')
        ->orderBy('created_at', 'desc');
    }
    
    public function getPostsByCategory($categoryId){
        return self::where('category_id', $categoryId)->with('user', 'category')
        ->orderBy('created_at', 'desc')->paginate(4);
    }
    
    public function createPostFromRequest(Request $request){
        $post = new self;
        $post->title = $request->title;
        $post->category_id = $request->category;
        $post->content = $request->content;
        $post->user_id = auth()->user()->id;
        $fileName = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs(
            'posts',
            $fileName,
            'public'
        );
        $post->image = $fileName;
        return $post;
    }
    
    public function updatePostFromRequest(Request $request, $postId){
        $post = self::find($postId);
        $post->title = $request->title;
        $post->category_id = $request->category;
        $post->content = $request->content;
        if($request->hasFile('image')){
        $fileName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs(
                'posts',
                $fileName,
                'public'
            );
            $post->image = $fileName;
        }
        return $post;
    }
    
    public function getImageAttribute($value){
        if($value != null){
            return \Storage::disk('public')->url('posts/'.$value);
        }
        return null;
    }
    
    public function getCreatedAtAttribute($value){
        if($value != null){
            return Carbon::parse($value)->format('F D,Y');
        }
        return null;
    }
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function category(){
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}