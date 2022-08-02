// 모달창
const modalOpen = () => {
    document.querySelector("#modal").classList.remove("hidden");
};

const modalClose = () => {
    document.querySelector("#modal").classList.add("hidden");
};

document.querySelector(".openBtn").addEventListener("click", modalOpen);
document.querySelector(".lend_answer_back").addEventListener("click", modalClose);
document.querySelector(".modal_bg").addEventListener("click", modalClose);
