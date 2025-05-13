// Global variables
let activities = [];
let currentActivityId = null;

// Load activities when page loads
document.addEventListener('DOMContentLoaded', () => {
    loadActivities();
});

// Fetch activities from server
async function loadActivities() {
    try {
        const response = await fetch('get_hoatdong.php');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        activities = await response.json();
        displayActivities(activities);
    } catch (error) {
        console.error('Error loading activities:', error);
        alert('Có lỗi xảy ra khi tải danh sách hoạt động');
    }
}

function displayActivities(activitiesToShow) {
    const container = document.getElementById('activities-container');
    container.innerHTML = '';

    activitiesToShow.forEach((activity, index) => {
        const row = document.createElement('tr');   
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${activity.ten_hoat_dong}</td>
            <td>${formatDate(activity.ngay_to_chuc)}</td>
            <td>${activity.dia_diem}</td>
            <td>${activity.loai_hoat_dong}</td>
            <td>${activity.so_luong_tham_gia}</td>
            <td>${activity.diem}</td>
            <td>
                <div class="action-buttons">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="viewActivity(${activity.id})">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </td>
            <td>
                <div class="action-buttons">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteActivity(${activity.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        `;
        container.appendChild(row);
    });
}

// Get badge class based on status
function getStatusBadgeClass(status) {
    switch (status.toLowerCase()) {
        case 'chờ duyệt':
            return 'status-pending';
        case 'đã duyệt':
            return 'status-approved';
        case 'đã kết thúc':
            return 'status-completed';
        default:
            return '';
    }
}

// Format date to Vietnamese format
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('vi-VN', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

// Filter activities
function filterActivities() {
    const status = document.getElementById('status-filter').value;
    const type = document.getElementById('type-filter').value;
    const search = document.getElementById('search-input').value.toLowerCase();

    const filtered = activities.filter(activity => {
        const matchesStatus = !status || activity.trang_thai.toLowerCase() === status.toLowerCase();
        const matchesType = !type || activity.loai_hoat_dong.toLowerCase() === type.toLowerCase();
        const matchesSearch = !search || 
            activity.ten_hoat_dong.toLowerCase().includes(search) ||
            activity.dia_diem.toLowerCase().includes(search);

        return matchesStatus && matchesType && matchesSearch;
    });

    displayActivities(filtered);
}

// Load add activity modal
function loadAddActivityModal() {
    const modal = new bootstrap.Modal(document.getElementById('addActivityModal'));
    document.getElementById('addActivityForm').reset();
    modal.show();
}

// Save new activity
async function saveActivity() {
    const form = document.getElementById('addActivityForm');
    const formData = new FormData(form);
    // Thêm id_actor từ localStorage
    formData.append('id_actor', localStorage.getItem('myID'));
    console.log(formData);
    
    try {
        const response = await fetch('save_activity.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();
        if (result.status === 'success') {
            bootstrap.Modal.getInstance(document.getElementById('addActivityModal')).hide();
            loadActivities();
            alert('Thêm hoạt động thành công');
        } else {
            throw new Error(result.message || 'Có lỗi xảy ra');
        }
    } catch (error) {
        console.error('Error saving activity:', error);
        alert('Có lỗi xảy ra khi lưu hoạt động');
    }
}

// View activity details
async function viewActivity(id) {
    currentActivityId = id;
    const activity = activities.find(a => a.id === id);
    
    if (!activity) {
        alert('Không tìm thấy thông tin hoạt động');
        return;
    }

    const detailsContainer = document.getElementById('activity-details');
    detailsContainer.innerHTML = `
        <h4 style="font-family: bahnschrift; font-size: 20px !important; margin-bottom: 20px;">${activity.ten_hoat_dong}</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="activity-info" style="font-family: bahnschrift; font-size: 16px !important;">
                    <p style="font-size: 16px !important;"><strong>Ngày tổ chức:</strong> ${formatDate(activity.ngay_to_chuc)}</p>
                    <p style="font-size: 16px !important;"><strong>Địa điểm:</strong> ${activity.dia_diem}</p>
                    <p style="font-size: 16px !important;"><strong>Loại hoạt động:</strong> ${activity.loai_hoat_dong}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="activity-info" style="font-family: bahnschrift; font-size: 16px !important;">
                    <p style="font-size: 16px !important;"><strong>Số lượng tham gia:</strong> ${activity.so_luong_tham_gia}</p>
                    <p style="font-size: 16px !important;"><strong>Điểm:</strong> ${activity.diem}</p>
                    <p style="font-size: 16px !important;"><strong>Trạng thái:</strong> ${activity.trang_thai}</p>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="activity-info" style="font-family: bahnschrift; font-size: 16px !important;">
                    <p style="font-size: 16px !important;"><strong>Nội dung:</strong></p>
                    <p style="white-space: pre-wrap; font-size: 16px !important;">${activity.noi_dung}</p>
                </div>
            </div>
        </div>
    `;

    const participantsList = document.getElementById('participants-list');
    if (activity.participants && activity.participants.length > 0) {
        participantsList.innerHTML = `
            <table class="table table-bordered" style="font-family: bahnschrift; font-size: 16px !important;">
                <thead>
                    <tr>
                        <th>ID Đoàn viên</th>
                        <th>Họ tên</th>
                        <th>ID Hoạt động</th>
                        <th>Tên hoạt động</th>
                        <th>Điểm riêng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    ${activity.participants.map(participant => `
                        <tr>
                            <td>${participant.doanvien_id}</td>
                            <td>${participant.ho_ten}</td>
                            <td>${participant.hoatdong_id}</td>
                            <td>${participant.ten_hoat_dong}</td>
                            <td>
                                <input type="number" class="form-control diem-rieng-input" 
                                    data-doanvien-id="${participant.doanvien_id}" 
                                    data-hoatdong-id="${participant.hoatdong_id}" 
                                    value="${participant.diem_rieng}" 
                                    style="width: 100px;"
                                    onchange="updateDiemRieng(this)">
                            </td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" 
                                    onclick="saveDiemRieng(${participant.doanvien_id}, ${participant.hoatdong_id})">
                                    Lưu
                                </button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    } else {
        participantsList.innerHTML = '<p style="font-family: bahnschrift; font-size: 16px !important;">Chưa có người tham gia</p>';
    }

    const modal = new bootstrap.Modal(document.getElementById('viewActivityModal'));
    modal.show();
}

// Function to update diem_rieng
async function saveDiemRieng(doanvienId, hoatdongId) {
    const input = document.querySelector(`input[data-doanvien-id="${doanvienId}"][data-hoatdong-id="${hoatdongId}"]`);
    const diemRieng = parseInt(input.value) || 0;

    try {
        const formData = new FormData();
        formData.append('doanvien_id', doanvienId);
        formData.append('hoatdong_id', hoatdongId);
        formData.append('diem_rieng', diemRieng);

        const response = await fetch('update_diem_rieng.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();
        if (result.status === 'success') {
            alert('Cập nhật điểm riêng thành công');
            loadActivities(); // Reload activities to update data
            viewActivity(currentActivityId); // Refresh the modal
        } else {
            throw new Error(result.message || 'Có lỗi xảy ra');
        }
    } catch (error) {
        console.error('Error updating diem_rieng:', error);
        alert('Có lỗi xảy ra khi cập nhật điểm riêng');
    }
}

async function deleteActivity(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa hoạt động này?')) {
        return;
    }

    try {
        const formData = new FormData();
        formData.append('activity_id', id);
        formData.append('id_actor', localStorage.getItem('myID'));

        const response = await fetch('delete_activity.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();
        if (result.status === 'success') {
            loadActivities();
            alert('Xóa hoạt động thành công');
        } else {
            throw new Error(result.message || 'Có lỗi xảy ra');
        }
    } catch (error) {
        console.error('Error deleting activity:', error);
        alert('Có lỗi xảy ra khi xóa hoạt động');
    }
}