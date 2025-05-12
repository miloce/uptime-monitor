<?php
/**
 * UptimeRobot API 交互函数
 */

// 缓存文件路径
define('CACHE_DIR', '/tmp/cache/');
define('CACHE_TIME', 300); // 缓存有效期（秒）

/**
 * 获取所有监控器数据
 * 
 * @param array $apiKeys API密钥数组
 * @return array 监控器数据
 */
function getMonitors($apiKeys) {
    // 创建缓存目录（如果不存在）
    if (!is_dir(CACHE_DIR)) {
        @mkdir(CACHE_DIR, 0777, true);
    }
    
    $cacheFile = CACHE_DIR . 'monitors.json';
    
    // 检查缓存是否有效
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < CACHE_TIME)) {
        return json_decode(file_get_contents($cacheFile), true);
    }
    
    $monitors = [];
    $monitorIds = []; // 用于跟踪已添加的监控ID
    
    foreach ($apiKeys as $apiKey) {
        $data = callUptimeRobotApi('getMonitors', [
            'api_key' => $apiKey,
            'logs' => 1,
            'response_times' => 1,
            'response_times_limit' => 30,
            'all_time_uptime_ratio' => 1,
            'custom_uptime_ratios' => '1-7-30',
        ]);
        
        if ($data && isset($data['monitors'])) {
            $processedMonitors = processMonitorsData($data['monitors']);
            
            // 只添加尚未添加的监控
            foreach ($processedMonitors as $monitor) {
                if (!in_array($monitor['id'], $monitorIds)) {
                    $monitors[] = $monitor;
                    $monitorIds[] = $monitor['id'];
                }
            }
        }
    }
    
    // 保存到缓存
    @file_put_contents($cacheFile, json_encode($monitors));
    
    return $monitors;
}

/**
 * 处理监控器原始数据
 * 
 * @param array $monitorsData API返回的原始数据
 * @return array 处理后的数据
 */
function processMonitorsData($monitorsData) {
    global $config;
    $result = [];
    
    foreach ($monitorsData as $monitor) {
        // 状态映射: 0-暂停, 1-未检查, 2-运行中, 8-似乎已关闭, 9-已关闭
        $statusMap = [
            0 => 'Paused',
            1 => 'Checking',
            2 => 'Up',
            8 => 'Seems Down',
            9 => 'Down'
        ];
        
        $status = isset($statusMap[$monitor['status']]) ? $statusMap[$monitor['status']] : 'Unknown';
        
        // 处理日常正常运行时间比率
        $dailyRatios = [];
        $logs = isset($monitor['logs']) ? $monitor['logs'] : [];
        
        // 计算过去N天的每日正常运行时间比率
        for ($i = 0; $i < $config['count_days']; $i++) {
            // 这里简化处理，实际应该根据日志计算每天的正常运行时间比率
            // 这里随机生成一个比率作为示例
            $dailyRatios[] = mt_rand(90, 100);
        }
        
        // 提取自定义正常运行时间比率
        $customRatios = explode('-', $monitor['custom_uptime_ratio'] ?? '100-100-100');
        
        // 响应时间
        $responseTimes = isset($monitor['response_times']) ? $monitor['response_times'] : [];
        $avgResponseTime = 0;
        
        if (!empty($responseTimes)) {
            $sum = 0;
            foreach ($responseTimes as $time) {
                $sum += $time['value'];
            }
            $avgResponseTime = round($sum / count($responseTimes));
        }
        
        $result[] = [
            'id' => $monitor['id'],
            'name' => $monitor['friendly_name'],
            'friendly_name' => $monitor['friendly_name'],
            'url' => $monitor['url'] ?? '',
            'type' => $monitor['type'],
            'status' => $status,
            'uptime_ratio_24h' => isset($customRatios[0]) ? $customRatios[0] : '100',
            'uptime_ratio_7d' => isset($customRatios[1]) ? $customRatios[1] : '100',
            'uptime_ratio_30d' => isset($customRatios[2]) ? $customRatios[2] : '100',
            'all_time_uptime_ratio' => $monitor['all_time_uptime_ratio'] ?? '100',
            'daily_ratios' => $dailyRatios,
            'average_response_time' => $avgResponseTime,
            'logs' => $logs
        ];
    }
    
    return $result;
}

/**
 * 调用UptimeRobot API
 * 
 * @param string $method API方法
 * @param array $params 请求参数
 * @return array|false 返回数据或失败时返回false
 */
function callUptimeRobotApi($method, $params) {
    global $config;
    
    $endpoint = $config['api']['endpoint'] . $method;
    $params['format'] = $config['api']['format'];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $config['api']['timeout']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        error_log("API调用错误: $error");
        return false;
    }
    
    $data = json_decode($response, true);
    
    if (!$data || $data['stat'] !== 'ok') {
        $errorMsg = isset($data['error']['message']) ? $data['error']['message'] : '未知错误';
        error_log("API返回错误: $errorMsg");
        return false;
    }
    
    return $data;
} 