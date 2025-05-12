<?php
// 检测是否在Vercel环境中运行
function isVercelEnvironment() {
    return isset($_SERVER['VERCEL']) || isset($_SERVER['NOW_REGION']);
}

// 获取配置值，优先使用环境变量
function getConfigValue($key, $default = '') {
    // Vercel环境下优先使用环境变量
    if (isVercelEnvironment()) {
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }
    }
    return $default;
}

// 网站配置
$config = [
    // 网站名称 - 支持环境变量
    'site_name' => getConfigValue('SITE_NAME', 'Uptime Monitor'),
    
    // UptimeRobot API Keys - 支持环境变量
    'api_keys' => [
        getConfigValue('UPTIMEROBOT_API_KEY', ''),  // API密钥
    ],
    
    // 显示的日志天数
    'count_days' => 60,
    
    // 是否显示检测站点的链接
    'show_link' => true,
    
    // 导航栏菜单
    'navigation' => [
        [
            'text' => '主页',
            'url' => '/'
        ],
        [
            'text' => 'GitHub',
            'url' => 'https://github.com/miloce/uptime-monitor'
        ],
    ],
    
    // API 设置
    'api' => [
        'endpoint' => 'https://api.uptimerobot.com/v2/',
        'format' => 'json',
        'timeout' => 10, // 请求超时时间（秒）
    ],
    
    // 运行环境信息
    'environment' => [
        'is_vercel' => isVercelEnvironment(),
        'debug' => false, // 是否开启调试模式
    ]
]; 