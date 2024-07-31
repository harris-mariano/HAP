<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:1,2,3')->only(['index', 'show']);
        $this->middleware('checkRole:1,2')->only(['store', 'update']);
    }

    public function index () {
        $articles = Article::orderBy('created_at', 'desc')
                    ->simplePaginate(10, ['*'], 'allArticles');
        
        $userId = Auth::guard('user')->id();
        $userArticles = Article::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->simplePaginate(10, ['*'], 'userArticles');

        return view ('articles.all-articles', [
            'articles' => $articles, 
            'userArticles' => $userArticles]);
    }

    public function show ($id) {
        $article = Article::findOrFail($id); 

        return view('articles.edit-article', [
            'article' => $article,
            ]);
    }

    public function store (Request $request) {
        $validated = $request->validate([
            "title" => ['required'],
            "content" => ['required']
        ]);
        $userId = Auth::guard('user')->id();
        $validated['user_id'] = $userId; 

        $article = new Article();
        $article->fill($validated);
        $article->save();
        return back()->with('message', 'Your article has been published successfully.');
    }

    public function update (Request $request, Article $article) {

        $validated = $request->validate([
            "title" => ['required'],
            "content" => ['required'],
        ]);
        $article->update($validated);

        return back()->with('message', 'Your article has been updated successfully.');
    }
}
