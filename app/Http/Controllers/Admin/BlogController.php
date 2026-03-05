<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = BlogPost::latest()->paginate(10);
        return view('dashboard.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('dashboard.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'author' => 'nullable|string|max:255',
        ]);

        $data = $request->except('thumbnail');
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        $data['excerpt'] = Str::limit(strip_tags($request->content), 150);
        
        if ($request->status == 'published') {
            $data['published_at'] = Carbon::now();
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs', 'public');
        }

        BlogPost::create($data);

        return redirect()->route('dashboard.blogs.index')->with('success', 'Blog berhasil ditambahkan!');
    }

    public function edit(BlogPost $blog)
    {
        return view('dashboard.blogs.edit', compact('blog'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'author' => 'nullable|string|max:255',
        ]);

        $data = $request->except('thumbnail');
        
        // Update slug if title changed (optional, usually better to keep for SEO but user might want it updated)
        if ($blog->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }

        $data['excerpt'] = Str::limit(strip_tags($request->content), 150);

        if ($request->status == 'published' && !$blog->published_at) {
            $data['published_at'] = Carbon::now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('dashboard.blogs.index')->with('success', 'Blog berhasil diperbarui!');
    }

    public function destroy(BlogPost $blog)
    {
        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }
        $blog->delete();

        return redirect()->route('dashboard.blogs.index')->with('success', 'Blog berhasil dihapus!');
    }

    /**
     * Handle image upload from CKEditor/TinyMCE
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('blog-content', 'public');
            $url = asset('storage/' . $path);
            return response()->json(['uploaded'=> 1, 'url' => $url]);
        }
    }
}
