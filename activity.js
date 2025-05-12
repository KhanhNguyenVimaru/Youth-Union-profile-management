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
    if (activity.danh_sach_tham_gia) {
        const participants = activity.danh_sach_tham_gia.split('; ');
        participantsList.innerHTML = participants.map(p => `<p style="font-family: bahnschrift; font-size: 16px !important;">${p}</p>`).join('');
    } else {
        participantsList.innerHTML = '<p style="font-family: bahnschrift; font-size: 16px !important;">Chưa có người tham gia</p>';
    }

    const modal = new bootstrap.Modal(document.getElementById('viewActivityModal'));
    modal.show();
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

// function loadEditActivityModal(id) {
//     if (!id) return;

//     const activity = activities.find(a => a.id === id);
//     if (!activity) return;

//     alert('Chức năng chỉnh sửa đang được phát triển');
// } 