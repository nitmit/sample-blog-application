<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Validator;

class PostController extends Controller
{
    private $post;
    
    public function __construct(Post $post){
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('category_id')){
            $posts = $this->post->getAllUserPosts(auth()->user()->id)
                        ->where('category_id', $request->category_id)
                        ->paginate(5)->appends('category_id', $request->category_id);
        }else{
            $posts = $this->post->getAllUserPosts(auth()->user()->id)->paginate(5);
        }
        
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'image' => 'required|mimes:jpeg,jpg,png',
            'content' => 'required|min:50',
            'category' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        
        $post = $this->post->createPostFromRequest($request);
        $post->save();
        
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->post->find($id);
        $prevPostId = $this->post->where('id', '<', $post->id)->max('id');
        $nextPostId= $this->post->where('id', '>', $post->id)->min('id');
        $prevPost = ($prevPostId != null) ? Post::find($prevPostId) : null;
        $nextPost = ($nextPostId != null) ? Post::find($nextPostId) : null;
        return view('posts.details', compact('post', 'prevPost', 'nextPost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
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
        $post = $this->post->find($id);
        if($post){
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'image' => 'nullable|mimes:jpeg,jpg,png',
                'content' => 'required|min:50',
                'category' => 'required'
            ]);
            
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()], 200);
            }
            
            $post = $this->post->updatePostFromRequest($request, $post->id);
            $post->save();
            
            return response()->json(200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->post->find($id);
        if($post){
            $post->delete();
            return response()->json(200);
        }
    }
}