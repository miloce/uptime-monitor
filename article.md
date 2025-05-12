# 基于UptimeRobot的开源站点监控面板

网站运维中，及时发现并解决故障是非常重要的。这个基于UptimeRobot API开发的开源监控面板，可以帮助你实时监控网站状态。

[![Deploy with Vercel](https://vercel.com/button)](https://vercel.com/new/clone?repository-url=https://github.com/miloce/uptime-monitor)

![项目预览图]

## 主要功能

- 支持HTTP(s)、TCP、Ping等多种监控方式
- 可同时监控多个站点
- 自动记录运行数据
- 故障实时提醒
- 数据统计展示

## 快速部署

### 方式一：Vercel一键部署（推荐）

1. 点击上方的"Deploy with Vercel"按钮
2. 注册/登录Vercel账号
3. 设置以下环境变量：
   - `UPTIMEROBOT_API_KEY`：你的UptimeRobot API密钥
   - `SITE_NAME`：你的站点名称（可选）

完成后，Vercel会自动部署并提供一个域名。

### 方式二：手动部署

1. 注册UptimeRobot账号（免费）
2. 下载并配置项目
3. 部署到支持PHP的服务器

配置过程很简单，详细步骤请参考项目文档。

## 界面预览

采用Material Design设计：

![监控面板截图]

主要包括：
- 站点状态总览
- 响应时间统计
- 故障记录
- 运行报告

## 适用场景

- 个人网站监控
- 小型团队服务监控
- 开发环境状态检查

## 技术特点

- 基于PHP开发
- 使用UptimeRobot API
- 支持自定义告警
- 数据可视化展示
- Vercel部署支持

## 反馈建议

如果在使用过程中遇到问题：
- 提交GitHub Issues
- 在评论区留言

## 开源地址

[GitHub地址：https://github.com/miloce/uptime-monitor]

欢迎Star和提出建议，一起改进这个项目。

---

> 开源项目，欢迎使用和贡献 