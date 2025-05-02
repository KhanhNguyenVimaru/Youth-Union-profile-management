let loginModal; // Biến toàn cục để sau này gọi .hide()

document.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem("myID") == null) {
        const loginEl = document.getElementById("Login");
        loginModal = new bootstrap.Modal(loginEl, {
            backdrop: 'static',
            keyboard: false
        });
        loginModal.show();
    }
});

function handleLogin() {
    const id = document.getElementById("login-get-id").value.trim();
    const password = document.getElementById("login-get-pass").value.trim();
    const user_data = {
        id: id,
        password: password
    }
    fetch("my_account.php", {
        method: "POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(user_data)
    })
        .then(response => response.json())
        .then(response => {
            if (!response.error) {
                console.log("Đăng nhập thành công!");
                const account_id = response.id;
                const role = response.role;

                localStorage.setItem("myID", account_id);
                localStorage.setItem("myRole", role);

                window.location.reload;
                loginModal.hide();
            }
            else{
                alert("Lỗi: " + response.message);
            }
        })
        .catch(error=>{
            alert(error.message);
        })
}

function loadPage(page) {
    window.location.href = page;
    console.log(localStorage);
}
