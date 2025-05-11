// Function to fetch all select data
async function fetchSelectData() {
    try {
        const response = await fetch('get_select_data.php');
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.error || 'Network response was not ok');
        }
        
        return data;
    } catch (error) {
        console.error('Error fetching select data:', error);
        return null;
    }
}

// Function to populate select dropdowns
async function populateSelects() {
    const data = await fetchSelectData();
    if (!data) {
        console.error('Failed to fetch select data');
        return;
    }

    try {
        // Populate chi đoàn selects
        const chiDoanSelects = document.querySelectorAll('#get-depart, #uni-branch, #show-user-depart');
        chiDoanSelects.forEach(select => {
            while (select.options.length > 1) select.remove(1);
            data.chidoan.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.ten_chidoan;
                select.appendChild(option);
            });
        });

        // Populate lớp selects
        const lopSelects = document.querySelectorAll('#get-class-list, #class-list, #get-user-class-list');
        lopSelects.forEach(select => {
            while (select.options.length > 1) select.remove(1);
            
            // Group classes by chi đoàn
            const groupedLop = data.lop.reduce((acc, item) => {
                const chidoanId = item.chidoan_id;
                if (!acc[chidoanId]) acc[chidoanId] = [];
                acc[chidoanId].push(item);
                return acc;
            }, {});

            // Add options grouped by chi đoàn
            Object.entries(groupedLop).forEach(([chidoanId, classes]) => {
                const optgroup = document.createElement('optgroup');
                const chidoanName = data.chidoan.find(c => c.id === parseInt(chidoanId))?.ten_chidoan || `Chi đoàn ${chidoanId}`;
                optgroup.label = chidoanName;
                
                classes.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.ten_lop;
                    optgroup.appendChild(option);
                });
                
                select.appendChild(optgroup);
            });
        });

        // Populate niên khóa selects
        const nienKhoaSelects = document.querySelectorAll('#get-year-in, #aca-year, #show-user-year-in');
        nienKhoaSelects.forEach(select => {
            while (select.options.length > 1) select.remove(1);
            data.nienkhoa.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.ten_nienkhoa;
                select.appendChild(option);
            });
        });

        // Populate chức vụ selects
        const chucVuSelects = document.querySelectorAll('#get-role, #get-role-filter, #show-user-role');
        chucVuSelects.forEach(select => {
            while (select.options.length > 1) select.remove(1);
            data.chucvu.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.ten_chucvu;
                select.appendChild(option);
            });
        });
    } catch (error) {
        console.error('Error populating selects:', error);
    }
}

// Call the function when any modal is shown
document.addEventListener('DOMContentLoaded', () => {
    const modals = ['SignUp', 'filter', 'detail-data'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('show.bs.modal', populateSelects);
        }
    });
}); 