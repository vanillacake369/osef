'use strict';

const HIDDEN_CLASSNAME = 'hidden';
const USERNAME_KEY = 'Username';
const MODEL_KEY = 'Model';

const lendForm = document.querySelector('#lend_form');
const lendFormA1 = document.querySelector('#lend_form_A1');
const lendFormA2 = document.querySelector('#lend_form_A2');
const lendFormQ1 = document.querySelector('#lend_Q1');
const lendFormQ2 = document.querySelector('#lend_Q2');
const lendInput = document.querySelector('#lend_form input');

const nodeModel = document.getElementsByName('model');

function onLendSumbit(event) {
    event.preventDefault(); // 브라우저 기본 동작 막음 (submit 클릭시 페이지 새로고침)
    
    // const username = lendInput.value;
    // localStorage.setItem(USERNAME_KEY, username);
    // console.log(username);
    
    // 1
    lendFormA1.classList.add(HIDDEN_CLASSNAME);
    lendFormQ1.classList.add(HIDDEN_CLASSNAME);
    
    // 2
    lendFormQ2.classList.remove(HIDDEN_CLASSNAME);
    lendFormA2.classList.remove(HIDDEN_CLASSNAME);
    
    // console.log(event);
    // console.log(lendInput.value);
    
    
    nodeModel.forEach((node) => {
        const modelvalue = node.value;
        if(node.checked)  {
            localStorage.setItem(MODEL_KEY, modelvalue);
        }
        }) 
}
lendForm.addEventListener('submit', onLendSumbit);
const savedUserName = localStorage.getItem(USERNAME_KEY);