<?php
// 网站配置
$config = [
    // 网站名称
    'site_name' => 'Miloce 站点监测',
    
    // UptimeRobot API Keys
    // 支持 Monitor-Specific 和 Read-Only API Keys
    'api_keys' => [
        'ur1735047-6f378fbcc199a76ccb9b72c2',  //只读 API 密钥
    ],
    
    // 显示的日志天数
    'count_days' => 60,
    
    // 是否显示检测站点的链接
    'show_link' => true,
    
    // 导航栏菜单
    'navigation' => [
        [
            'text' => '主页',
            'url' => 'https://www.luozhinet.com/'
        ],
        [
            'text' => '博客',
            'url' => 'https://blog.luozhinet.com/'
        ],
        [
            'text' => 'GitHub',
            'url' => 'https://github.com/miloce/'
        ],
    ],
    
    // API 设置
    'api' => [
        'endpoint' => 'https://api.uptimerobot.com/v2/',
        'format' => 'json',
        'timeout' => 10, // 请求超时时间（秒）
    ]
]; 