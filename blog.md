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

![使用 UptimeRobot 对网站和服务器实时监控](https://developer-private-1258344699.cos.ap-guangzhou.myqcloud.com/column/article/8894132/20250512-2eb02d25.png?x-cos-security-token=3SX3PPDTOf91UeS5OoC7ySRDCMeHBR6a7a985bcccfd5559b247a350b93b19de7EzjO-X6QG-8k95XW-8XU-7tfnj5zbOleSrX0iDgkYXw1YLdv_nasZgnu5ZqHWQfxU_LLEjnWYdH7jIismy9A1jLgMHEyAJnuqBlPtSzC5hO3XpCnPvkoWM5LrmZ3cRANxSKpPOJEx0VGd1GgoYbu-3_uxy3tjUsnO7AuwhBuOBjf-DYAO-H2aUpGTphxYoa3XTWS5Dgg0nztVNLv2aAPQU_kSzsV2hvY-xIWVhAeyq_jOJEbSa5Yk-XmHhVvzbViuqzABmYSCgbnG8px3u4QKHa1F50UbpPu1IyBkre1Jxll6SyNmZuT28a2IgetZxJNnWqii6EV4J7c0eWnCO-ZezOo5GVZkToR3Q3D6tDt6DTMg2VJvcGujWRMcVlO3q8Z9M0_21jpyJRQojF0KMqC9w&q-sign-algorithm=sha1&q-ak=AKIDABAbHCXgI3PvvLs5bFsLN488FOQvdcibnpAAzOHRqjA4qgxtM6eCMmgHPkUjyk39&q-sign-time=1747064642%3B1747065242&q-key-time=1747064642%3B1747065242&q-header-list=host&q-url-param-list=x-cos-security-token&q-signature=0aa7c7aa8200967d3b8154db3745b6e17c536804&qc_blockWidth=769&qc_blockHeight=403)

![使用 UptimeRobot 对网站和服务器实时监控](https://developer-private-1258344699.cos.ap-guangzhou.myqcloud.com/column/article/8894132/20250512-1d640412.png?x-cos-security-token=OWhQ47A24OlizQSI1qQ3Jim9I2eNryMa8b22dd1844094596e749ef932105ecd3UCrZHMH8AEAGo-blWj1qdVA-lxUXy9vaRubmi4KAnq-kSc4yXSGKv5n1OAwIc2q68QzHVMfAcbazIl_wGv3ZK0JW_iGoUXa6jryGa3gpLJlYviHgvgrdLw5msdMt9iWYYBH324vlVS_VbsKGBaLTz2RyYyBNRvmOiD7thJUTcNgxc5WX2AYiClMIgCHx0kbEqCE5VetvItMO-_FXX3nFdU5czOH2L0nlJxYu_wl0ENMLmQtMxykGyhBMLvp62A1JfK7fmPsQblnRIok4_AEmAeMUKIuYqbiU3k8XFPe0au65c8DgOSsJZaiDsfNLM_eyIZHLWtz5Djma31W1s13hz_p0t2RYahs1zt89ovz5uJ6T3cOILkYa52Brh9jhFD4r4Vtp5gXdTZ9k1PftFdXIeA&q-sign-algorithm=sha1&q-ak=AKID5UamVPbRpggqOEYJpK87G5ZJhs5tHRdtcK58KIsu8lI6pBUEGOC5y5UPYZyOLpVz&q-sign-time=1747064642%3B1747065242&q-key-time=1747064642%3B1747065242&q-header-list=host&q-url-param-list=x-cos-security-token&q-signature=a4602bcd2ce310e0fcad8b29af5a41b3b49815bc&qc_blockWidth=769&qc_blockHeight=403)

- 注册完成之后登录，然后点击[**Dashboard**](https://dashboard.uptimerobot.com/)，进入仪表盘。

![请在此添加图片描述](https://developer-private-1258344699.cos.ap-guangzhou.myqcloud.com/column/article/8894132/20250512-da2b47e6.png?x-cos-security-token=3SX3PPDTOf91UeS5OoC7ySRDCMeHBR6a8e0011afe1c99a0f5d0c659224b850d0EzjO-X6QG-8k95XW-8XU-7tfnj5zbOleSrX0iDgkYXw1YLdv_nasZgnu5ZqHWQfxU_LLEjnWYdH7jIismy9A1jLgMHEyAJnuqBlPtSzC5hO3XpCnPvkoWM5LrmZ3cRANxSKpPOJEx0VGd1GgoYbu-3_uxy3tjUsnO7AuwhBuOBjf-DYAO-H2aUpGTphxYoa3XTWS5Dgg0nztVNLv2aAPQVfhfnwhB0vmvlvE9nU5o3xxeV81p4_zTbVGQlF72s9RnYDEQd_It_GARig42LD8OW0pWzGl7_lBmOYxR-IrzDPAgU11xQ43x4aGq6ZO7eX4GBEp8PscDhqHxt1Ok-biFfldZk3HIm6waqQM52uzqhlsV-PdMhRTYETKl9TMsbxVJW60ue1CrR7EK6yhKxbgpA&q-sign-algorithm=sha1&q-ak=AKID-dvKYRYdKVvNRKBhNNfhGIh1mBqfKe4Xxz3udcBMHA-U59-DczfhuC1pM55XhQeC&q-sign-time=1747064642%3B1747065242&q-key-time=1747064642%3B1747065242&q-header-list=host&q-url-param-list=x-cos-security-token&q-signature=8e7029c2c1068a6ddfd33a1d2041dae7bd9d6e51&qc_blockWidth=769&qc_blockHeight=385)

- 点击右上方 **New Monitor**，开始设置监控。

> 有四种监控方式，分别为**Http(s)**、**Ping**、**Port**、**Keyword**，在这里我选择**Http(s)**来监控我的网站，选择**Ping**来监控我的服务器。**Port**一般用于VPS监控。

- 填写监控种类、监控站点以及监控频率，注意勾选提醒邮箱。

![使用 UptimeRobot 对网站和服务器实时监控](https://developer-private-1258344699.cos.ap-guangzhou.myqcloud.com/column/article/8894132/20250512-11f01ebc.png?x-cos-security-token=OWhQ47A24OlizQSI1qQ3Jim9I2eNryMa932872c8f95f0739fc2ee57232bd040bUCrZHMH8AEAGo-blWj1qdVA-lxUXy9vaRubmi4KAnq-kSc4yXSGKv5n1OAwIc2q68QzHVMfAcbazIl_wGv3ZK0JW_iGoUXa6jryGa3gpLJlYviHgvgrdLw5msdMt9iWYYBH324vlVS_VbsKGBaLTz2RyYyBNRvmOiD7thJUTcNgxc5WX2AYiClMIgCHx0kbEqCE5VetvItMO-_FXX3nFdWDrR2l5bAP2dhlZnXTsjd4zrOE6ko436bTWe5EnDRnnSq9h1tr8kpePsUqVnTDil8yHwmQOKLvKA9Cz7l_qJ-CuFO9dcTxr6Lv8eyDcbQv4kcx7by_XFAT6gMBuz3QP7ScztwdWoMUbQlfQaosQG52a9x5JHBFQJqTRRCeLX6JmJFsFkbDc-f7CrpAbKzoVTg&q-sign-algorithm=sha1&q-ak=AKIDisYrgSddm-fLy_jn16oa-airkT1FFa445IzCzUcUFJAsb4oEt4K9ak4ffG_nkfLg&q-sign-time=1747064642%3B1747065242&q-key-time=1747064642%3B1747065242&q-header-list=host&q-url-param-list=x-cos-security-token&q-signature=90c5c3cb15bf959b9a8b20775f02399041cef821&qc_blockWidth=769&qc_blockHeight=399)

![使用 UptimeRobot 对网站和服务器实时监控](https://developer-private-1258344699.cos.ap-guangzhou.myqcloud.com/column/article/8894132/20250512-9f1d318c.png?x-cos-security-token=OWhQ47A24OlizQSI1qQ3Jim9I2eNryMaba0cb62dda7da71eee55e8a4412dd93fUCrZHMH8AEAGo-blWj1qdVA-lxUXy9vaRubmi4KAnq-kSc4yXSGKv5n1OAwIc2q68QzHVMfAcbazIl_wGv3ZK0JW_iGoUXa6jryGa3gpLJlYviHgvgrdLw5msdMt9iWYYBH324vlVS_VbsKGBaLTz2RyYyBNRvmOiD7thJUTcNgxc5WX2AYiClMIgCHx0kbEqCE5VetvItMO-_FXX3nFddvRRkjletWBNIc4ajvHAZHYuFOqIyRrx798EzWFYMuNtaMWFfWBvC7coWW_tTjH2iWV53-7CI-JythHuFoJ3HOqHSRd5U-BGvGauY3h4Pylxp6clKPheyE77zbZYs_DPoVyzbw4cJQl-woRparxNgWoPpBEbzTd_jkw3FyftfLmk_zUTyR7dxO1qiQNTiOviw&q-sign-altorithm=sha1&q-ak=AKIDIOe-0dYp1PaZMyW7d53_Vp5bXIm0kSo29PXm9CRzxNPiAIf6oK3hVSyJjs2bwXTs&q-sign-time=1747064642%3B1747065242&q-key-time=1747064642%3B1747065242&q-header-list=host&q-url-param-list=x-cos-security-token&q-signature=e4a79579f20e43aa7305b3fb72e9c23f98fba858&qc_blockWidth=769&qc_blockHeight=401)

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