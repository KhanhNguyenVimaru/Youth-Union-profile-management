 // Function to fetch chidoan data
async function fetchChidoan() {
    try {
        const response = await fetch('get_chidoan.php');
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.error || 'Network response was not ok');
        }
        
        return data;
    } catch (error) {
        console.error('Error fetching chidoan data:', error);
        return null;
    }
}

// Function to populate chidoan select dropdowns
async function populateChidoanSelects() {
    const chidoanData = await fetchChidoan();
    if (!chidoanData) {
        console.error('Failed to fetch chidoan data');
        return;
    }

    try {
        // Get all select elements that need chidoan data
        const chidoanSelects = document.querySelectorAll('#get-depart, #uni-branch, #show-user-depart');
        
        chidoanSelects.forEach(select => {
            // Clear existing options except the first one (placeholder)
            while (select.options.length > 1) {
                select.remove(1);
            }
            
            // Add options
            chidoanData.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.ten_chidoan;
                select.appendChild(option);
            });
        });
    } catch (error) {
        console.error('Error populating chidoan selects:', error);
    }
}

// Call the function when any modal is shown
document.addEventListener('DOMContentLoaded', () => {
    const modals = ['SignUp', 'filter', 'detail-data'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('show.bs.modal', populateChidoanSelects);
        }
    });
}); 