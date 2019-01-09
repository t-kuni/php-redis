<?php
require_once 'vendor/autoload.php';

// Redisサーバに接続
$redis = new Predis\Client([
    'host' => 'some-redis',
    'port' => 6379,
]);

// redisの全データ削除
$redis->flushdb();

/*
 * データ形式：文字列
 */
$redis->set('my-key', 'my-value');
var_dump($redis->get('my-key'));
// 出力： 'my-value'

/*
 * データ形式：リスト
 */
$redis->rpush('my-list', 'first');
$redis->rpush('my-list', 'second');
$redis->rpush('my-list', 'third');
var_dump($redis->llen('my-list'));
// 出力： 3
var_dump($redis->lrange('my-list', 0, 2));
// 出力： 'first', 'second', 'third'

/*
 * データ形式：セット
 */
$redis->sadd('my-set', 'alpha');
$redis->sadd('my-set', 'bravo');
$redis->sadd('my-set', 'charlie');
var_dump($redis->smembers('my-set'));
// 出力： 'alpha', 'charlie', 'bravo'

/*
 * データ形式：ハッシュ
 */
$redis->hmset('my-hash', [
    'title'        => 'redisを分かった気になる本',
    'author'       => 'me',
    'publisher'    => 'sya-syu-syo',
    'publish-date' => '2018-01-01 01:01:01',
]);
var_dump($redis->hmget('my-hash', [
    'title',
    'author',
    'publisher'
]));
// 出力： 'redisを分かった気になる本', 'me', 'sya-syu-syo'

/**
 * Pipelineを使用して、複数のコマンドをまとめて発行する
 */
$replies = $redis->pipeline(function($pipe) {
    $pipe->incr('my-counter');
    $pipe->incr('my-counter');
    $pipe->incr('my-counter');
    $pipe->incr('my-counter');
    $pipe->incr('my-counter');
});
var_dump($redis->get('my-counter'));
// 出力： 5