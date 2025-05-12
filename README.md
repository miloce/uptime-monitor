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

### 本地开发

1. 克隆项目到本地

```bash
git clone https://github.com/yourusername/uptime-monitor.git
cd uptime-monitor
```

2. 修改配置文件

编辑 `config.php` 文件，替换为你自己的 UptimeRobot API Key：

```php
// UptimeRobot API Keys
'api_keys' => [
    'YOUR_API_KEY_HERE',
],
```

3. 启动本地服务器

```bash
php -S localhost:8000
```

4. 在浏览器中访问 `http://localhost:8000`

### Vercel 部署

1. Fork 本项目到你的 GitHub 账户

2. 在 Vercel 中导入项目

   - 登录 [Vercel](https://vercel.com/)
   - 点击 "New Project"
   - 选择你 fork 的项目
   - 点击 "Import"

3. 配置环境变量（可选）

4. 点击 "Deploy"

## 配置说明

在 `config.php` 文件中可以进行以下配置：

```php
// 网站名称
'site_name' => '站点监测',

// UptimeRobot API Keys
'api_keys' => [
    'YOUR_API_KEY_HERE',
],

// 显示的日志天数
'count_days' => 60,

// 是否显示检测站点的链接
'show_link' => true,

// 导航栏菜单
'navigation' => [
    [
        'text' => '主页',
        'url' => 'https://example.com/'
    ],
    // ...
],
```

## API 密钥获取

1. 登录 [UptimeRobot](https://uptimerobot.com/)
2. 进入 "My Settings"
3. 在 "API Settings" 部分获取 API Key

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