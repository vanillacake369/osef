'use strict';

// introduce navbar up - 스크롤하면 navbar 나옴
const navbar = document.querySelector('.intro_navbar');
const navbarHeight = navbar.getBoundingClientRect().height;
document.addEventListener('scroll', () => {
    // console.log(window.scrollY);
    // console.log(`navbarHeight: ${navbarHeight}`);
    if(window.scrollY > 410) {
        navbar.classList.add('intro_navbar_up');
    } else {
        navbar.classList.remove('intro_navbar_up')
    }
})

// introduce navbar tapping - navbar 클릭하면 이동
const navbarMenu = document.querySelector('.intro_navbar_list');
navbarMenu.addEventListener('click', (event) => {
    const target = event.target;
    const link = target.dataset.link;
    if (link == null) {
        return;
    }
    // console.log(event.target.dataset.link);
    const scrollTo = document.querySelector(link);
    scrollTo.scrollIntoView({behavior: "smooth"});    
    
})

// arrow scrollIntoView button - navbar 나오면 버튼 출현
const arrow = document.querySelector('.arrow');
document.addEventListener('scroll', () => {
    if(window.scrollY > 410) {
        arrow.classList.add('visible');
    } else {
        arrow.classList.remove('visible');
    }
})

// arrow scrollIntoView button - 당근 클릭하면 상단으로 이동
arrow.addEventListener('click', () => {
    scrollIntoView('#navbar');
})

// function scrollIntoView - 클릭시 해당 data(id)로 이돈
function scrollIntoView(selector) {
    const scrollTo = document.querySelector(selector);
    scrollTo.scrollIntoView({behavior: 'smooth'})
}

