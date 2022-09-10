let usernameValid = false;
let username = document.querySelector("#username");
username.addEventListener("input", checkUserName);

function checkUserName() {
    usernameValid = username.length < 21 && username.length > 4;
}

let passwordValid = false;
let password = document.querySelector("#password");
password.addEventListener("input", checkPassWord);

function checkPassWord() {
    passwordValid = password.length < 21 && password.length > 4;
}

function checkForm(event) {
    if(!usernameValid || !passwordValid){
        event.preventDefault();
    }
}