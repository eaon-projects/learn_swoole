<?php


// 创建一个SWOOLE客户端 类型参考
// https://wiki.swoole.com/#/client?id=__construct


// 同步客户端
// swoole client 各个方法参考
// https://wiki.swoole.com/#/client?id=%e6%96%b9%e6%b3%95


$client = new swoole_client(SWOOLE_SOCK_TCP) ;

$client->connect('0.0.0.0', 9501) || exit("connect failed Error:($client->errCode)\n");

$response = $client->recv();

echo $response . PHP_EOL;

$client->send("链\r\n接\r\n服\r\n务\r\n器" . "\r\n");

sleep(1);

$response = $client->recv();

echo $response . PHP_EOL;

$client->close();


// 异步客户端
// 安装 swoole ext-async 拓展
//
/*
$client = new Swoole\Async\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC) ;

$client->on('connect', function($cli){
    $cli->send('链接成功');
});

$client->on('receive', function($cli, $data){
    echo 'receive:' . $data . PHP_EOL;
});

$client->on('error', function($cli){
    echo 'connect failed' . PHP_EOL;
});

$client->on('close', function($cli){
    echo 'connect close' . PHP_EOL;
});

$client->connect('0.0.0.0', 9501) || exit("connect failed Error:($client->errCode)\n");
*/
