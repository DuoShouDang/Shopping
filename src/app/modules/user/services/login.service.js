
function showLogin() {
	var login_div = document.getElementById("login");
	var signin_div = document.getElementById("signin");
	signin_div.style.display = "none";
	login_div.style.display = "block";
}

function showSignin() {
	var login_div = document.getElementById("login");
	var signin_div = document.getElementById("signin");
    login_div.style.display = "none";
	signin_div.style.display = "block";
}

function unshowAll() {
    var login_div = document.getElementById("login");
    var signin_div = document.getElementById("signin");
    login_div.style.display = "none";
    signin_div.style.display = "none";
}

function checkLoginForm() {
	var input_pwd = document.getElementById('input-password');
    var md5_pwd = document.getElementById('md5-password');
    // 把用户输入的明文变为MD5:
    md5_pwd.value = toMD5(input_pwd.value);
    // 继续下一步:
    return true;
}

function checkSigninForm() {
	var input_pwd1 = document.getElementById('signin-password1');
	var input_pwd2 = document.getElementById('signin-password2');
	if (input_pwd1 !== input_pwd2) {
		//
		return false;
	}
    var md5_pwd = document.getElementById('signin-md5-password');
    // 把用户输入的明文变为MD5:
    md5_pwd.value = toMD5(input_pwd1.value);
    // 继续下一步:
    return true;
}