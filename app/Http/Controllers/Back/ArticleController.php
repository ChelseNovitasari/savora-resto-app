<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('back.article.index', compact('articles'));
    }

    public function create()
    {
        return view('back.article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'status'  => 'required|in:draft,published', // Validasi status
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $file->storeAs('back/article-images', $fileName, 'public');

        Article::create([
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'content' => ($request->content),
            'status'  => $request->status, // Simpan status
            'image'   => $fileName,
        ]);

        return redirect()->route('article.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function show(Article $article)
    {
        $article->increment('views');

        return view('back.article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('back.article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'status'  => 'required|in:draft,published', // Validasi status
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'content' => ($request->content),
            'status'  => $request->status, // Update status
        ];

        if ($request->hasFile('image')) {
            if ($article->image && Storage::disk('public')->exists('back/article-images/' . $article->image)) {
                Storage::disk('public')->delete('back/article-images/' . $article->image);
            }

            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('back/article-images', $fileName, 'public');

            $data['image'] = $fileName;
        }

        $article->update($data);

        return redirect()->route('article.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        if ($article->image && Storage::disk('public')->exists('back/article-images/' . $article->image)) {
            Storage::disk('public')->delete('back/article-images/' . $article->image);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus!'
        ]);
    }
}
