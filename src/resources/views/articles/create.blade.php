<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>articles.create</title>
    @vite('resources/js/quiz.js')
</head>

<x-app-layout>
        <body class="bg-gray-100 flex items-center justify-center min-h-screen">
            <div class="bg-white p-8 rounded shadow-md w-full max-w-lg mx-auto mt-8">
                <h1 class="text-2xl font-bold mb-6 text-center">新規記事投稿</h1>
        
                @if (session('success'))
                    <p class="text-green-500 text-center mb-4">{{ session('success') }}</p>
                @endif
                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">タイトル:</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $draft['title']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="details" class="block text-gray-700">詳細:</label>
                        <textarea name="details" id="details" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('details', $draft['details']) }}</textarea>
                        @error('details')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700">画像:</label>
                        <input type="file" name="image" id="image" class="mt-1 block w-full">
                        @if (!empty($draft['image']))
                            <img src="{{ Storage::url($draft['image']) }}" alt="下書き画像" class="mt-4 w-64 mx-auto">
                        @endif
                        @error('image')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">投稿</button>

    </form>
    <form action="{{ route('articles.storeDraft') }}" method="POST" enctype="multipart/form-data" id="draftForm">
        @csrf
        <input type="hidden" name="title" id="titleSession">
        <input type="hidden" name="details" id="detailsSession">
        <input type="hidden" name="image" id="imageSession">
        <button type="submit" id="saveDraftButton">下書きを保存</button>
    </form>

    <script>
        // 下書き保存ボタンがクリックされたときに、投稿用フォームの値を取得し、下書き用フォームにコピーする
        document.getElementById('saveDraftButton').addEventListener('click', function() {
            // 投稿用フォームの値を取得
            var title = document.getElementById('title').value;
            var details = document.getElementById('details').value;
            var image = document.getElementById('image').files[0]; // 画像ファイルを取得

            // 下書き用フォームの隠しフィールドに値をコピー
            document.getElementById('titleSession').value = title;
            document.getElementById('detailsSession').value = details;

            // 画像ファイルはhidden inputでは送信できないので、そのままフォームにセット
            if (image) {
                var draftImageInput = document.getElementById('imageSession');
                var clone = document.getElementById('image').cloneNode(); // 画像フィールドをクローン
                draftImageInput.replaceWith(clone);
                document.getElementById('draftForm').appendChild(clone);
            }

            // 下書き用フォームを送信
            document.getElementById('draftForm').submit();
        });
    </script>
</body>
</x-app-layout>

</html>
