function check_pass() {
    if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
        document.getElementById('submit').disabled = false;
        document.getElementById("confirm-pass-msg").innerHTML = "";
    } else {    
        document.getElementById('submit').disabled = true;
        document.getElementById("confirm-pass-msg").innerHTML = "Password is not matched!";
    }
}