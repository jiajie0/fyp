document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.carousel-image');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    let currentIndex = 0;
    let interval;


    // 显示指定索引的图片
    function showImage(index) {
        images.forEach((img, i) => {
            img.style.display = i === index ? 'block' : 'none';
        });
    }

    // 显示下一张图片
    function showNextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    // 显示上一张图片
    function showPrevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    }

    // 启动自动切换
    function startAutoSwitch() {
        interval = setInterval(showNextImage, 3000);
    }

    // 停止自动切换
    function stopAutoSwitch() {
        clearInterval(interval);
    }

    // 初始显示第一张图片
    if (images.length > 0) {
        showImage(currentIndex);
        startAutoSwitch();
    }

    // 添加按钮点击事件
    prevButton.addEventListener('click', () => {
        stopAutoSwitch();
        showPrevImage();
        startAutoSwitch();
    });

    nextButton.addEventListener('click', () => {
        stopAutoSwitch();
        showNextImage();
        startAutoSwitch();
    });
});
