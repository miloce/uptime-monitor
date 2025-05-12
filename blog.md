# 基于 UptimeRobot 的开源站点监控面板——快速上手与部署指南

在日常运维或开发中，及时掌握网站健康状态至关重要。本篇文章分享一个基于 UptimeRobot API 开源的站点监控面板，从项目特点、部署方式到实践经验，帮助你快速上手并集成到生产环境。

---

## 项目简介

本项目采用 PHP + Material Design 前端框架，结合 UptimeRobot API 实现：

- 实时监控站点可用性（HTTP、Ping、TCP、端口、关键词）
- 多站点批量管理
- 可视化数据统计与图表展示
- 优雅加载动画与响应式设计
- 支持环境变量配置，兼容 Vercel 一键部署

---

## 功能亮点

1. **多种监控方式**
   - HTTP(s)、Ping、TCP、端口、关键词，覆盖大多数场景

2. **数据可视化**
   - 使用 Chart.js 绘制可用率和响应时间曲线，直观展示历史趋势

3. **灵活配置**
   - 环境变量：`UPTIMEROBOT_API_KEY`、`SITE_NAME`
   - `api/config.php`：可自定义 `count_days`、`show_link`、导航菜单等

4. **Vercel 一键部署**
   - 点击"Deploy with Vercel"按钮，填写 API Key 即可上线，无需运维配置

5. **日志与加载优化**
   - 加载动画提升用户体验
   - 数组格式原因优先输出 `detail` 字段，避免警告
   - 自动检测 Vercel 环境，提供平台友好提示

---

## 部署前准备

- 首先，去官网 [UptimeRobot 注册](https://dashboard.uptimerobot.com/sign-up) 注册一个账号，使用邮箱即可完成注册。

![使用 UptimeRobot 对网站和服务器实时监控](https://cdn.jsdelivr.net/gh/miloce/uptime-monitor/img/1.png)

![使用 UptimeRobot 对网站和服务器实时监控](https://cdn.jsdelivr.net/gh/miloce/uptime-monitor/img/2.png)

- 注册完成之后登录，然后点击[**Dashboard**](https://dashboard.uptimerobot.com/)，进入仪表盘。

![使用 UptimeRobot 对网站和服务器实时监控](https://cdn.jsdelivr.net/gh/miloce/uptime-monitor/img/3.png)

- 点击右上方 **New Monitor**，开始设置监控。

> 有四种监控方式，分别为**Http(s)**、**Ping**、**Port**、**Keyword**，在这里我选择**Http(s)**来监控我的网站，选择**Ping**来监控我的服务器。**Port**一般用于VPS监控。

- 填写监控种类、监控站点以及监控频率，注意勾选提醒邮箱。

![使用 UptimeRobot 对网站和服务器实时监控](https://cdn.jsdelivr.net/gh/miloce/uptime-monitor/img/4.png)

![使用 UptimeRobot 对网站和服务器实时监控](https://cdn.jsdelivr.net/gh/miloce/uptime-monitor/img/5.png)

## 部署指南

### 一键部署（推荐）

1. 打开项目仓库：<https://github.com/miloce/uptime-monitor>
2. 点击页面中的 **Deploy with Vercel** 按钮
3. 在 Vercel 控制台中设置环境变量：
   - `UPTIMEROBOT_API_KEY`：你的 UptimeRobot API Key
   - `SITE_NAME`：站点名称（可选，默认 "Uptime Monitor"）
4. 等待 Vercel 构建并自动分配域名，即可访问

### 手动部署

1. 克隆项目：
   ```bash
   git clone https://github.com/miloce/uptime-monitor.git
   cd uptime-monitor
   ```
2. 设置环境变量 或 修改 `api/config.php` 中的 `api_keys` 和 `site_name`
3. 启动本地服务器：
   ```bash
   php -S localhost:8000 -t api
   ```
4. 浏览器访问 `http://localhost:8000`


---

## 结语

该项目已在 GitHub 开源，欢迎 Fork、Star 与 Issue 反馈。希望本文能帮助你快速搭建可视化、易用的监控面板，为网站稳定运行保驾护航！

- 仓库地址：<https://github.com/miloce/uptime-monitor>
- 建议与反馈：请打开 Issues 或在评论区留言

---

> 开源项目，欢迎使用与贡献 