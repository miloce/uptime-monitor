/**
 * UptimeRobot 站点监测系统 JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // 初始化Material Design组件
    initMaterialComponents();
    
    // 更新状态计数
    updateStatusCounts();
    
    // 添加卡片波纹效果
    addRippleEffect();
    
    // 隐藏加载画面
    hideLoader();
});

/**
 * 隐藏加载画面
 */
function hideLoader() {
    const loader = document.getElementById('loader');
    if (loader) {
        // 延迟一小段时间再隐藏，确保页面已完全渲染
        setTimeout(() => {
            loader.classList.add('hidden');
            // 完全隐藏后移除元素
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }, 300);
    }
}

/**
 * 初始化Material Design组件
 */
function initMaterialComponents() {
    // 初始化顶部应用栏
    const topAppBarElement = document.querySelector('.mdc-top-app-bar');
    if (topAppBarElement) {
        const topAppBar = new mdc.topAppBar.MDCTopAppBar(topAppBarElement);
    }
    
    // 初始化按钮
    const buttons = document.querySelectorAll('.mdc-button');
    buttons.forEach(button => {
        new mdc.ripple.MDCRipple(button);
    });
    
    // 初始化图标按钮
    const iconButtons = document.querySelectorAll('.mdc-icon-button');
    iconButtons.forEach(iconButton => {
        const iconButtonRipple = new mdc.ripple.MDCRipple(iconButton);
        iconButtonRipple.unbounded = true;
    });
    
    // 添加passive选项到所有touchstart事件
    document.addEventListener('touchstart', function(){}, {passive: true});
}

/**
 * 添加卡片波纹效果
 */
function addRippleEffect() {
    const cardPrimaryActions = document.querySelectorAll('.mdc-card__primary-action');
    cardPrimaryActions.forEach(cardPrimaryAction => {
        new mdc.ripple.MDCRipple(cardPrimaryAction);
    });
}

/**
 * 更新状态计数
 */
function updateStatusCounts() {
    const monitorCards = document.querySelectorAll('.monitor-card');
    let upCount = 0;
    let downCount = 0;
    let pausedCount = 0;
    
    monitorCards.forEach(card => {
        const statusElement = card.querySelector('.monitor-status');
        if (statusElement) {
            if (statusElement.classList.contains('status-up')) {
                upCount++;
            } else if (statusElement.classList.contains('status-down') || statusElement.classList.contains('status-seems')) {
                downCount++;
            } else if (statusElement.classList.contains('status-paused')) {
                pausedCount++;
            }
        }
    });
    
    // 更新计数显示
    const upCountElement = document.getElementById('up-count');
    const downCountElement = document.getElementById('down-count');
    const pausedCountElement = document.getElementById('paused-count');
    
    if (upCountElement) upCountElement.textContent = upCount;
    if (downCountElement) downCountElement.textContent = downCount;
    if (pausedCountElement) pausedCountElement.textContent = pausedCount;
    
    // 如果有故障，添加页面标题闪烁效果
    if (downCount > 0) {
        startTitleAlert(`⚠️ ${downCount} 个站点离线`);
    }
}

/**
 * 页面标题闪烁提醒
 * @param {string} alertText 提醒文本
 */
let titleInterval;
function startTitleAlert(alertText) {
    const originalTitle = document.title;
    let isAlertTitle = false;
    
    clearInterval(titleInterval);
    
    titleInterval = setInterval(() => {
        document.title = isAlertTitle ? originalTitle : alertText;
        isAlertTitle = !isAlertTitle;
    }, 1000);
}

/**
 * 格式化时间戳为可读格式
 * @param {number} timestamp 时间戳
 * @return {string} 格式化后的时间
 */
function formatDate(timestamp) {
    const date = new Date(timestamp * 1000);
    return date.toLocaleString();
}

/**
 * 格式化持续时间（秒）为可读格式
 * @param {number} seconds 持续时间（秒）
 * @return {string} 格式化后的持续时间
 */
function formatDuration(seconds) {
    if (seconds < 60) {
        return `${seconds}秒`;
    } else if (seconds < 3600) {
        return `${Math.floor(seconds / 60)}分钟${seconds % 60}秒`;
    } else if (seconds < 86400) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        return `${hours}小时${minutes}分钟`;
    } else {
        const days = Math.floor(seconds / 86400);
        const hours = Math.floor((seconds % 86400) / 3600);
        return `${days}天${hours}小时`;
    }
} 