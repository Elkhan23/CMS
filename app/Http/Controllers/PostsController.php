<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Tag;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePostsRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreatePostsRequest $request)
    {
        //uploading image
        $image=$request->image->store('posts');
        $post = Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'image'=>$image,
            'published_at'=>$request->published_at,
            'category_id'=>$request->category,
            'user_id' => auth()->user()->id
        ]);
        if($request->tags){
            $post->tags()->attach($request->tags);
        }
        session()->flash('success', 'Post created successfuly');
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|\Illuminate\Http\Response|View
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Application|RedirectResponse|\Illuminate\Http\Response|Redirector
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'content', 'published_at']);
        $post['category_id'] = $request->category;

        //check if new image
        if($request->hasFile('image')){

        //upload
        $image = $request->image->store('posts');

        //delete old image
        $post->deleteImage();

        $data['image'] = $image;
        }

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        //update attributes
        $post->update($data);

        session()->flash('success', 'Post updated successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|RedirectResponse|\Illuminate\Http\Response|Redirector
     */
    public function destroy($id)
    {
        $post= Post::withTrashed()->where('id', $id)->firstOrFail();
        if($post->trashed()){
            $post->deleteImage();
            $post->forceDelete();
        }else{
            $post->delete();
        }
        session()->flash('success', 'Post deleted successfully');
        return redirect(route('posts.index'));
    }

    /**
     * Display a list all trashed posts.
     *

     * @return Application|Factory|\Illuminate\Http\Response|View
     */
    public function trashed(){
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->with('posts', $trashed);
    }

    public function restore ($id){

        $post= Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();

        session()->flash('success', 'Post restored successfully');

        return redirect()->back();
    }

    public function __construct(){
        $this->middleware('verifyCategoriescount')->only('create', 'store');
    }
}
