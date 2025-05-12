<?php
// 检查是否请求API文档页面
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if ($requestUri === '/api/' || $requestUri === '/api') {
    require_once __DIR__ . '/api_docs.php';
    exit;
}

// 否则加载主页
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/api_functions.php';

// 获取监控数据
$monitors = getMonitors($config['api_keys']);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['site_name']; ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <!-- Material Design Components -->
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- 自定义样式 -->
    <link href="/css/style.css" rel="stylesheet">
    <style>
        /* 加载画面样式 */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }
        
        .loader {
            width: 80px;
            height: 80px;
            position: relative;
        }
        
        .loader-circle {
            width: 100%;
            height: 100%;
            border: 4px solid transparent;
            border-top-color: #6200ee;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        .loader-inner-circle {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 50px;
            height: 50px;
            border: 4px solid transparent;
            border-top-color: #03dac6;
            border-radius: 50%;
            animation: spin 0.8s linear infinite reverse;
        }
        
        .loader-text {
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 16px;
            color: #6200ee;
            white-space: nowrap;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>
<body class="mdc-typography">
    <!-- 加载画面 -->
    <div class="loader-container" id="loader">
        <div class="loader">
            <div class="loader-circle"></div>
            <div class="loader-inner-circle"></div>
            <div class="loader-text"><?php echo $config['site_name']; ?> 加载中...</div>
        </div>
    </div>

    <header class="mdc-top-app-bar mdc-top-app-bar--fixed">
        <div class="mdc-top-app-bar__row">
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                <span class="mdc-top-app-bar__title"><?php echo $config['site_name']; ?></span>
            </section>
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end">
                <?php foreach($config['navigation'] as $nav): ?>
                <a href="<?php echo $nav['url']; ?>" class="mdc-button mdc-button--unelevated nav-button">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label"><?php echo $nav['text']; ?></span>
                </a>
                <?php endforeach; ?>
                <a href="/api/" class="mdc-button mdc-button--unelevated nav-button">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label">API文档</span>
                </a>
            </section>
        </div>
    </header>

    <main class="mdc-top-app-bar--fixed-adjust">
        <div class="page-container">
            <!-- 状态概览 -->
            <div class="status-overview mdc-card">
                <h2 class="mdc-typography--headline5">状态概览</h2>
                <div class="status-grid">
                    <div class="status-item">
                        <div class="status-count"><?php echo count($monitors); ?></div>
                        <div class="status-label">总监控</div>
                    </div>
                    <div class="status-item">
                        <div class="status-count" id="up-count">0</div>
                        <div class="status-label">在线</div>
                    </div>
                    <div class="status-item">
                        <div class="status-count" id="down-count">0</div>
                        <div class="status-label">离线</div>
                    </div>
                    <div class="status-item">
                        <div class="status-count" id="paused-count">0</div>
                        <div class="status-label">暂停</div>
                    </div>
                </div>
            </div>

            <!-- 监控列表 -->
            <div class="monitors-container">
                <?php foreach($monitors as $monitor): ?>
                <div class="monitor-card mdc-card" onclick="window.location.href='/detail?id=<?php echo $monitor['id']; ?>'">
                    <div class="mdc-card__primary-action">
                        <div class="monitor-header">
                            <div class="monitor-status status-<?php echo strtolower($monitor['status']); ?>"></div>
                            <h3 class="mdc-typography--headline6"><?php echo $monitor['friendly_name']; ?></h3>
                            <?php if($config['show_link'] && !empty($monitor['url'])): ?>
                            <a href="<?php echo $monitor['url']; ?>" target="_blank" class="mdc-icon-button material-icons" aria-label="访问网站" onclick="event.stopPropagation();">
                                <div class="mdc-icon-button__ripple"></div>
                                open_in_new
                            </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="monitor-uptime">
                            <div class="uptime-label">过去<?php echo $config['count_days']; ?>天可用率</div>
                            <div class="uptime-bars">
                                <?php foreach($monitor['daily_ratios'] as $ratio): ?>
                                <div class="uptime-bar" style="height: <?php echo $ratio; ?>%;" 
                                     data-ratio="<?php echo $ratio; ?>%"></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="monitor-stats">
                            <div class="stat-item">
                                <div class="stat-label">过去24小时</div>
                                <div class="stat-value"><?php echo $monitor['uptime_ratio_24h']; ?>%</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">过去7天</div>
                                <div class="stat-value"><?php echo $monitor['uptime_ratio_7d']; ?>%</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">过去30天</div>
                                <div class="stat-value"><?php echo $monitor['uptime_ratio_30d']; ?>%</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">平均响应时间</div>
                                <div class="stat-value"><?php echo $monitor['average_response_time']; ?>ms</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>© <?php echo date('Y'); ?> <?php echo $config['site_name']; ?></p>
            <p>由 <a href="https://uptimerobot.com/" target="_blank">UptimeRobot</a> 提供监控支持</p>
        </div>
    </footer>

    <!-- Material Design JavaScript -->
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <!-- 自定义脚本 -->
    <script src="/js/script.js"></script>
</body>
</html> 