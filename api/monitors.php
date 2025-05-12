<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/api_functions.php';

header('Content-Type: application/json');

// 获取格式参数
$format = isset($_GET['format']) ? $_GET['format'] : 'json';

// 获取监控数据
$monitors = getMonitors($config['api_keys']);

// 简化返回数据，移除不必要的字段
$simplifiedMonitors = [];
foreach ($monitors as $monitor) {
    $simplifiedMonitors[] = [
        'id' => $monitor['id'],
        'name' => $monitor['friendly_name'],
        'url' => $monitor['url'],
        'type' => $monitor['type'],
        'status' => $monitor['status'],
        'uptime_ratio_24h' => $monitor['uptime_ratio_24h'],
        'uptime_ratio_7d' => $monitor['uptime_ratio_7d'],
        'uptime_ratio_30d' => $monitor['uptime_ratio_30d'],
        'average_response_time' => $monitor['average_response_time']
    ];
}

// 返回数据
$response = [
    'status' => 'ok',
    'timestamp' => time(),
    'monitors' => $simplifiedMonitors
];

echo json_encode($response); 