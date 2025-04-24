document.addEventListener('DOMContentLoaded', () => {
    const signUp = document.getElementById("SignUp");

    if (signUp) {
        signUpModal = new bootstrap.Modal(signUp);
    }
});

function loadSignUpModal() {
    if (signUpModal) signUpModal.show();
}

