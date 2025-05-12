# UptimeRobot 站点监测系统

基于 UptimeRobot API 的站点监测系统，使用 Material Design 设计风格，PHP 技术栈开发。

## 功能特点

- 美观的 Material Design 界面
- 实时显示站点状态
- 详细的可用率统计
- 响应时间监控
- 事件日志记录
- 移动端自适应设计

## 技术栈

- 前端：HTML, CSS, JavaScript, Material Design Components
- 后端：PHP
- 部署：Vercel

## 快速开始

### 方式一：Vercel一键部署（推荐）

1. 点击下方按钮一键部署到Vercel

[![Deploy with Vercel](https://vercel.com/button)](https://vercel.com/new/clone?repository-url=https://github.com/miloce/uptime-monitor&env=UPTIMEROBOT_API_KEY,TOKEN,SITE_NAME)

[Deploy with Vercel](https://vercel.com/new/clone?repository-url=https://github.com/miloce/uptime-monitor&env=UPTIMEROBOT_API_KEY,TOKEN,SITE_NAME)

2. 设置环境变量：
   - `UPTIMEROBOT_API_KEY`：你的UptimeRobot API密钥
   - `SITE_NAME`：你的站点名称（可选，默认为"Uptime Monitor"）

### 方式二：本地开发

1. 克隆项目到本地

```bash
git clone https://github.com/miloce/uptime-monitor.git
cd uptime-monitor
```

2. 设置环境变量或修改配置文件

方法1：设置环境变量
```bash
export UPTIMEROBOT_API_KEY="你的API密钥"
export SITE_NAME="你的站点名称"
```

方法2：直接修改 `config.php` 文件
```php
// 网站名称
'site_name' => '你的站点名称',

// UptimeRobot API Keys
'api_keys' => [
    '你的API密钥',
],
```

3. 启动本地服务器

```bash
php -S localhost:8000
```

4. 在浏览器中访问 `http://localhost:8000`

## 配置说明

支持通过环境变量或配置文件进行配置：

### 环境变量

- `UPTIMEROBOT_API_KEY`：UptimeRobot API密钥（必填）
- `SITE_NAME`：站点名称（可选）

### 配置文件

在 `config.php` 文件中可以进行更多自定义配置：

```php
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
    // ...
],
```

## API 密钥获取

1. 登录 [UptimeRobot](https://uptimerobot.com/)
2. 进入 "[My Settings](https://dashboard.uptimerobot.com/integrations)"
3. 在 "Main API keys" 部分获取 API Key

## 贡献指南

1. Fork 本项目
2. 创建你的特性分支 (`git checkout -b feature/amazing-feature`)
3. 提交你的更改 (`git commit -m 'Add some amazing feature'`)
4. 推送到分支 (`git push origin feature/amazing-feature`)
5. 开启一个 Pull Request

## 许可证

本项目采用 MIT 许可证 - 详见 [LICENSE](LICENSE) 文件

## 致谢

- [UptimeRobot](https://uptimerobot.com/) - 提供监控 API
- [Material Design Components](https://material.io/components) - UI 组件库
- [Chart.js](https://www.chartjs.org/) - 图表库 