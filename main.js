'use strict';

// Navbar toggle button for small screen
const navbarList = document.querySelector('.navbar_list');
const navbarToggleBtn = document.querySelector('.navbar_toggle_btn');
navbarToggleBtn.addEventListener('click', () => {
    navbarList.classList.toggle('open');
})

// img slide.
// 참고 https://eunhee-programming.tistory.com/106
const slides = document.querySelector('.slides'); 
const slideImg = document.querySelectorAll('.slides li'); 
let currentIdx = 0; 
const slideCount = slideImg.length; 
const prev = document.querySelector('.prev'); 
const next = document.querySelector('.next'); 
const slideWidth = 500; 
const slideMargin = 50; 

//전체 슬라이드 컨테이너 넓이 설정
slides.style.width = (slideWidth + slideMargin) * slideCount + 'px';

function moveSlide(num) {
    slides.style.left = -num * 500 + 'px';
    currentIdx = num;
}

prev.addEventListener('click', function () {
    if (currentIdx !== 0) moveSlide(currentIdx - 1);
});

next.addEventListener('click', function () {
    if (currentIdx !== slideCount - 1) {
    moveSlide(currentIdx + 1);
    }
});