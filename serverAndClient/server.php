<?php
// swoole 服务端 请参考
// https://wiki.swoole.com/#/server/init

// 创建 server 服务器 这只能链接的 ip 和 访问的端口号
$server = new swoole_server("0.0.0.0", 9501);

// 各个配置参数详情
// https://wiki.swoole.com/#/server/setting
$server->set([
    'worker_num' => 2 // 设置进程
]);

// 粘包 处理的 配置
//1、要保证业务数据里不能出现package_eof设置的字符,否则将导致数据错误了。
//2、可以手动拆包，去掉open_eof_split,自行 explode("\r\n", $data),然后循环发送
$server->set([
    'open_eof_check' => true, // 开启粘包检测
    'package_eof' => "\r\n", // 设置EOL
    'open_eof_split' => true  // 开启自动拆分
]);

// 查看 进程 id ps -aux | grep server.php
$server->set([
    'daemonize' => true, // 开启守护进程
    'log_file' => __DIR__ . '/server.log' // 日志文件
]);

// swoole 各个 on 事件详情
// https://wiki.swoole.com/#/server/events
// 当链接进入时
$server->on('connect', function($server, $fd){
    echo '有新的客户端连入：' . $fd . PHP_EOL;
    $server->send($fd, '你链接成功了呢！');
});

// 当收到消息时
$server->on('receive', function($server, $fd, $from_id, $data){
    echo '收到信息了：' . $data . PHP_EOL;
    $server->send($fd, '服务器给你发消息了:' . $data);
});

// 当关闭链接时
$server->on('close', function($server, $fd){
    echo sprintf('编号为 %s 的客户端关闭了' . PHP_EOL , $fd );
});

// $service 支持的各个函数
// https://wiki.swoole.com/#/server/methods
$server->start();