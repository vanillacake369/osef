'use strict';

// introduce navbar up - 스크롤하면 navbar 나옴
const navbar = document.querySelector('.intro_navbar');
const navbarHeight = navbar.getBoundingClientRect().height;
document.addEventListener('scroll', ()=> {
    // console.log(window.scrollY);
    console.log(`navbarHeight: ${navbarHeight}`);
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
