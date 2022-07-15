'use strict';

// introduce navbar up - 스크롤하면 navbar 나옴
const navbar = document.querySelector('.intro_navbar');
const navbarHeight = navbar.getBoundingClientRect().height;
document.addEventListener('scroll', () => {
    // console.log(window.scrollY);
    // console.log(`navbarHeight: ${navbarHeight}`);
    if(window.scrollY > 409) {
        navbar.classList.add('intro_navbar_up');
    } else {
        navbar.classList.remove('intro_navbar_up')
    }
})

// introduce navbar up  color - 스크롤하면 navbar  color 나옴
const navbarColor1 = document.querySelector('.intro_navbar_li1');
const navbarColor2 = document.querySelector('.intro_navbar_li2');
const navbarColor3 = document.querySelector('.intro_navbar_li3');
const navbarColor4 = document.querySelector('.intro_navbar_li4');
document.addEventListener('scroll', () => {
    if (1150 > window.scrollY && window.scrollY > 409) {
        navbarColor1.classList.add('intro_navbar_li_color');
    } else {
            navbarColor1.classList.remove('intro_navbar_li_color');
    }

    if (1850 > window.scrollY &&window.scrollY > 1150) {
        navbarColor2.classList.add('intro_navbar_li_color');
    } else {
        navbarColor2.classList.remove('intro_navbar_li_color');
    }  

    if (2600 > window.scrollY &&window.scrollY > 1850) {
        navbarColor3.classList.add('intro_navbar_li_color');
    } else {
        navbarColor3.classList.remove('intro_navbar_li_color');
    }  

    if (window.scrollY > 2600) {
        navbarColor4.classList.add('intro_navbar_li_color');
    } else {
        navbarColor4.classList.remove('intro_navbar_li_color');
    }  
})

// introduce navbar tapping - navbar 클릭하면 이동
const navbarMenu = document.querySelector('.intro_navbar_wrap');
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

