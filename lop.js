// Function to fetch lop data
async function fetchLop() {
    try {
        const response = await fetch('get_lop.php');
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.error || 'Network response was not ok');
        }
        
        return data;
    } catch (error) {
        console.error('Error fetching lop data:', error);
        return null;
    }
}

// Function to populate lop select dropdowns based on selected department
async function populateLopSelects() {
    const lopData = await fetchLop();
    if (!lopData) {
        console.error('Failed to fetch lop data');
        return;
    }

    try {
        // Get all select elements that need lop data
        const lopSelects = document.querySelectorAll('#get-class-list, #class-list, #get-user-class-list');
        
        // Get all department selects
        const departSelects = document.querySelectorAll('#get-depart, #uni-branch, #show-user-depart');
        
        // Function to update class options based on selected department
        function updateClassOptions(departId) {
            lopSelects.forEach(select => {
                // Clear existing options except the first one (placeholder)
                while (select.options.length > 1) {
                    select.remove(1);
                }
                
                if (departId && departId !== 'none') {
                    // Filter classes for selected department
                    const filteredClasses = lopData.filter(item => 
                        item.chidoan_id === parseInt(departId)
                    );
                    
                    // Add filtered options
                    filteredClasses.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.ten_lop;
                        select.appendChild(option);
                    });
                }
            });
        }

        // Add change event listeners to department selects
        departSelects.forEach(select => {
            select.addEventListener('change', (e) => {
                updateClassOptions(e.target.value);
            });
        });

        // Initial population based on default selected department
        departSelects.forEach(select => {
            if (select.value && select.value !== 'none') {
                updateClassOptions(select.value);
            }
        });

    } catch (error) {
        console.error('Error populating lop selects:', error);
    }
}

// Call the function when any modal is shown
document.addEventListener('DOMContentLoaded', () => {
    const modals = ['SignUp', 'filter', 'detail-data'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('show.bs.modal', populateLopSelects);
        }
    });
}); 