// Function to fetch khoa data
async function fetchKhoa() {
    try {
        const response = await fetch('get_chidoan.php.php');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return await response.json();
    } catch (error) {
        console.error('Error fetching khoa data:', error);
        return [];
    }
}

// Function to populate khoa select dropdowns
async function populateKhoaSelects() {
    const khoaData = await fetchKhoa();
    
    // Get all select elements that need khoa data
    const khoaSelects = document.querySelectorAll('#get-depart, #uni-branch');
    
    khoaSelects.forEach(select => {
        // Clear existing options except the first one (placeholder)
        while (select.options.length > 1) {
            select.remove(1);
        }
        
        // Add new options
        khoaData.forEach(khoa => {
            const option = document.createElement('option');
            option.value = khoa.id;
            option.textContent = khoa.ten_chidoan;
            select.appendChild(option);
        });
    });
}

// Call the function when the modal is shown
document.addEventListener('DOMContentLoaded', () => {
    // For the SignUp modal
    const signUpModal = document.getElementById('SignUp');
    if (signUpModal) {
        signUpModal.addEventListener('show.bs.modal', populateKhoaSelects);
    }

    // For the filter modal
    const filterModal = document.getElementById('filter');
    if (filterModal) {
        filterModal.addEventListener('show.bs.modal', populateKhoaSelects);
    }
}); 