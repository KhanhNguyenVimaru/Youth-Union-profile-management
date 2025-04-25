document.addEventListener('DOMContentLoaded', () => {
    const signUp = document.getElementById("SignUp");
    const filter = document.getElementById("filter");

    if (signUp) {
        signUpModal = new bootstrap.Modal(signUp);
    }
    if(filter){
        filterModal = new bootstrap.Modal(filter);
    }
});

function loadSignUpModal() {
    if (signUpModal) signUpModal.show();
}
function loadFilter(){
    if(filterModal) filterModal.show();
}
