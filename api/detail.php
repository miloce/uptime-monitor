<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/api_functions.php';

// 获取监控ID
$monitorId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$monitorId) {
    header('Location: /');
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

// 如果找不到监控，重定向到首页
if (!$monitor) {
    header('Location: /');
    exit;
}

// 获取监控日志
$logs = isset($monitor['logs']) ? $monitor['logs'] : [];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $monitor['friendly_name']; ?> - <?php echo $config['site_name']; ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <!-- Material Design Components -->
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- 自定义样式 -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/detail.css" rel="stylesheet">
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
            <div class="loader-text"><?php echo $monitor['friendly_name']; ?> 加载中...</div>
        </div>
    </div>

    <header class="mdc-top-app-bar mdc-top-app-bar--fixed">
        <div class="mdc-top-app-bar__row">
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                <a href="/" class="mdc-icon-button material-icons mdc-top-app-bar__navigation-icon">arrow_back</a>
                <span class="mdc-top-app-bar__title"><?php echo $monitor['friendly_name']; ?></span>
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
            <!-- 监控详情 -->
            <div class="detail-card mdc-card">
                <div class="detail-header">
                    <div class="monitor-status status-<?php echo strtolower($monitor['status']); ?>"></div>
                    <h2 class="mdc-typography--headline5"><?php echo $monitor['friendly_name']; ?></h2>
                    <?php if($config['show_link'] && !empty($monitor['url'])): ?>
                    <a href="<?php echo $monitor['url']; ?>" target="_blank" class="mdc-button mdc-button--outlined">
                        <span class="mdc-button__ripple"></span>
                        <i class="material-icons mdc-button__icon">open_in_new</i>
                        <span class="mdc-button__label">访问网站</span>
                    </a>
                    <?php endif; ?>
                </div>
                
                <div class="detail-info">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">监控类型</div>
                            <div class="info-value">
                                <?php
                                $typeMap = [
                                    1 => 'HTTP(s)',
                                    2 => 'Ping',
                                    3 => '端口',
                                    4 => '关键词',
                                ];
                                echo isset($typeMap[$monitor['type']]) ? $typeMap[$monitor['type']] : '未知';
                                ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">状态</div>
                            <div class="info-value status-text-<?php echo strtolower($monitor['status']); ?>">
                                <?php echo $monitor['status']; ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">过去24小时可用率</div>
                            <div class="info-value"><?php echo $monitor['uptime_ratio_24h']; ?>%</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">过去7天可用率</div>
                            <div class="info-value"><?php echo $monitor['uptime_ratio_7d']; ?>%</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">过去30天可用率</div>
                            <div class="info-value"><?php echo $monitor['uptime_ratio_30d']; ?>%</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">全部时间可用率</div>
                            <div class="info-value"><?php echo $monitor['all_time_uptime_ratio']; ?>%</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">平均响应时间</div>
                            <div class="info-value"><?php echo $monitor['average_response_time']; ?>ms</div>
                        </div>
                    </div>
                </div>
                
                <!-- 可用率图表 -->
                <div class="detail-uptime">
                    <h3 class="mdc-typography--headline6">过去<?php echo $config['count_days']; ?>天可用率</h3>
                    <div class="uptime-chart">
                        <div class="uptime-bars detailed">
                            <?php foreach($monitor['daily_ratios'] as $i => $ratio): ?>
                            <div class="uptime-bar" style="height: <?php echo $ratio; ?>%;" 
                                 data-ratio="<?php echo $ratio; ?>%" 
                                 data-date="<?php echo date('Y-m-d', strtotime("-" . ($config['count_days'] - $i - 1) . " days")); ?>"></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="uptime-labels">
                            <div>100%</div>
                            <div>75%</div>
                            <div>50%</div>
                            <div>25%</div>
                            <div>0%</div>
                        </div>
                    </div>
                </div>
                
                <!-- 响应时间图表 -->
                <div class="detail-response-time">
                    <h3 class="mdc-typography--headline6">响应时间</h3>
                    <div class="response-chart">
                        <canvas id="responseTimeChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- 日志列表 -->
            <div class="logs-card mdc-card">
                <h3 class="mdc-typography--headline6">事件日志</h3>
                
                <div class="mdc-data-table">
                    <div class="mdc-data-table__table-container">
                        <table class="mdc-data-table__table">
                            <thead>
                                <tr class="mdc-data-table__header-row">
                                    <th class="mdc-data-table__header-cell">时间</th>
                                    <th class="mdc-data-table__header-cell">类型</th>
                                    <th class="mdc-data-table__header-cell">持续时间</th>
                                    <th class="mdc-data-table__header-cell">原因</th>
                                </tr>
                            </thead>
                            <tbody class="mdc-data-table__content">
                                <?php if (empty($logs)): ?>
                                <tr class="mdc-data-table__row">
                                    <td class="mdc-data-table__cell" colspan="4">暂无日志记录</td>
                                </tr>
                                <?php else: ?>
                                <?php foreach($logs as $log): ?>
                                <tr class="mdc-data-table__row">
                                    <td class="mdc-data-table__cell"><?php echo date('Y-m-d H:i:s', $log['datetime']); ?></td>
                                    <td class="mdc-data-table__cell">
                                        <span class="log-type log-type-<?php echo $log['type']; ?>">
                                            <?php echo $log['type'] == 2 ? '在线' : '离线'; ?>
                                        </span>
                                    </td>
                                    <td class="mdc-data-table__cell">
                                        <?php 
                                        if (isset($log['duration'])) {
                                            echo $log['duration'] . ' 秒';
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="mdc-data-table__cell">
                                        <?php
                                        if (isset($log['reason'])) {
                                            if (is_array($log['reason'])) {
                                                // 优先显示详细信息
                                                echo $log['reason']['detail'] ?? json_encode($log['reason']);
                                            } else {
                                                echo $log['reason'];
                                            }
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <!-- 自定义脚本 -->
    <script src="/js/script.js"></script>
    <script>
        // 响应时间图表
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('responseTimeChart').getContext('2d');
            
            // 假设这里有响应时间数据
            // 实际应用中，这些数据应该从API获取
            const labels = [];
            const responseTimeData = [];
            
            // 生成过去30天的日期标签
            for (let i = 29; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                labels.push(date.toLocaleDateString());
                
                // 随机生成响应时间数据（实际应用中应从API获取）
                responseTimeData.push(Math.floor(Math.random() * 500) + 100);
            }
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '响应时间 (ms)',
                        data: responseTimeData,
                        backgroundColor: 'rgba(33, 150, 243, 0.2)',
                        borderColor: 'rgba(33, 150, 243, 1)',
                        borderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '响应时间 (ms)'
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
            
            // 隐藏加载画面
            const loader = document.getElementById('loader');
            if (loader) {
                setTimeout(() => {
                    loader.classList.add('hidden');
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500);
                }, 300);
            }
        });
    </script>
</body>
</html> 