'use strict';

const HIDDEN_CLASSNAME = 'hidden';
const MAKER_KEY = 'Maker';
const CATEGORY_KEY = 'Category';
const Adress_KEY = 'Adress'

const lendFormA1 = document.querySelector('#lend_form_A1');
const lendFormA2 = document.querySelector('#lend_form_A2');
const lendFormA3 = document.querySelector('#lend_form_A3');
const lendFormA4 = document.querySelector('#lend_form_A4');
const lendFormA5 = document.querySelector('#lend_form_A5');
const lendFormA6 = document.querySelector('#lend_form_A6');
const lendFormA7 = document.querySelector('#lend_form_A7');
const lendFormA8 = document.querySelector('#lend_form_A8');

const lendFormQ1 = document.querySelector('#lend_Q1');
const lendFormQ2 = document.querySelector('#lend_Q2');
const lendFormQ3 = document.querySelector('#lend_Q3');
const lendFormQ4 = document.querySelector('#lend_Q4');
const lendFormQ5 = document.querySelector('#lend_Q5');
const lendFormQ6 = document.querySelector('#lend_Q6');
const lendFormQ7 = document.querySelector('#lend_Q7');
const lendFormQ8 = document.querySelector('#lend_Q8');

const nodeCategory = document.getElementsByName('category');

const lendInputA2 = document.querySelector('#lend_form_A2 input');
const lendInputA3 = document.querySelector('#lend_form_A3 input');
const lendInputA41 = document.querySelector('#lend_form_A4_start input');
const lendInputA42 = document.querySelector('#lend_form_A4_end input');
const lendInputA5 = document.querySelector('#lend_form_A5 #file');
const lendInputA6 = document.querySelector('#lend_form_A6 textarea');
const lendInputA7 = document.querySelector('#lend_form_A7 input');

const lendBtn = document.querySelector('#lend_next_btn');

// lend_form_A1
function onLendSumbitA1(event) {
    event.preventDefault(); // 브라우저 기본 동작 막음 (submit 클릭시 페이지 새로고침)
    // console.log(event);
    // console.log(lendInput.value);
    
    // submit 1번 누르면 radio value 값이 저장
    nodeCategory.forEach((node) => {
        const categoryValue = node.value;
        if(node.checked)  {
            localStorage.setItem(CATEGORY_KEY, categoryValue);
        }
    }) 
    
    // submit 1번 누르면 A1, Q1 사라짐
    lendFormQ1.classList.add(HIDDEN_CLASSNAME);
    lendFormA1.classList.add(HIDDEN_CLASSNAME);
    
    // submit 1번 누르면 A2, Q2 생김
    lendFormQ2.classList.remove(HIDDEN_CLASSNAME);
    lendFormA2.classList.remove(HIDDEN_CLASSNAME);
}
lendFormA1.addEventListener('submit', onLendSumbitA1);

// A1 클릭 시 다음 버튼 나옴
lendFormA1.addEventListener('click', (event) => {
    nodeCategory.forEach((node) => {
        const categoryValue = node.value;
        if(node.checked)  {
            lendBtn.classList.remove(HIDDEN_CLASSNAME);
        }
    }) 
})

// lend_form_A2
function onLendSumbitA2(event) {
    event.preventDefault(); 

    const maker = lendInputA2.value;
    localStorage.setItem(MAKER_KEY, maker);

    lendFormQ2.classList.add(HIDDEN_CLASSNAME);
    lendFormA2.classList.add(HIDDEN_CLASSNAME);

    lendFormQ3.classList.remove(HIDDEN_CLASSNAME);
    lendFormA3.classList.remove(HIDDEN_CLASSNAME);

}
lendFormA2.addEventListener('submit', onLendSumbitA2);

// 뒤로가기 버튼
const lendFormA2Btn = document.querySelector('#A2_btn');
lendFormA2Btn.addEventListener('click', (event) => {
    lendFormQ2.classList.add(HIDDEN_CLASSNAME);
    lendFormA2.classList.add(HIDDEN_CLASSNAME);

    lendFormQ1.classList.remove(HIDDEN_CLASSNAME);
    lendFormA1.classList.remove(HIDDEN_CLASSNAME);

})

// lend_form_A3
function onLendSumbitA3(event) {
    event.preventDefault(); 

    const adress = lendInputA3.value;
    localStorage.setItem(Adress_KEY, adress);

    lendFormQ3.classList.add(HIDDEN_CLASSNAME);
    lendFormA3.classList.add(HIDDEN_CLASSNAME);

    lendFormQ4.classList.remove(HIDDEN_CLASSNAME);
    lendFormA4.classList.remove(HIDDEN_CLASSNAME);
}
lendFormA3.addEventListener('submit', onLendSumbitA3);

// 뒤로가기 버튼
const lendFormA3Btn = document.querySelector('#A3_btn');
lendFormA3Btn.addEventListener('click', (event) => {
    lendFormQ3.classList.add(HIDDEN_CLASSNAME);
    lendFormA3.classList.add(HIDDEN_CLASSNAME);

    lendFormQ2.classList.remove(HIDDEN_CLASSNAME);
    lendFormA2.classList.remove(HIDDEN_CLASSNAME);

})

// lend_form_A4
function onLendSumbitA4(event) {
    event.preventDefault(); 

    const startdate = lendInputA41.value;
    const enddate = lendInputA42.value;
    localStorage.setItem('startDate', startdate);
    localStorage.setItem('enddate', enddate);

    lendFormQ4.classList.add(HIDDEN_CLASSNAME);
    lendFormA4.classList.add(HIDDEN_CLASSNAME);

    lendFormQ5.classList.remove(HIDDEN_CLASSNAME);
    lendFormA5.classList.remove(HIDDEN_CLASSNAME);
}
lendFormA4.addEventListener('submit', onLendSumbitA4);

// 뒤로가기 버튼
const lendFormA4Btn = document.querySelector('#A4_btn');
lendFormA4Btn.addEventListener('click', (event) => {
    lendFormQ4.classList.add(HIDDEN_CLASSNAME);
    lendFormA4.classList.add(HIDDEN_CLASSNAME);

    lendFormQ3.classList.remove(HIDDEN_CLASSNAME);
    lendFormA3.classList.remove(HIDDEN_CLASSNAME);

})

// lend_form_A5
function onLendSumbitA5(event) {
    event.preventDefault(); 

    const flie = lendInputA5.value;
    localStorage.setItem('flie', flie);

    lendFormQ5.classList.add(HIDDEN_CLASSNAME);
    lendFormA5.classList.add(HIDDEN_CLASSNAME);

    lendFormQ6.classList.remove(HIDDEN_CLASSNAME);
    lendFormA6.classList.remove(HIDDEN_CLASSNAME);
}
lendFormA5.addEventListener('submit', onLendSumbitA5);

// 뒤로가기 버튼
const lendFormA5Btn = document.querySelector('#A5_btn');
lendFormA5Btn.addEventListener('click', (event) => {
    lendFormQ5.classList.add(HIDDEN_CLASSNAME);
    lendFormA5.classList.add(HIDDEN_CLASSNAME);

    lendFormQ4.classList.remove(HIDDEN_CLASSNAME);
    lendFormA4.classList.remove(HIDDEN_CLASSNAME);

})

// 이미지 미리보기
function readURL (input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        document.getElementById('preview').src = "";
    }

    const preview = document.querySelector('#preview');
    preview.classList.remove(HIDDEN_CLASSNAME);
}

// lend_form_A6
function onLendSumbitA6(event) {
    event.preventDefault(); 

    const textarea = lendInputA6.value;
    localStorage.setItem('textarea', textarea);

    lendFormQ6.classList.add(HIDDEN_CLASSNAME);
    lendFormA6.classList.add(HIDDEN_CLASSNAME);

    lendFormQ7.classList.remove(HIDDEN_CLASSNAME);
    lendFormA7.classList.remove(HIDDEN_CLASSNAME);
}
lendFormA6.addEventListener('submit', onLendSumbitA6);

// 뒤로가기 버튼
const lendFormA6Btn = document.querySelector('#A6_btn');
lendFormA6Btn.addEventListener('click', (event) => {
    lendFormQ6.classList.add(HIDDEN_CLASSNAME);
    lendFormA6.classList.add(HIDDEN_CLASSNAME);

    lendFormQ5.classList.remove(HIDDEN_CLASSNAME);
    lendFormA5.classList.remove(HIDDEN_CLASSNAME);

})

// lend_form_A7
function onLendSumbitA7(event) {
    event.preventDefault(); 

    const price = lendInputA7.value;
    localStorage.setItem('price', price);

    lendFormQ7.classList.add(HIDDEN_CLASSNAME);
    lendFormA7.classList.add(HIDDEN_CLASSNAME);

    lendFormQ8.classList.remove(HIDDEN_CLASSNAME);
    lendFormA8.classList.remove(HIDDEN_CLASSNAME);
}
lendFormA7.addEventListener('submit', onLendSumbitA7);

// 뒤로가기 버튼
const lendFormA7Btn = document.querySelector('#A7_btn');
lendFormA7Btn.addEventListener('click', (event) => {
    lendFormQ7.classList.add(HIDDEN_CLASSNAME);
    lendFormA7.classList.add(HIDDEN_CLASSNAME);

    lendFormQ6.classList.remove(HIDDEN_CLASSNAME);
    lendFormA6.classList.remove(HIDDEN_CLASSNAME);

})
