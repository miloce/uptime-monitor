<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/api_functions.php';

// API状态检查文件
header('Content-Type: application/json');

// 返回系统状态
echo json_encode(['status' => 'ok']); 