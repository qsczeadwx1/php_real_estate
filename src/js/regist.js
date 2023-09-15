// 유저 약관관련
const termsUser = document.getElementById("termsUser");
const userCheckbox = document.getElementById("userCheckbox");
const registUser = document.getElementById("registUser");
const useButton = document.getElementById('show_user');
const userDiv = document.getElementById('user_regist');

// 셀러 약관관련
const termsSeller = document.getElementById("termsSeller");
const sellerCheckbox = document.getElementById('sellerCheckbox');
const registSeller = document.getElementById('registSeller');
const sellButton = document.getElementById('show_seller');
const sellerDiv = document.getElementById('seller_regist');

// 회원가입 유형에서 일반회원 클릭시 약관과 동의 체크박스 나옴
useButton.addEventListener('click', function() {
    useButton.classList.add('color');
    sellerDiv.classList.add('display_none');
    sellButton.classList.remove('color');
    if (userDiv.classList.value.indexOf('display_none') == 0) {
        userDiv.classList.remove('display_none');
    }
    if (registSeller.style.display) {
        registSeller.style.display = "none";
        sellerCheckbox.checked = false;
    }
});

// 회원가입 유형에서 공인중개사 클릭시 약관과 동의 체크박스 나옴
sellButton.addEventListener('click', function() {
    userDiv.classList.add('display_none');
    sellButton.classList.add('color');
    useButton.classList.remove('color');
    if (sellerDiv.classList.value.indexOf('display_none') == 0) {
        sellerDiv.classList.remove('display_none');
    }
    if (registUser.style.display) {
        registUser.style.display = "none";
        userCheckbox.checked = false;
    }
});


// 유저 약관스크롤 다내리면 약관 동의 체크박스 활성화
document.addEventListener("DOMContentLoaded", function() {

    function checkScrollPosition() {
        const scrolledRatio =
            termsUser.scrollTop / (termsUser.scrollHeight - termsUser.clientHeight);

        if (scrolledRatio >= 0.95) {
            userCheckbox.disabled = false;
            registUser.disabled = false;
        }
    }

    termsUser.addEventListener("scroll", checkScrollPosition);
});

// 약관 동의 체크박스 누르면 회원가입으로 가는 버튼 나옴
userCheckbox.addEventListener('click', function() {
    if (userCheckbox.checked) {
        registUser.style.display = 'block';
    } else {
        registUser.style.display = 'none';
    }
});

// 셀러 약관스크롤 다내리면 약관 동의 체크박스 활성화
document.addEventListener("DOMContentLoaded", function() {
    
    function checkScrollPosition() {
        const scrolledRatio =
        termsSeller.scrollTop / (termsSeller.scrollHeight - termsSeller.clientHeight);

        if (scrolledRatio >= 0.95) {
            sellerCheckbox.disabled = false;
            registSeller.disabled = false;
        }
    }

    termsSeller.addEventListener("scroll", checkScrollPosition);
});

// 약관 동의 체크박스 누르면 회원가입으로 가는 버튼 나옴
sellerCheckbox.addEventListener('click', function() {
    if (sellerCheckbox.checked) {
        registSeller.style.display = 'block';
    } else {
        registSeller.style.display = 'none';
    }
});