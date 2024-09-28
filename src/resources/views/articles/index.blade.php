{{-- <!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>articles.index</title>
    @vite('resources/js/quiz.js')
</head>

<x-app-layout>

    <body class="bg-gray-100">
        <h1 class="text-3xl font-bold mb-4">記事一覧</h1>
        <a href="{{ route('articles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">新規記事投稿</a>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            @foreach ($articles as $article)
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-bold mb-2">
                        <!-- タイトルをクリックすると詳細ページに移動 -->
                        <a href="{{ route('articles.show', $article->id) }}"
                            class="text-blue-500 hover:underline">{{ $article->title }}</a>
                    </h2>
                    <p class="text-gray-700 mb-4">{{ $article->details }}</p>
                    @if ($article->image)
                        <img src="{{ Storage::url($article->image) }}" alt="記事画像"
                            class="w-full h-48 object-cover mb-4 rounded">
                    @endif
                    <p class="text-gray-600">投稿者: {{ $article->user->name }}</p> <!-- 投稿者の表示 -->
                </div>
                <!-- ログインユーザーが記事の投稿者の場合に編集リンクを表示 -->
                @if (auth()->check() && auth()->user()->id === $article->user_id)
                    <form>
                        <a href="{{ route('articles.edit', $article->id) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded">編集</a>
                    </form>
                    <form id="delete-form-{{ $article->id }}" action="{{ route('articles.destroy', $article->id) }}"
                        method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <a href="#" class="bg-red-500 text-white px-4 py-2 rounded"
                            onclick="event.preventDefault(); if(confirm('本当に削除しますか？')) { document.getElementById('delete-form-{{ $article->id }}').submit(); }">削除</a>
                    </form>
                @endif
            @endforeach
        </div>
    </body>
</x-app-layout>

</html> --}}


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>articles.index</title>
    @vite('resources/js/quiz.js')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<x-app-layout>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">記事一覧</h1>
        <a href="{{ route('articles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">新規記事投稿</a>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            @foreach ($articles as $article)
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-bold mb-2">
                        <a href="{{ route('articles.show', $article->id) }}" class="text-blue-500 hover:underline">{{ $article->title }}</a>
                    </h2>
                    <p class="text-gray-700 mb-4">{{ $article->details }}</p>
                    @if ($article->image)
                        <img src="{{ Storage::url($article->image) }}" alt="記事画像" class="w-full h-auto object-contain mb-4 rounded">
                    @endif
                    <p class="text-gray-600">投稿者: {{ $article->user->name }}</p>
                    @if (auth()->check() && auth()->user()->id === $article->user_id)
                        <div class="flex space-x-2 mt-4">
                            <form>
                                <a href="{{ route('articles.edit', $article->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">編集</a>
                            </form>
                            <form id="delete-form-{{ $article->id }}" action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="bg-red-500 text-white px-4 py-2 rounded" onclick="event.preventDefault(); if(confirm('本当に削除しますか？')) { document.getElementById('delete-form-{{ $article->id }}').submit(); }">削除</a>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</body>
</x-app-layout>

</html>
