<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit.blade.php</title>
    @vite('resources/js/quiz.js')
</head>

<x-app-layout>
<body>
    <h1>コメント編集</h1>

    <form action="{{ route('comments.update', $comment) }}" method="POST">
        @csrf
        @method('PUT')
        <textarea name="content" rows="4" required>{{ $comment->content }}</textarea>
        <button type="submit">更新</button>
    </form>

    <a href="{{ route('articles.show', $comment->article_id) }}">戻る</a>
</body>
</x-app-layout>
</html>
