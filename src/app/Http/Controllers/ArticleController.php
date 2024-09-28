<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ArticleController extends Controller
{
    public function listAdmins()
    {
        $admins = User::where('role', 'admin')->get();
        return view('articles/admin.users.list', compact('admins'));
    }

    public function listAdminsUser()
    {
        $admins = User::where('role', 'user')->get();
        return view('articles.admin.users.listUser', compact('admins'));
    }

    public function destroyUser(User $user)
    {
        $user->delete(); // これでソフトデリートが実行されます
        return redirect()->route('articles.admin.users.listUser')->with('status', 'ユーザーを削除しました！');
    }

    public function storeDraft(Request $request)
    {
        // dd($request);
        // セッションに記事の下書きを保存
        // バリデーション
        $request->validate([
            'title' => 'required|max:255',
            'details' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 画像の保存（セッションには画像のパスのみ保存）
        $imagePath = Session::get('draft.image', null);
        //$imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }    

        Session::put('draft', [
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'image' => $imagePath, // 画像のパスのみ保存 $request->file('image'),
        ]);    

        return back()->with('success', '下書きを保存しました');
    }    

    public function index()
    {
        $articles = Article::all();
        //$articles = Article::where('user_id', auth()->id())->get();
        return view('articles.index', compact('articles'));
    }    

    public function show(Article $article)
    {
        // 記事の詳細を表示する
        return view('articles.show', compact('article'));
    }    

    public function create()
    {
        // セッションから下書きを取得
        $draft = Session::get('draft', [
            'title' => '',
            'details' => '',
            'image' => null,
        ]);    

        return view('articles.create', compact('draft'));
    }    

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|max:255',
            'details' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);    

        // 画像の保存
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }    

        // 記事の保存（ユーザーIDを含む）
        $request->user()->articles()->create([
            'title' => $request->title,
            'details' => $request->details,
            'image' => $imagePath,
        ]);    

        // セッションから下書きを削除
        Session::forget('draft');

        return redirect()->route('articles.index')->with('success', '記事を投稿しました！');
    }    

    public function edit(Article $article)
    {
        // 現在のユーザーが記事の作成者でない場合はエラー
        if ($article->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }    

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        // 現在のユーザーが記事の作成者でない場合はエラー
        if ($article->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }    

        // バリデーション
        $request->validate([
            'title' => 'required|max:255',
            'details' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);    

        // 画像の保存
        if ($request->hasFile('image')) {
            // 古い画像の削除
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }    
            $article->image = $request->file('image')->store('images', 'public');
        }    

        $article->update([
            'title' => $request->title,
            'details' => $request->details,
            'image' => $article->image,
        ]);
        return redirect()->route('articles.index')->with('success', '記事を更新しました！');
    }

    public function destroy(Article $article)
    {
        $article->delete(); // ソフトデリート
        return redirect()->route('articles.index')->with('status', '設問を削除しました！');
    }

    public function storeComment(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $article->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $request->content,
        ]);

        return redirect()->route('articles.show', $article)->with('success', 'コメントを追加しました！');
    }

    public function editComment(Comment $comment)
    {
        // 現在のユーザーが記事の作成者でない場合はエラー
        if ($comment->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        return view('comments.edit', compact('comment'));
    }

    public function updateComment(Request $request, Comment $comment)
    {
        // 現在のユーザーがコメントの作成者でない場合はエラー
        if ($comment->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        // バリデーション
        $request->validate([
            'content' => 'required',
        ]);

        // コメントの更新
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('articles.show', $comment->article_id)->with('success', 'コメントを更新しました！');
    }
    
    public function destroyComment(Comment $comment)
    {
        // 現在のユーザーがコメントの作成者でない場合はエラー
        if ($comment->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        $comment->delete();
        return back()->with('success', 'コメントを削除しました！');
    }

}



// class ArticleController extends Controller
// {
//     public function index()
//     {
//         $articles = Article::all();
//         return view('articles.index', compact('articles'));
//     }

//     public function create()
//     {
//         return view('articles.create');
//     }

//     public function store(Request $request)
//     {
//         // バリデーション
//         $request->validate([
//             'title' => 'required|max:255',
//             'details' => 'required',
//             'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         ]);

//         // 画像の保存
//         $imagePath = null;
//         if ($request->hasFile('image')) {
//             $imagePath = $request->file('image')->store('images', 'public');
//         }

//         // 記事の保存（ユーザーIDを含む）
//         $request->user()->articles()->create([
//         'title' => $request->title,
//         'details' => $request->details,
//         'image' => $imagePath,
//     ]);

//         return redirect()->route('articles.index')->with('success', '記事を投稿しました！');
//     }
// }
