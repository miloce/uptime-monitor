<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/api_functions.php';

header('Content-Type: application/json');

// 获取监控ID
$monitorId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$monitorId) {
    // 返回错误信息
    echo json_encode([
        'status' => 'error',
        'timestamp' => time(),
        'message' => '缺少必要参数：id'
    ]);
    exit;
}

// 获取所有监控数据
$allMonitors = getMonitors($config['api_keys']);

// 查找指定ID的监控
$monitor = null;
foreach ($allMonitors as $m) {
    if ($m['id'] == $monitorId) {
        $monitor = $m;
        break;
    }
}

// 如果找不到监控，返回错误信息
if (!$monitor) {
    echo json_encode([
        'status' => 'error',
        'timestamp' => time(),
        'message' => '未找到指定ID的监控：' . $monitorId
    ]);
    exit;
}

// 返回监控详情
$response = [
    'status' => 'ok',
    'timestamp' => time(),
    'monitor' => $monitor
];

echo json_encode($response); 