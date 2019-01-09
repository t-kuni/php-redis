

```bash
docker run --name some-redis -d redis
```

dockerで

```bash
docker run -it --rm -v $PWD/scripts:/scripts php:7.2.13-cli-alpine3.8 php /scripts/index.php
```