<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>articles.storeDraft</title>
    @vite('resources/js/quiz.js')
</head>

<body>
    <h1>新規記事投稿</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">タイトル:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $draft['title']) }}">
            @error('title')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="details">詳細:</label>
            <textarea name="details" id="details">{{ old('details', $draft['details']) }}</textarea>
            @error('details')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="image">画像:</label>
            <input type="file" name="image" id="image">
            @error('image')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">投稿</button>
    </form>
</body>

</html>
