document.addEventListener("DOMContentLoaded", async function () {
    // Hàm load dữ liệu hoạt động từ API
    async function loadEvents(params = {}) {
        try {
            const response = await fetch('get_events.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(params)
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Không thể tải dữ liệu hoạt động');
            }

            return data;
        } catch (error) {
            console.error('Lỗi khi tải dữ liệu hoạt động:', error);
            alert('Đã xảy ra lỗi khi tải dữ liệu: ' + error.message);
            return null;
        }
    }

    // Function to display events
    function displayEvents(events) {
        const container = document.getElementById('eventContainer');
        let html = '';

        if (events && events.length > 0) {
            events.forEach(event => {
                const statusClass = getStatusClass(event.trang_thai);
                const statusText = getStatusText(event.trang_thai);
                
                html += `
                    <div class="event-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">${event.ten_hoat_dong}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Loại hoạt động:</strong> ${event.loai_hoat_dong}</p>
                            <p class="card-text"><strong>Thời gian:</strong> ${formatDate(event.ngay_to_chuc)}</p>
                            <p class="card-text"><strong>Địa điểm:</strong> ${event.dia_diem}</p>
                            <p class="card-text"><strong>Người tổ chức:</strong> ${event.nguoi_tao}</p>
                            <p class="card-text">${event.noi_dung}</p>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="event-status ${statusClass}">${statusText}</span>
                                <button class="btn btn-outline-primary btn-sm" onclick="viewEventDetails(${event.id})">
                                    Chi tiết
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            html = '<div class="col-12 text-center">Không có hoạt động nào</div>';
        }

        container.innerHTML = html;
    }

    // Helper function to get status class
    function getStatusClass(status) {
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

    // Helper function to get status text
    function getStatusText(status) {
        switch (status.toLowerCase()) {
            case 'chờ duyệt':
                return 'Chờ duyệt';
            case 'đã duyệt':
                return 'Đã duyệt';
            case 'đã kết thúc':
                return 'Đã kết thúc';
            default:
                return status;
        }
    }

    // Helper function to format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Function to apply filters
    async function applyFilters() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const eventType = document.getElementById('eventType').value;
        const eventStatus = document.getElementById('eventStatus').value;

        const params = {
            startDate: startDate,
            endDate: endDate,
            eventType: eventType !== 'all' ? eventType : '',
            eventStatus: eventStatus !== 'all' ? eventStatus : ''
        };

        const data = await loadEvents(params);
        if (data && data.success) {
            displayEvents(data.data);
        }
    }

    // Add event listener for filter button
    document.getElementById('filterBtn').addEventListener('click', () => {
        const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));
        filterModal.show();
    });

    // Add event listener for apply filter button
    document.getElementById('applyFilter').addEventListener('click', async () => {
        await applyFilters();
        const filterModal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
        filterModal.hide();
    });

    // Add event listener for search input
    const searchInput = document.getElementById('searchEvent');
    let searchTimeout;
    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(async () => {
            const params = {
                search: e.target.value
            };
            const data = await loadEvents(params);
            if (data && data.success) {
                displayEvents(data.data);
            }
        }, 500);
    });

    // Function to check if user has joined the event
    async function hasJoinedEvent(userId, eventId) {
        try {
            const formData = new FormData();
            formData.append('user_id', userId);
            formData.append('event_id', eventId);

            const response = await fetch('check_participation.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            return result.status === 'joined';
        } catch (error) {
            console.error('Error checking participation:', error);
            return false;
        }
    }

    // Function to view event details
    window.viewEventDetails = async function(eventId) {
        // Tìm hoạt động trong danh sách
        const event = allEvents.find(e => e.id === eventId);
        if (!event) {
            alert('Không tìm thấy hoạt động!');
            return;
        }

        // Cập nhật nội dung modal
        document.getElementById('detail-name').textContent = event.ten_hoat_dong;
        document.getElementById('detail-type').textContent = event.loai_hoat_dong;
        document.getElementById('detail-date').textContent = formatDate(event.ngay_to_chuc);
        document.getElementById('detail-location').textContent = event.dia_diem;
        document.getElementById('detail-organizer').textContent = event.nguoi_tao;
        document.getElementById('detail-capacity').textContent = event.so_luong_tham_gia;
        document.getElementById('detail-points').textContent = event.diem;
        document.getElementById('detail-status').textContent = getStatusText(event.trang_thai);
        document.getElementById('detail-content').textContent = event.noi_dung;

        // Kiểm tra myRole từ localStorage
        const myRole = localStorage.getItem('myRole');
        const userId = localStorage.getItem('myID');
        const modalFooter = document.querySelector('#detailModal .modal-footer');

        // Kiểm tra trạng thái tham gia nếu là đoàn viên
        let hasJoined = false;
        if (myRole === 'doanvien' && userId) {
            hasJoined = await hasJoinedEvent(userId, eventId);
        }

        modalFooter.innerHTML = `
            <div class="d-flex justify-content-between w-100">
                <div class="d-flex align-items-center">
                    ${myRole === 'admin' ? `
                        <button type="button" class="btn btn-outline-danger me-2" onclick="deleteActivity(${event.id})">Xóa</button>
                        ${event.trang_thai.toLowerCase() === 'chờ duyệt' ? `
                            <button type="button" class="btn btn-outline-primary me-2" onclick="approveEvent(${event.id})">Duyệt</button>
                        ` : ''}
                    ` : myRole === 'doanvien' ? `
                        ${hasJoined ? `
                            <button type="button" class="btn btn-outline-danger me-2" onclick="leaveActivity(${event.id})">Thoát</button>
                            <span style="font-family: Bahnschrift; font-size: 16px;">Bạn đã tham gia!</span>
                        ` : `
                            <button type="button" class="btn btn-outline-primary me-2" onclick="joinActivity(${event.id})">Tham gia</button>
                        `}
                    ` : ''}
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        `;

        // Hiển thị modal
        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        detailModal.show();

        // Xóa các nút khi modal đóng
        document.getElementById('detailModal').addEventListener('hidden.bs.modal', function () {
            modalFooter.innerHTML = `
                <div class="d-flex justify-content-between w-100">
                    <div></div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            `;
        }, { once: true });
    };

    // Function to delete activity
    window.deleteActivity = async function(id) {
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
                await loadEvents(); // Tải lại danh sách hoạt động
                displayEvents(allEvents); // Cập nhật giao diện
                alert('Xóa hoạt động thành công');
            } else {
                throw new Error(result.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            console.error('Error deleting activity:', error);
        }
    };

    // Function to approve event
    window.approveEvent = async function(eventId) {
        try {
            const response = await fetch('approve_event.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: eventId })
            });

            const data = await response.json();
            if (data.success) {
                alert(data.message);
                await loadEvents(); // Tải lại danh sách hoạt động
                displayEvents(allEvents); // Cập nhật giao diện
            } else {
                alert('Lỗi: ' + data.message);
            }
        } catch (error) {
            console.error('Lỗi khi duyệt hoạt động:', error);
        }
    };

    // Function to join activity
    window.joinActivity = async function(eventId) {
        const userId = localStorage.getItem('myID');
        if (!userId) {
            alert('Vui lòng đăng nhập để tham gia hoạt động!');
            return;
        }

        try {
            const formData = new FormData();
            formData.append('user_id', userId);
            formData.append('event_id', eventId);

            const response = await fetch('join_activity.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            if (result.status === 'success') {
                alert('Tham gia hoạt động thành công!');
                await loadEvents(); // Tải lại danh sách hoạt động (nếu cần cập nhật)
                displayEvents(allEvents); // Cập nhật giao diện
                viewEventDetails(eventId); // Tải lại modal để cập nhật nút
            } else {
                throw new Error(result.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            console.error('Error joining activity:', error);
            alert('Có lỗi xảy ra khi tham gia hoạt động: ' + error.message);
        }
    };

    // Function to leave activity
    window.leaveActivity = async function(eventId) {
        const userId = localStorage.getItem('myID');
        if (!userId) {
            alert('Vui lòng đăng nhập để rời hoạt động!');
            return;
        }

        if (!confirm('Bạn có chắc chắn muốn rời hoạt động này?')) {
            return;
        }

        try {
            const formData = new FormData();
            formData.append('user_id', userId);
            formData.append('event_id', eventId);

            const response = await fetch('leave_activity.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            if (result.status === 'success') {
                alert('Rời hoạt động thành công!');
                await loadEvents(); // Tải lại danh sách hoạt động (nếu cần cập nhật)
                displayEvents(allEvents); // Cập nhật giao diện
                viewEventDetails(eventId); // Tải lại modal để cập nhật nút
            } else {
                throw new Error(result.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            console.error('Error leaving activity:', error);
            alert('Có lỗi xảy ra khi rời hoạt động: ' + error.message);
        }
    };

    // Initial load
    const data = await loadEvents();
    if (data && data.success) {
        allEvents = data.data; // Lưu danh sách hoạt động
        displayEvents(data.data);
    }
});