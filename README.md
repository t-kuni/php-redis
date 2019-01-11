
フォルダ構成は以下の通り
後述のdockerコマンドも、この構成の前提で書いている。

```
php-redis-sample
  └scripts
    ├ index.php
    ├ composer.json
    ├ composer.lock
    └ vendor
```

redisサーバはこれまで通りdockerで立てる。
但し、phpから接続する必要があるので、ネットワークを作成する

```bash
docker network create php-redis
```

redisを起動する

```bash
docker run --name=some-redis --net=php-redis -d redis
```

dockerでcomposerを実行してpredisをインストールする。

```bash
docker run -it --rm \
  --volume $PWD/scripts:/scripts \
  --workdir=/scripts \
  composer install
```

dockerでPHPを実行する

```bash
docker run -it --rm \
  --volume=$PWD/scripts:/scripts \
  --workdir=/scripts \
  --net=php-redis \
  php:7.2.13-cli-alpine3.8 php index.php
```