# Laravel インストール方法
1. `docker compose build --no-cache` (ビルドする)
2. `docker compose up -d` (コンテナをたてる)
3. `docker compose exec app sh` (appコンテナに入る)
4. `composer create-project --prefer-dist laravel/laravel . "10.*"` (src配下にLaravel10をインストール)
5. ブラウザで `http://localhost` にアクセスし、Laravelのロゴ入りのトップページが表示されることを確認

<img width="1446" alt="スクリーンショット 2023-06-09 19 39 34" src="https://github.com/posse-ap/template-ph3-website/assets/33271639/69d42fe3-4e3a-4087-91a9-c55640a2671f">


# データベースの作成
1. appコンテナに入っていることを確認
    - (入っていなければ、`docker compose exec app sh`)
2. `src > .env` の内容を以下のように書き換える
    ```
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=website
    DB_USERNAME=posse
    DB_PASSWORD=password
    ```

    <details>
        <summary> .envのファイル全チェック用 (開閉してチェックしてください)</summary>
        以下.envの内容 (APP_KEYは全員違う値になります)
    
        ```
            APP_NAME=Laravel
            APP_ENV=local
            APP_KEY=base64:KLUF4cs983/ayoMuNMhObi+nV0iRZdxVoPWtD/M9fdM=
            APP_DEBUG=true
            APP_URL=http://localhost

            LOG_CHANNEL=stack
            LOG_DEPRECATIONS_CHANNEL=null
            LOG_LEVEL=debug

            DB_CONNECTION=mysql
            DB_HOST=mysql
            DB_PORT=3306
            DB_DATABASE=website
            DB_USERNAME=posse
            DB_PASSWORD=password

            BROADCAST_DRIVER=log
            CACHE_DRIVER=file
            FILESYSTEM_DISK=local
            QUEUE_CONNECTION=sync
            SESSION_DRIVER=file
            SESSION_LIFETIME=120

            MEMCACHED_HOST=127.0.0.1

            REDIS_HOST=127.0.0.1
            REDIS_PASSWORD=null
            REDIS_PORT=6379

            MAIL_MAILER=smtp
            MAIL_HOST=mailpit
            MAIL_PORT=1025
            MAIL_USERNAME=null
            MAIL_PASSWORD=null
            MAIL_ENCRYPTION=null
            MAIL_FROM_ADDRESS="hello@example.com"
            MAIL_FROM_NAME="${APP_NAME}"

            AWS_ACCESS_KEY_ID=
            AWS_SECRET_ACCESS_KEY=
            AWS_DEFAULT_REGION=us-east-1
            AWS_BUCKET=
            AWS_USE_PATH_STYLE_ENDPOINT=false

            PUSHER_APP_ID=
            PUSHER_APP_KEY=
            PUSHER_APP_SECRET=
            PUSHER_HOST=
            PUSHER_PORT=443
            PUSHER_SCHEME=https
            PUSHER_APP_CLUSTER=mt1

            VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
            VITE_PUSHER_HOST="${PUSHER_HOST}"
            VITE_PUSHER_PORT="${PUSHER_PORT}"
            VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
            VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

        ```
    </details>

3. `php artisan migrate` をして、以下のように出力されていれば成功
    ```shell
    2014_10_12_000000_create_users_table ........................................ 274ms DONE
    2014_10_12_100000_create_password_reset_tokens_table ........................ 196ms DONE
    2019_08_19_000000_create_failed_jobs_table .................................. 116ms DONE
    2019_12_14_000001_create_personal_access_tokens_table ....................... 196ms DONE
    ```

# Breeze インストール方法 PHP側
1. appコンテナに入っていることを確認
    - (入っていなければ、`docker compose exec app sh`)
2. `composer require laravel/breeze --dev`
3. `php artisan breeze:install` を入力し、選択肢は以下の通り
    - `Which stack would you like to install?` : 0 (blade)
    - `Would you like to install dark mode support?` : no
    - `Would you prefer Pest tests instead of PHPUnit?` : no

<img width="1054" alt="breeze install php" src="https://github.com/posse-ap/template-ph3-website/assets/33271639/fdc2377a-df2a-486d-83f4-2232b40151e2">


# Breeze インストール方法 NODE側

1. `src/package.json` の内容のscripts部分を以下のように変更する
    - 変更点としてはdevの`"vite"`のみだったのが `"vite --host"` というhostオプションを付け足しています
    ```json
        "scripts": {
            "dev": "vite --host",
            "build": "vite build"
    },
    ```

2. nodeコンテナに入っていることを確認
   - (入っていなければ、`docker compose exec node sh`)
3. `npm install`
4. `npm run dev` or `npm run build`
    - buildは現時点のファイルを読み込んでファイルを生成します (build後にtailwindのクラス名を追加した場合は再度buildが必要です)
    - devは変更点をずっと監視しつづけるのでスペックがギリギリだとパソコンに負荷がかかるかもなので、見た目の編集しないときはbuildを利用してください

# # Breeze インストール方法 画面確認
1. トップページの右上に `Log in` `Register` が表示されていることを確認
2. `Log in` を押すとフォームが正常に表示されていること

<img width="1020" alt="ログイン画面" src="https://github.com/posse-ap/template-ph3-website/assets/33271639/45729c65-e442-43a4-abff-1ad4240ba5fe">
