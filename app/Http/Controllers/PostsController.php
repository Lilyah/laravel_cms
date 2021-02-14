<?php

namespace App\Http\Controllers;

use App\Post;

use App\Category;

use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Posts\CreatePostsRequest;

use App\Http\Requests\Posts\UpdatePostsRequest;

 

// use App\Http\Requests\Posts\UpdatePostsRequest;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verifyCategoryCount')->only(['create', 'store']);

    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create')->with('categories', Category::all());


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        // upload the img to storage
        //$image = $request->image->store('posts'); // the result of store fnkcion in the posts folder

        $image = $request->image->store('posts','public');


        // create the post
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'category_id' => $request->category, //it only 'category' because in create.blade is <select name="category" ....>
            //'image'=>$request->file('image')->store('posts','public')
            'image' => $image //the path to the newly created image



        ]);

        // flash msg for success
        session()->flash('success', 'Post created successfully.');

        // redirect user
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        return view('posts.create')->with('post', $post)->with('categories', Category::all());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(UpdatePostsRequest $request, Pоst $post)
    public function update(UpdatePostsRequest $request, Post $post)
    {

        $data = $request->only(['title', 'description', 'content', 'published_at', 'category']);
        $post->category()->associate($request->category); // with this line when updating post and click different category it works

        // check if new image
        if ($request->hasFile('image')){

        // uploadet it
        $image = $request->image->store('posts', 'public'); //to the posts folder

        /**
         * $post->deleteImage(); 
         * is comming from App/Post.php model, 
         * where I wrote a function coled deleteImage()
         */ 
         //delete the old one
        $post->deleteImage(); 

        $data['image'] = $image;

        }


        //update the atributes
        $post->update($data);


        // flash  msg
        session()->flash('success', 'Post updated successfully.');

        // redirect
        return redirect(route('posts.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $post = Post::withTrashed()->where('id', $id)->firstOrFail(); // "$id" is th id from the url

        if($post->trashed()){
        
         /**
         * $post->deleteImage(); 
         * is comming from App/Post.php model, 
         * where I wrote a function coled deleteImage()
         */ 
            $post->deleteImage(); 
            $post->forceDelete();
            session()->flash('success', 'Post deleted successfully.');

        } else {

            $post->delete();
            session()->flash('success', 'Post trashed successfully.');

        }


        return redirect(route('posts.index'));

    }



/**
     * Display a list of all trashed posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        //
        $trashed = Post::onlyTrashed()->get(); // it will fetch all posts with those who has been trashed
        
        // return view('posts.index')->withPosts($trashed); // one way 
        return view('posts.index')->with('posts', $trashed); // second way

    }


    public function restore($id)
    {

        $post = Post::withTrashed()->where('id', $id)->firstOrFail(); // "$id" is th id from the url

        $post->restore();

        session()->flash('success', 'Post restored successfully.');

        return redirect()->back(); //back() take back the user where it's comming from


    }

}