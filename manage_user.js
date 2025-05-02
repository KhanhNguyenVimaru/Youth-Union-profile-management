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

let currentPage = 1;
const rowsPerPage = 15;
let totalPages = 1;
let allUsers = [];

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
        allUsers = data.users;
        totalPages = Math.ceil(allUsers.length / rowsPerPage);
        currentPage = 1; // Reset to first page when new data is loaded
        displayUsers();
        updatePaginationControls();
    })
    .catch(error => {
        console.error("Có lỗi xảy ra khi tìm kiếm:", error);
    });
}

function displayUsers() {
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const usersToShow = allUsers.slice(startIndex, endIndex);
    
    const resultContainer = document.getElementById("show-data-here");
    resultContainer.innerHTML = "";
    
    usersToShow.forEach(item => {
        const row = document.createElement("tr");
        row.classList.add("st-data");
        row.innerHTML = `
            <th scope="row" class="show-user-id">${item.doanvien_id}</th>
            <td>${item.ho_ten}</td>
            <td>${item.ngay_sinh}</td>
            <td>${item.ten_lop} - ${item.nienkhoa}</td>
            <td>${item.ten_chidoan}</td>
            <td>${item.sdt}</td>
            <td>${item.email}</td>
        `;
        resultContainer.appendChild(row);
    });
}

function updatePaginationControls() {
    const paginationControls = document.getElementById('pagination-controls');
    const prevPage = document.getElementById('prev-page');
    const nextPage = document.getElementById('next-page');
    
    // Clear existing page numbers
    const existingPageItems = paginationControls.querySelectorAll('.page-item:not(:first-child):not(:last-child)');
    existingPageItems.forEach(item => item.remove());
    
    // Add page numbers
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
        paginationControls.insertBefore(li, nextPage.parentElement);
    }
    
    // Update prev/next button states
    prevPage.parentElement.classList.toggle('disabled', currentPage === 1);
    nextPage.parentElement.classList.toggle('disabled', currentPage === totalPages);
}

// Add event listeners for pagination
document.addEventListener('DOMContentLoaded', () => {
    const paginationControls = document.getElementById('pagination-controls');
    
    paginationControls.addEventListener('click', (e) => {
        e.preventDefault();
        const target = e.target.closest('.page-link');
        if (!target) return;
        
        if (target.id === 'prev-page' && currentPage > 1) {
            currentPage--;
        } else if (target.id === 'next-page' && currentPage < totalPages) {
            currentPage++;
        } else if (target.dataset.page) {
            currentPage = parseInt(target.dataset.page);
        }
        
        displayUsers();
        updatePaginationControls();
    });
    
    // Load initial data
    loadDataBase();
});

const seletedUserID = {
    id  : null
} 
document.getElementById("show-data-here").addEventListener("click", function (e) {
    const clickedRow = e.target.closest(".st-data");
    if (clickedRow) {
        const detail = document.getElementById("detail-data");
        if (detail) {
            let detailModal = new bootstrap.Modal(detail);
            detailModal.show();
            const idCell = clickedRow.querySelector(".show-user-id");
            const id = idCell ? idCell.textContent.trim() : "NULL";
            seletedUserID.id = id;
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



// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to handle saving changes from detail modal
function saveDetailChanges() {
    const userId = seletedUserID.id;
    const userData = {
        id: userId,
        ho_ten: document.getElementById('show-user-name').value,
        gioi_tinh: document.getElementById('show-user-gender').value,
        ngay_sinh: document.getElementById('show-user-birthdate').value,
        lop_id: document.getElementById('get-user-class-list').value,
        chidoan_id: document.getElementById('show-user-depart').value,
        khoa: document.getElementById('show-user-depart').value,
        email: document.getElementById('show-user-email').value,
        sdt: document.getElementById('show-user-tel').value,
        chuc_vu: document.getElementById('show-user-role').value,
        nienkhoa: document.getElementById('show-user-year-in').value
    };

    // Create FormData object to handle file upload
    const formData = new FormData();
    formData.append('userData', JSON.stringify(userData));
    
    const profileFile = document.getElementById('profile-file');
    if (profileFile.files.length > 0) {
        formData.append('profile_image', profileFile.files[0]);
    }

    // Send data to server
    fetch('update_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cập nhật thông tin thành công!');
            // Refresh the user list
            loadDataBase();
            // Close the modal
            const detailModal = bootstrap.Modal.getInstance(document.getElementById('detail-data'));
            detailModal.hide();
        } else {
            alert('Có lỗi xảy ra: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật thông tin');
    });
}

// Function to handle deleting user
function deleteUser() {
    const userId = seletedUserID.id;
    
    if (confirm('Bạn có chắc chắn muốn xóa tài khoản này?')) {
        fetch('delete_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Xóa tài khoản thành công!');
                // Refresh the user list
                loadUserList();
                // Close the modal
                const detailModal = bootstrap.Modal.getInstance(document.getElementById('detail-data'));
                detailModal.hide();
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

// Add event listeners for the save and delete buttons
document.addEventListener('DOMContentLoaded', function() {
    const saveButton = document.querySelector('#detail-data .modal-footer .btn-primary');
    const deleteButton = document.querySelector('#detail-data .modal-footer .btn-outline-danger');

    if (saveButton) {
        saveButton.addEventListener('click', saveDetailChanges);
    }

    if (deleteButton) {
        deleteButton.addEventListener('click', deleteUser);
    }
});

// Hàm xử lý khi thay đổi khoa cho tất cả các modal
function handleFacultyChange(event) {
    const facultySelect = event.target;
    const modalId = facultySelect.closest('.modal').id;
    let classSelect;
    
    // Xác định select lớp tương ứng với modal
    switch(modalId) {
        case 'SignUp':
            classSelect = document.getElementById('get-class-list');
            break;
        case 'filter':
            classSelect = document.getElementById('class-list');
            break;
        case 'detail-data':
            classSelect = document.getElementById('get-user-class-list');
            break;
        default:
            return;
    }

    const optgroups = classSelect.querySelectorAll('optgroup');

    // Ẩn tất cả các optgroup
    optgroups.forEach(group => group.style.display = 'none');

    // Hiển thị optgroup tương ứng với khoa được chọn
    const selectedFaculty = facultySelect.value;
    if (selectedFaculty !== 'none') {
        const facultyMap = {
            "1": "Khoa Hàng hải",
            "2": "Khoa Công nghệ thông tin",
            "3": "Khoa Kinh tế",
            "4": "Khoa Quản trị - Tài chính",
            "5": "Khoa Cơ khí - Điện",
            "6": "Khoa Công trình",
            "7": "Khoa Môi trường",
            "8": "Khoa Ngoại ngữ",
            "9": "Viện Đào tạo Sau đại học"
        };

        const facultyName = facultyMap[selectedFaculty];
        const targetGroup = Array.from(optgroups).find(group => group.label === facultyName);
        
        if (targetGroup) {
            targetGroup.style.display = 'block';
            // Reset selection về option đầu tiên
            classSelect.selectedIndex = 0;
        }
    } else {
        // Nếu chọn "Khoa/Viện" (none), hiển thị tất cả các lớp
        optgroups.forEach(group => group.style.display = 'block');
    }
}

// Thêm event listener cho tất cả các select khoa trong các modal
document.addEventListener('DOMContentLoaded', function() {
    // Modal SignUp
    const signUpFacultySelect = document.querySelector('#SignUp select[name="get-depart"]');
    if (signUpFacultySelect) {
        signUpFacultySelect.addEventListener('change', handleFacultyChange);
    }

    // Modal Filter
    const filterFacultySelect = document.querySelector('#filter select[name="uni-branch"]');
    if (filterFacultySelect) {
        filterFacultySelect.addEventListener('change', handleFacultyChange);
    }

    // Modal Detail
    const detailFacultySelect = document.querySelector('#detail-data select[name="show-user-depart"]');
    if (detailFacultySelect) {
        detailFacultySelect.addEventListener('change', handleFacultyChange);
    }
});



