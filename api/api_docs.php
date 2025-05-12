<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API文档 - <?php echo $config['site_name']; ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <!-- Material Design Components -->
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- 自定义样式 -->
    <link href="/css/style.css" rel="stylesheet">
    <style>
        .api-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 24px;
        }
        
        .api-section {
            margin-bottom: 32px;
        }
        
        .api-endpoint {
            background-color: #f5f5f5;
            padding: 16px;
            border-radius: 4px;
            font-family: monospace;
            margin: 16px 0;
        }
        
        .api-params {
            margin: 16px 0;
        }
        
        .api-params table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .api-params th, .api-params td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .api-response {
            background-color: #f5f5f5;
            padding: 16px;
            border-radius: 4px;
            font-family: monospace;
            margin: 16px 0;
            white-space: pre;
        }
    </style>
</head>
<body class="mdc-typography">
    <header class="mdc-top-app-bar mdc-top-app-bar--fixed">
        <div class="mdc-top-app-bar__row">
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                <a href="/" class="mdc-icon-button material-icons mdc-top-app-bar__navigation-icon">arrow_back</a>
                <span class="mdc-top-app-bar__title">API文档</span>
            </section>
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end">
                <?php foreach($config['navigation'] as $nav): ?>
                <a href="<?php echo $nav['url']; ?>" class="mdc-button mdc-button--unelevated nav-button">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label"><?php echo $nav['text']; ?></span>
                </a>
                <?php endforeach; ?>
            </section>
        </div>
    </header>

    <main class="mdc-top-app-bar--fixed-adjust">
        <div class="api-container">
            <div class="api-section">
                <h1 class="mdc-typography--headline4">站点监测API文档</h1>
                <p class="mdc-typography--body1">
                    本文档描述了站点监测系统提供的API接口。所有API返回JSON格式的数据。
                </p>
            </div>
            
            <div class="api-section">
                <h2 class="mdc-typography--headline5">API状态</h2>
                <p class="mdc-typography--body1">
                    检查API服务是否正常运行。
                </p>
                <div class="api-endpoint">
                    GET /api/status
                </div>
                <h3 class="mdc-typography--subtitle1">响应示例</h3>
                <div class="api-response">{
    "status": "ok",
    "timestamp": 1629123456,
    "message": "站点监测API正常运行"
}</div>
            </div>
            
            <div class="api-section">
                <h2 class="mdc-typography--headline5">获取所有监控</h2>
                <p class="mdc-typography--body1">
                    获取所有监控站点的状态信息。
                </p>
                <div class="api-endpoint">
                    GET /api/monitors
                </div>
                <h3 class="mdc-typography--subtitle1">参数</h3>
                <div class="api-params">
                    <table>
                        <thead>
                            <tr>
                                <th>参数名</th>
                                <th>类型</th>
                                <th>必填</th>
                                <th>描述</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>format</td>
                                <td>string</td>
                                <td>否</td>
                                <td>返回格式，默认为json</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h3 class="mdc-typography--subtitle1">响应示例</h3>
                <div class="api-response">{
    "status": "ok",
    "timestamp": 1629123456,
    "monitors": [
        {
            "id": 123456,
            "name": "示例网站",
            "url": "https://example.com",
            "type": "HTTP(s)",
            "status": "Up",
            "uptime_ratio_24h": "100",
            "uptime_ratio_7d": "99.98",
            "uptime_ratio_30d": "99.95",
            "average_response_time": 186
        },
        // ...更多监控
    ]
}</div>
            </div>
            
            <div class="api-section">
                <h2 class="mdc-typography--headline5">获取单个监控详情</h2>
                <p class="mdc-typography--body1">
                    获取指定监控站点的详细信息。
                </p>
                <div class="api-endpoint">
                    GET /api/monitor?id={monitor_id}
                </div>
                <h3 class="mdc-typography--subtitle1">参数</h3>
                <div class="api-params">
                    <table>
                        <thead>
                            <tr>
                                <th>参数名</th>
                                <th>类型</th>
                                <th>必填</th>
                                <th>描述</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>id</td>
                                <td>integer</td>
                                <td>是</td>
                                <td>监控ID</td>
                            </tr>
                            <tr>
                                <td>format</td>
                                <td>string</td>
                                <td>否</td>
                                <td>返回格式，默认为json</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h3 class="mdc-typography--subtitle1">响应示例</h3>
                <div class="api-response">{
    "status": "ok",
    "timestamp": 1629123456,
    "monitor": {
        "id": 123456,
        "name": "示例网站",
        "url": "https://example.com",
        "type": "HTTP(s)",
        "status": "Up",
        "uptime_ratio_24h": "100",
        "uptime_ratio_7d": "99.98",
        "uptime_ratio_30d": "99.95",
        "all_time_uptime_ratio": "99.92",
        "average_response_time": 186,
        "logs": [
            {
                "datetime": 1629120000,
                "type": 2,
                "duration": 0,
                "reason": ""
            },
            // ...更多日志
        ]
    }
}</div>
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
</body>
</html> 