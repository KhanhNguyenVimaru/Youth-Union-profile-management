document.getElementById("insert-user-btn").addEventListener("click", function () {
    // userdata 
    let id = document.getElementById("new_users_id").value.trim();
    let ten = document.getElementById("new_users_name").value.trim();
    let pass = document.getElementById("new_users_password");
    let confirm = document.getElementById("confirm_password");
    let email = document.getElementById("get-user-email").value.trim();
    let phone = document.getElementById("get-user-tel").value.trim();
    let gender = document.getElementById("gender").value;
    let userClass = document.getElementById("get-class-list").value;
    let department = document.getElementById("get-depart").value;
    let role = document.getElementById("get-role").value;
    let birthdate = document.getElementById("get-birthdate").value;
    let yearin = document.getElementById("get-year-in").value;


    if (!id || !ten || !email || !phone || gender === "none" || userClass === "0" || department === "none" || role === "none" || birthdate === "" || yearin === "none") {
        alert("Vui lòng điền đầy đủ tất cả các trường!");
        return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Email không hợp lệ!");
        return;
    }

    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        alert("Số điện thoại không hợp lệ! Vui lòng nhập 10 chữ số.");
        return;
    }

    if (!confirmPassWord(pass, confirm)) {
        alert("Mật khẩu xác nhận không khớp!");
        return;
    }

    let user = {
        id: id,
        ten: ten,
        password: pass.value,
        email: email,
        phone: phone,
        gender: gender,
        userClass: userClass,
        department: department,
        role: role,
        birthdate: birthdate,
        yearin: yearin
    };
    console.log(user);

    insertUser(user);
});
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
            window.location.reload();
            return;
        }

        const data = await response.json();

        if (!data.success) {
            alert("Lỗi: " + data.message);
            window.location.reload();
        } else {
            alert(data.message);
            window.location.reload();
        }
    } catch (error) {
        alert("Lỗi: " + error);
        window.location.reload();
    }
}

document.getElementById("filter-btn").addEventListener("click", function () {
    loadDataBase();
});
document.addEventListener("DOMContentLoaded", function () {
    loadDataBase();
})

function loadDataBase() {
    const searchValue = document.getElementById("search-user").value;
    const classList = document.getElementById("class-list").value;
    const acaYear = document.getElementById("aca-year").value;
    const uniBranch = document.getElementById("uni-branch").value;
    const sortOn = document.getElementById("get-search-on").value;
    const sortSide = document.getElementById("get-sort-side").value;

    fetch("select_users.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            search: searchValue,
            class: classList,
            year: acaYear,
            branch: uniBranch,
            sortOn: sortOn,
            sortSide: sortSide
        })
    })
        .then(response => response.json())
        .then(data => {
            const resultContainer = document.getElementById("show-data-here");
            resultContainer.innerHTML = "";
            data.users.forEach(item => {
                const row = document.createElement("tr");
                row.classList.add("st-data");
                row.innerHTML = `
                <th scope="row" class = "show-user-id">${item.doanvien_id}</th>
                <td>${item.ho_ten}</td>
                <td>${item.ngay_sinh}</td>
                <td>${item.ten_lop} - ${item.nienkhoa}</td>
                <td>${item.ten_chidoan}</td>
                <td>${item.email}</td>
            `;
                resultContainer.appendChild(row);
            });
        })
        .catch(error => {
            console.error("Có lỗi xảy ra khi tìm kiếm:", error);
        });
}

document.getElementById("show-data-here").addEventListener("click", function (e) {
    const clickedRow = e.target.closest(".st-data");
    if (clickedRow) {
        const detail = document.getElementById("detail-data");
        if (detail) {
            let detailModal = new bootstrap.Modal(detail);
            detailModal.show();
            const idCell = clickedRow.querySelector(".show-user-id");
            const id = idCell ? idCell.textContent.trim() : "Không có ID";
            console.log("id: " + id);
            getUserData(id);
        }
    }
});

function getUserData(id) {
    const userId = { id: id }; // hoặc viết gọn là { id }

    fetch("get_user_data.php", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userId)
    })
    .then(response => response.json()) // cần có dấu () sau json
    .then(response => {
        if (response.success) {
            const user = response.data;
            document.getElementById("show-user-id").value = user.doanvien_id;
            document.getElementById("show-user-name").value = user.ho_ten;
            document.getElementById("show-user-gender").value = user.gioi_tinh.toLowerCase() === "nữ" ? "nu" : "nam";
            document.getElementById("show-user-birthdate").value = user.ngay_sinh;
            document.getElementById("show-user-depart").value = user.khoa;
            document.getElementById("show-user-email").value = user.email;
            document.getElementById("show-user-tel").value = user.sdt;
            document.getElementById("show-user-role").value = user.chuc_vu;
            document.getElementById("show-user-year-in").value = user.nienkhoa;
            document.getElementById("get-user-class-list").value = user.lop_id;
        } else {
            console.error("Lỗi dữ liệu:", response);
        }
    })
    .catch(error => {
        console.error("Lỗi fetch:", error);
    });
}
