// Function to load filter modal
function loadFilter() {
    const filterModal = new bootstrap.Modal(document.getElementById('filter'));
    filterModal.show();
}

// Function to load sign up modal
function loadSignUpModal() {
    const signUpModal = new bootstrap.Modal(document.getElementById('SignUp'));
    signUpModal.show();
}

// Function to load detail modal with user data
function loadDetailModal(userId) {
    const detailModal = new bootstrap.Modal(document.getElementById('detail-data'));
    // TODO: Add code to load user data here
    detailModal.show();
} 