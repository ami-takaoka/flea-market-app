# フリマアプリ

## 環境構築

### Dockerビルド

1. GitHubからリポジトリをクローン
```
git clone git@github.com:ami-takaoka/flea-market-app.git
```

2. Docker Desktopを起動する

3. プロジェクトディレクトリへ移動
```
cd flea-market-app
```

4. Dockerコンテナをビルド・起動
```
docker-compose up -d --build
```

※ MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください

``` bash
mysql:
    platform: linux/x86_64
    image: mysql:8.0.26
    environment:
```

### Laravel環境構築

1. PHPコンテナに入る
```
docker-compose exec php bash
```

2.　依存関係をインストール
```
composer install
```
※ Laravelの権限エラーが出た場合
```
sudo chmod -R 777 src/*
```

3.　.envファイル作成
```
cp .env.example .env
```
.envを以下のように変更してください

※ .env はホスト側（VSCode）で編集してください

```
DB_HOST=mysql
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="${APP_NAME}"

STRIPE_KEY=
STRIPE_SECRET=
```
※ Stripe決済機能を利用する場合は、Stripeアカウントを作成し、
取得したAPIキーを `.env` に設定してください。

※ 権限エラーが出た場合
```
sudo chown -R $USER:$USER .
```

4.　アプリケーションキー生成
```
php artisan key:generate
```

5.　設定キャッシュ削除
```
php artisan config:clear
```

6.　マイグレーション実行
```
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```

8. ストレージリンク作成
``` bash
php artisan storage:link
```

9. アプリ確認
```
http://localhost
```

10. Mailhog確認 
```
http://localhost:8025
```

## 使用技術(実行環境)

- PHP 8.3.0
- Laravel 8.83.27
- MySQL 8.0.26
- Nginx
- Docker
- Docker Compose
- Mailhog
- Stripe Checkout 20.2.0
- HTML
- CSS
- JavaScript

## ER図

![ER図](src/app/docs/er.png)

## URL

- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
- Mailhog：http://localhost:8025/
