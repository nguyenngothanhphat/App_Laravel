<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsCreateRequest;
use Illuminate\Http\Request;

use App\Category;
use App\Photo;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(5);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        $input = $request->all();

        $user  = Auth::user();

        if($file = $request->file('photo_id'))
        {
            $name = time() . "_" . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['path' => $name]);

            $input['photo_id'] = $photo->id;
        }

        $user->posts()->create($input);
        return redirect('/admin/posts');
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
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $category = Category::pluck('name', 'id')->all();

        return view('admin.posts.edit', compact('post', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsCreateRequest $request, $id)
    {
        $input = $request->all();

        $user  = Auth::user();

        if($file = $request->file('photo_id'))
        {
            $name = time() . "_" . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['path' => $name]);

            $input['photo_id'] = $photo->id;
        }

        $user->posts()->whereId($id)->first()->update($input);
        return redirect('admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        unlink(public_path(). $post->photo->path);

        $post->delete();

        session()->flash('delete_message', 'The post has been deleted successfully');

        return redirect('admin/posts');
    }

    public function getPost($slug)
    {
        $post = Post::findBySlugOrFail($slug);

        $categories = Category::all();

        $comments = $post->comments()->where('is_active', 1)->orderBy('id', 'DESC')->get();
        
        return view('client.blog-post', compact('post', 'comments', 'categories'));
    }
}
