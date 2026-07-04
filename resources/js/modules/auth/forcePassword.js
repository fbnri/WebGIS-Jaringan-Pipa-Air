document.addEventListener("DOMContentLoaded", () => {
    const pageData = document.getElementById("forcePasswordData");

    if (!pageData) return;

    const password = document.getElementById("password");

    // TOGGLE PASSWORD
    const togglePassword = document.getElementById("togglePassword");
    const eyeIcon = document.getElementById("eyeIcon");

    togglePassword.addEventListener("click", () => {
        if(password.type === "password"){
            password.type = "text";

            eyeIcon.classList.replace(
                "fa-eye",
                "fa-eye-slash"
            );
        }else{
            password.type = "password";

            eyeIcon.classList.replace(
                "fa-eye-slash",
                "fa-eye"
            );
        }
    });

    // TOGGLE CONFIRM PASSWORD
    const confirmPassword = document.getElementById("password_confirmation");
    const toggleConfirm = document.getElementById("toggleConfirmPassword");
    const eyeConfirm = document.getElementById("eyeIconConfirm");

    toggleConfirm.addEventListener("click", () => {
        if(confirmPassword.type === "password"){
            confirmPassword.type = "text";

            eyeConfirm.classList.replace(
                "fa-eye",
                "fa-eye-slash"
            );
        }else{
            confirmPassword.type = "password";

            eyeConfirm.classList.replace(
                "fa-eye-slash",
                "fa-eye"
            );
        }
    });

    // TOAST VALIDATION
    if(
        pageData &&
        pageData.dataset.error
    ){
        showToast(
            pageData.dataset.error,
            "error"
        );
    }
});