document.addEventListener("DOMContentLoaded", async function () {
    // Hàm load dữ liệu thông báo từ API
    async function loadNotify(params) {
        try {
            const response = await fetch('get_history.php', {
                method: 'POST', // Sử dụng phương thức POST để gửi dữ liệu
                headers: {
                    'Content-Type': 'application/json' // Đảm bảo gửi dưới dạng JSON
                },
                body: JSON.stringify(params) // Chuyển params thành JSON để gửi
            });

            const data = await response.json();

            // Kiểm tra nếu có lỗi từ phía server
            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Network response was not ok');
            }

            return data; // Trả về dữ liệu nếu không có lỗi
        } catch (error) {
            console.error('Error fetching notification data:', error);
            return null; // Nếu có lỗi, trả về null
        }
    }

    // Gọi API khi DOM đã sẵn sàng
    const params = { 
        id: localStorage.getItem("myID"), 
        role: localStorage.getItem("myRole") 
    };

    const data = await loadNotify(params); // Lấy dữ liệu từ API

    const tableBody = document.getElementById('show-history-data-here');
    
    if (data && Array.isArray(data.data) && data.success) { // Kiểm tra dữ liệu trả về hợp lệ
        let html = '';

        // Duyệt qua từng dòng dữ liệu và tạo bảng
        data.data.forEach(row => {
            html += `
                <tr>
                    <td>${row.id}</td>
                    <td>${row.id_actor}</td>
                    <td>${row.loai}</td>  <!-- Đảm bảo lấy đúng tên cột (loai) -->
                    <td>${row.noidung}</td>
                    <td>${row.thoigian}</td>
                </tr>
            `;
        });

        tableBody.innerHTML = html; // Cập nhật HTML của bảng
    } else {
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
    }
});
