document.getElementById("insert-user-btn").addEventListener("click", function () {
    let id = document.getElementById("new_users_id").value;
    let ten = document.getElementById("new_users_name").value;
    let pass = document.getElementById("new_users_password");
    let confirm = document.getElementById("confirm_password");
    if (id == "" || ten == "") {
        alert("Hãy điền tất cả các trường dữ liệu");
        id = "";
        ten = "";
        pass.value = "";
    }

    if (confirmPassWord(pass, confirm)) {
        password = pass.value;
        let user = {
            id, ten, password
        }
        insertUser(user);
    }


})
function confirmPassWord(passInput, confirmInput) {
    const pass = passInput.value;
    const confirm = confirmInput.value;

    if (pass.length < 8) {
        alert("Password must be at least 8 characters!");
        passInput.value = "";
        confirmInput.value = "";
        return false;
    }

    if (pass !== confirm) {
        confirmInput.classList.add("error-shake");
        setTimeout(() => confirmInput.classList.remove("error-shake"), 300);
        confirmInput.value = "";
        return false;
    }

    return true;
};
async function insertUser(user) {
    try {
        const response = await fetch("insert_user.php", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(user)
        });

        if (!response.ok) {
            alert("Dữ liệu gửi đi lỗi");
            return;
        }

        const data = await response.json();

        if (!data.success) {
            alert("Lỗi ở check success: " + data.message);
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Có lỗi xảy ra:', error);
    }
}
