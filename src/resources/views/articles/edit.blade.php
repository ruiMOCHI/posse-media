<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>articles.edit</title>
    @vite('resources/js/quiz.js')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<x-app-layout>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-lg mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-6 text-center">投稿編集</h1>

        @if (session('success'))
            <p class="text-green-500 text-center mb-4">{{ session('success') }}</p>
        @endif
        <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700">タイトル:</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('title')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="details" class="block text-gray-700">詳細:</label>
                <textarea name="details" id="details" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('details') }}</textarea>
                @error('details')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700">画像:</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full">
                @if (!empty($draft['image']))
                    <img src="{{ Storage::url($draft['image']) }}" alt="画像" class="mt-4 w-64 mx-auto">
                @endif
                @error('image')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">更新</button>
        </form>
    </div>
</body>
</x-app-layout>

</html>
