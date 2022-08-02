"use strict";

// Navbar toggle button for small screen
const navbarList = document.querySelector(".navbar_list");
const navbarToggleBtn = document.querySelector(".navbar_toggle_btn");
navbarToggleBtn.addEventListener("click", () => {
  navbarList.classList.toggle("open");
});

// img slide
// https://kimyang-sun.tistory.com/entry/Javascript-jQuery-Swiper-%EC%8A%AC%EB%9D%BC%EC%9D%B4%EB%8D%94-%EC%9D%91%EC%9A%A9-%ED%8E%98%EC%9D%B4%EC%A7%80-%EB%B3%80%EA%B2%BD%EC%8B%9C-%EC%A2%8C%EC%9A%B0-%EC%9D%B4%EB%8F%99%EB%B2%84%ED%8A%BC-%ED%85%8D%EC%8A%A4%ED%8A%B8-%EB%B3%80%EA%B2%BD-Swiper-navigation-text-change-loop%EA%B0%80-%EC%95%84%EB%8B%90%EA%B2%BD%EC%9A%B0?category=784813
const prevButton = $(".swiper-prev");
const nextButton = $(".swiper-next");
const prevButtonText = prevButton.find("> .btn-text");
const nextButtonText = nextButton.find("> .btn-text");

const swiper = new Swiper(".swiper", {
  loop: false,
  spaceBetween: 50,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    renderBullet: function (index, className) {
      return `<span class=${className}>${index + 1}</span>`; // IE에서는 템플릿 리터럴을 사용하면 오류남(기존의 방식으로 바꿔줘야함)
    },
  },
  navigation: {
    nextEl: ".swiper-next",
    prevEl: ".swiper-prev",
  },
  on: {
    // loop가 true인 경우에는 처음 로드할때 init이 없어도 slideChange가 실행이 되기 때문에 빼주는게 좋습니다. (안그러면 init, slideChange 두번이 실행됨)
    init: function (e) {
      ChangeButtonText(e, e.passedParams.loop);
    },
    slideChange: function (e) {
      ChangeButtonText(e, e.passedParams.loop);
    },
  },
});

function ChangeButtonText(event, loop) {
  const slides = event.slides;
  const currentSlideIndex = event.activeIndex;
  const prevSlideIndex = event.activeIndex - 1;
  const nextSlideIndex = event.activeIndex + 1;
  // console.log(`다음 슬라이드 : ${prevSlideIndex}`);
  // console.log(`현재 슬라이드 : ${currentSlideIndex}`);
  // console.log(`다음 슬라이드 : ${nextSlideIndex}`);

  // var currentSlideTitle = slides[currentSlideIndex].dataset.swiperTitle;
  var prevSlideTitle;
  var nextSlideTitle;
  // console.log(prevSlideIndex, nextSlideIndex);

  if (loop) {
    // 루프일 경우
    // 루프일 경우에는 상단에 activeIndex가 실제 index가 아닌 페이지의 번호가 나옵니다.
    // 기존 슬라이드의 개수보다 맨앞, 맨뒤에 하나씩 더생겨 2개가 더 추가됩니다.
    if (prevSlideIndex === -1) {
      prevSlideIndex = slides.length - 3;
    }

    if (nextSlideIndex >= slides.length) {
      nextSlideIndex -= prevSlideIndex;
    }
    prevSlideTitle = slides[prevSlideIndex].dataset.swiperTitle;
    nextSlideTitle = slides[nextSlideIndex].dataset.swiperTitle;
    // console.log(prevSlideTitle, nextSlideTitle);

    prevButtonText.text(prevSlideTitle);
    nextButtonText.text(nextSlideTitle);
  } else {
    // 루프가 아닐 경우
    if (prevSlideIndex >= 0) {
      prevSlideTitle = slides[prevSlideIndex].dataset.swiperTitle;
      prevButton.removeClass("invisible");
      prevButtonText.text(prevSlideTitle);
    } else {
      prevButton.addClass("invisible");
    }

    if (nextSlideIndex >= 0 && nextSlideIndex < slides.length) {
      nextSlideTitle = slides[nextSlideIndex].dataset.swiperTitle;
      nextButton.removeClass("invisible");
      nextButtonText.text(nextSlideTitle);
    } else {
      nextButton.addClass("invisible");
    }
    // console.log(prevSlideTitle, nextSlideTitle);
  }
}