// Add pagination variables
let currentPage = 1;
const rowsPerPage = 15;
let totalPages = 1;
let allNotifications = [];

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

    // Function to display notifications for current page
    function displayNotifications() {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const notificationsToShow = allNotifications.slice(startIndex, endIndex);
        
        const tableBody = document.getElementById('show-history-data-here');
        let html = '';

        if (notificationsToShow.length > 0) {
            notificationsToShow.forEach(row => {
                html += `
                    <tr>
                        <td style="color: #6a6a6a">${row.id}</td>
                        <td style="color: #6a6a6a">${row.id_actor}</td>
                        <td style="color: #6a6a6a">${row.loai}</td>
                        <td style="color: #6a6a6a">${row.noidung}</td>
                        <td style="color: #6a6a6a">${row.thoigian}</td>
                    </tr>
                `;
            });
        } else {
            html = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
        }

        tableBody.innerHTML = html;
    }

    // Function to update pagination controls
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
        
        displayNotifications();
        updatePaginationControls();
    });

    // Initial load
    const params = { 
        id: localStorage.getItem("myID"), 
        role: localStorage.getItem("myRole") 
    };

    const data = await loadNotify(params);
    
    if (data && Array.isArray(data.data) && data.success) {
        allNotifications = data.data;
        totalPages = Math.ceil(allNotifications.length / rowsPerPage);
        currentPage = 1;
        displayNotifications();
        updatePaginationControls();
    } else {
        const tableBody = document.getElementById('show-history-data-here');
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
    }
});
