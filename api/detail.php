<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'config.php';

// 获取监控ID
$monitor_id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$monitor_id) {
    header('Location: /');
    exit;
}

// 获取API密钥
$api_key = getenv('UPTIMEROBOT_API_KEY') ?: $config['api_key'];
if (!$api_key) {
    die('请配置UptimeRobot API密钥');
}

// 获取监控详情
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.uptimerobot.com/v2/getMonitors",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'api_key' => $api_key,
        'monitors' => $monitor_id,
        'custom_uptime_ratios' => '1-7-30',
        'response_times' => 1,
        'response_times_limit' => 24,
        'format' => 'json',
        'logs' => 1
    ])
]);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
if (!$data || $data['stat'] !== 'ok' || empty($data['monitors'])) {
    die('获取监控信息失败');
}

$monitor = $data['monitors'][0];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($monitor['friendly_name']); ?> - 监控详情</title>
    <link href="https://cdn.jsdelivr.net/npm/@material/typography@14.0.0/dist/mdc.typography.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@material/card@14.0.0/dist/mdc.card.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@material/ripple@14.0.0/dist/mdc.ripple.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <style>
        .detail-card {
            margin: 16px;
            padding: 16px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }
        .status-up { background-color: #4CAF50; }
        .status-down { background-color: #F44336; }
        .status-pause { background-color: #9E9E9E; }
        .metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }
        .metric-card {
            padding: 16px;
            border-radius: 8px;
            background: #f5f5f5;
        }
        .logs {
            margin-top: 16px;
        }
        .log-item {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="mdc-typography">
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>

    <div class="container">
        <div class="mdc-card detail-card">
            <h1><?php echo htmlspecialchars($monitor['friendly_name']); ?></h1>
            <div class="status-badge <?php
                echo match($monitor['status']) {
                    2 => 'status-up',
                    9 => 'status-down',
                    0 => 'status-pause',
                    default => ''
                };
            ?>">
                <?php
                echo match($monitor['status']) {
                    2 => '正常运行',
                    9 => '停止运行',
                    0 => '已暂停',
                    default => '未知状态'
                };
                ?>
            </div>

            <div class="metrics">
                <div class="metric-card">
                    <h3>24小时在线率</h3>
                    <p><?php echo $monitor['custom_uptime_ratio']; ?>%</p>
                </div>
                <div class="metric-card">
                    <h3>7天在线率</h3>
                    <p><?php echo explode('-', $monitor['custom_uptime_ratio'])[1]; ?>%</p>
                </div>
                <div class="metric-card">
                    <h3>30天在线率</h3>
                    <p><?php echo explode('-', $monitor['custom_uptime_ratio'])[2]; ?>%</p>
                </div>
                <div class="metric-card">
                    <h3>平均响应时间</h3>
                    <p><?php echo array_sum(array_column($monitor['response_times'], 'value')) / count($monitor['response_times']); ?>ms</p>
                </div>
            </div>

            <div class="logs">
                <h2>最近事件</h2>
                <?php foreach ($monitor['logs'] as $log): ?>
                <div class="log-item">
                    <p>
                        <?php
                        $type = match($log['type']) {
                            1 => '⬆️ 恢复运行',
                            2 => '⬇️ 停止运行',
                            default => '❓ 未知事件'
                        };
                        echo $type . ' - ' . date('Y-m-d H:i:s', $log['datetime']);
                        if (!empty($log['reason']['code'])) {
                            echo ' - ' . htmlspecialchars($log['reason']['detail']);
                        }
                        ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            document.getElementById('loading-overlay').style.display = 'none';
        });
    </script>
</body>
</html> 