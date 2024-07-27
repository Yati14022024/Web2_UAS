<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{

    public function index(): View
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index',compact('posts'));
    }

    public function generatePDF()
    {
        $posts = Post::all();
        $pdf = PDF::loadView('posts.pdf', compact('posts'));
        return $pdf->download('posts.pdf');
    }

    public function show($id)
{
    $post = Post::find($id);
    return view('posts.show', compact('post'));
}

    public function add(){
        return view('posts.add');
    }

    public function view(Post $post): View
    {
        Log::info('View method called');
        return view('posts.view', ['post' => $post]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function login(): View
    {
        Log::info('Login method called');
        return view('posts.login');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function store(Request $request)
{
    $validate = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg,ico|max:2048'
    ]);

    $post = new Post();
    $post->title = $validate['title'];
    $post->content = $validate['content'];
        
    if (array_key_exists('image', $validate)){
        $post->image = $validate['image']->store('images', 'public');
    }
    
    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate(['title' => 'required|string|max:255','conten'=>'required|string','image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);

        $post->title = $request->input('title');
        $post->content = $request->input('content');

        if ($request->hasFile('image')){
            if ($post->image){
                Storage::disk('public')->delete($post->image);
            }
            
            $path = $request->file('image')->store('images','public');
            $post->image = $path;

            dd($path, Storage::disk('public')->exists($path));
        }

        $post->save();

        return redirect()->route('posts.index')->with('success','Post update successfully.');
    }
}