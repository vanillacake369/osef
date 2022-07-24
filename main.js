'use strict';

// Navbar toggle button for small screen
const navbarList = document.querySelector('.navbar_list');
const navbarToggleBtn = document.querySelector('.navbar_toggle_btn');
navbarToggleBtn.addEventListener('click', () => {
    navbarList.classList.toggle('open');
})
