// 회원가입

// 비밀번호 질문 드롭다운
function questionDropdown() {
    let dropdownMenu = document.getElementById('dropdownMenu');
    dropdownMenu.classList.toggle('show');
}

function selectAnswer(value, answer) {
    document.getElementById('pw_question').value = value;
    document.querySelector('.dropdown_toggle').innerHTML = answer + '<span class="arrow">&#9662;</span>';

    var dropdownMenu = document.getElementById('dropdownMenu');
    dropdownMenu.classList.remove('show');

    var questionInput = document.querySelector('input[name="pw_question"]');
    questionInput.value = value;
}

// 이하 실시간 유효성 검사
const idInput = document.getElementById('id');
const pwInput = document.getElementById('pw');
const pwChkInput = document.getElementById('pwChk');
const emailInput = document.getElementById('email');
const nameInput = document.getElementById('name');
const phoneNoInput = document.getElementById('phone_no');
const answerInput = document.getElementById('pw_answer');
const bnameInput = document.getElementById('b_name');

// 유효성검사 실행
idInput.addEventListener('input', valiId);
pwInput.addEventListener('input', valiPw);
pwChkInput.addEventListener('input', valiPwChk);
emailInput.addEventListener('input', valiEamil);
nameInput.addEventListener('input', valiName);
phoneNoInput.addEventListener('input', valiPhoneno);

if(answerInput) {
    answerInput.addEventListener('input', valiAnswer);
}
if(bnameInput) {
    bnameInput.addEventListener('input', valiBname);
}


// 아이디   
function valiId() {
    const idError = document.getElementById('id_error');
    const userID = idInput.value.trim();

    if (userID.length === 0) {
        idError.innerText = '아이디를 입력해주세요.';
    } else if (!/^[a-zA-Z0-9]{5,12}$/.test(userID)) {
        idError.innerText = '영문, 숫자로만 이루어진 6~20자로 작성해 주세요.';
    } else {
        idError.innerText = '';
    }
}

// 비밀번호
function valiPw() {
    const pwError = document.getElementById('pw_error');
    const pw = pwInput.value.trim();

    if (pw.length < 8 || pw.length > 20) {
        pwError.innerText = '비밀번호는 8~20글자로 작성해 주세요.';
    } else if (!/(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[~!@#$%^&*]).{8,20}/.test(pw)) {
        pwError.innerText = '비밀번호는 대문자, 소문자, 숫자, 특수문자(~, !, @, #, $, %, ^, &, *)를 최소 1글자씩 포함해야 합니다.';
    } else {
        pwError.innerText = '';
    }
}

// 비밀번호 확인
function valiPwChk() {
    const pwChkError = document.getElementById('pwChk_error');
    const pw = pwInput.value.trim();
    const pwChk = pwChkInput.value.trim();

    if (pw !== pwChk) {
        pwChkError.innerText = '비밀번호와 일치하지 않습니다.';
    } else {
        pwChkError.innerText = '';
    }
}

// 이메일
function valiEamil() {
    const emailError = document.getElementById('email_error');
    const email = emailInput.value.trim();

    if (!/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/.test(email)) {
        emailError.innerText = '유효한 이메일 형식을 입력해주세요.';
    } else if (email.length > 30) {
        emailError.innerText = '이메일은 최대 30글자까지 입력 가능합니다.';
    } else {
        emailError.innerText = '';
    }
}

// 이름
function valiName() {
    const nameError = document.getElementById('name_error');
    const name = nameInput.value.trim();

    if (name.length === 0) {
        nameError.innerText = '이름을 입력해주세요.';
    } else if (!/^[가-힣]+$/.test(name)) {
        nameError.innerText = '한글만 입력 가능합니다.';
    } else if (name.length > 20) {
        nameError.innerText = '20자 이하로 작성해 주세요.';
    } else {
        nameError.innerText = '';
    }
}

// 전화번호
function valiPhoneno() {
    const phoneNoError = document.getElementById('phone_no_error');
    const phoneNo = phoneNoInput.value.trim();

    if (!/^\d{10,11}$/.test(phoneNo)) {
        phoneNoError.innerText = '전화번호는 "-"을 뺀 숫자로만 작성해 주세요.';
    } else {
        phoneNoError.innerText = '';
    }
}

// 비밀번호 질문 답변
function valiAnswer() {
    const answerError = document.getElementById('pw_answer_error');
    const answer = answerInput.value.trim();

    if (answer.length < 1 || answer.length > 20) {
        answerError.innerText = '질문 답변은 1~20글자로 작성해 주세요.';
    } else if (!/^[가-힣]+$/.test(answer)) {
        answerError.innerText = '질문 답변은 한글로만 해주세요.';
    } else {
        answerError.innerText = '';
    }
}

// 상호명
function valiBname() {
    const bnameError = document.getElementById('b_name_error');
    const bname = bnameInput.value.trim();

    if (bname.length > 20) {
        bnameError.innerText = '상호명은 최대 20글자까지 입력 가능합니다.';
    } else {
        bnameError.innerText = '';
    }
}

// 다음 주소 api실행
function sample6_execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var addr = ''; // 주소 변수
            var extraAddr = ''; // 참고항목 변수

            //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                addr = data.roadAddress;
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                addr = data.jibunAddress;
            }

            // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
            if(data.userSelectedType === 'R'){
                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraAddr !== ''){
                    extraAddr = ' (' + extraAddr + ')';
                }

            } else {
                document.getElementById("sample6_extraAddress").value = '';
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            document.getElementById("sample6_address").value = addr;
        }
    }).open();
}