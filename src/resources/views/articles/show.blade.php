<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>articles.show</title>
    @vite('resources/js/quiz.js')
</head>

<x-app-layout>

    <body class="bg-gray-100">
        <div class="container mx-auto p-4">
            <div class="bg-white p-6 rounded shadow-md max-w-2xl mx-auto">
                <h1 class="text-3xl font-bold mb-4 text-center">{{ $article->title }}</h1>
                <p class="text-gray-700 mb-4 text-center">{{ $article->details }}</p>
                @if ($article->image)
                    <img src="{{ Storage::url($article->image) }}" alt="記事画像" width="500"
                        class="w-full h-auto mb-4 rounded">
                @endif
                <p class="text-gray-600 text-center">投稿者: {{ $article->user->name }}</p>

                <h2 class="text-2xl font-bold mt-6 mb-4 text-center">コメント</h2>
                @foreach ($article->comments as $comment)
                    <div class="bg-gray-100 p-4 rounded">
                        <p class="text-gray-800">{{ $comment->content }}</p>
                        <p class="text-gray-600 text-sm">コメント投稿者: {{ $comment->user->name }}</p>
                    </div>
                    @if (auth()->check() && auth()->user()->id === $comment->user_id)
                    <div class="flex space-x-2">
                        <form>
                            <a href="{{ route('comments.edit', $comment) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">編集</a>
                        </form>
                        <form id="delete-comment-form-{{ $comment->id }}" action="{{ route('comments.destroy', $comment) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="bg-red-500 text-white px-4 py-2 rounded" onclick="event.preventDefault(); if(confirm('本当に削除しますか？')) { document.getElementById('delete-comment-form-{{ $comment->id }}').submit(); }">削除</a>
                        </form>
                    </div>
                    @endif
                @endforeach

                @auth
                    <form action="{{ route('comments.store', $article) }}" method="POST" class="mt-6">
                        @csrf
                        <textarea name="content" rows="4" class="w-full p-2 border rounded" required></textarea>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">コメントを追加</button>
                    </form>
                @endauth
                <div class="text-center mt-6">
                    <a href="{{ route('articles.index') }}" class="text-blue-500 hover:underline">一覧に戻る</a>
                </div>
            </div>
        </div>
    </body>
</x-app-layout>

</html>
