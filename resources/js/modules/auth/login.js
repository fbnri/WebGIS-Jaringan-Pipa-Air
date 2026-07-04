document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");

    if (!loginForm) return;

    // TOAST ERROR
    const pageData = document.getElementById("loginPageData");

    if (
        pageData &&
        pageData.dataset.error
    ) {
        showToast(
            pageData.dataset.error,
            "error"
        );
    }

    // TOGGLE PASSWORD
    const password = document.getElementById("password");
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

    // PREVENT DOUBLE SUBMIT
    let submitted = false;

    loginForm.addEventListener("submit", function(e){
        if(submitted){
            e.preventDefault();

            return;
        }

        submitted = true;

        const btn = document.getElementById("loginBtn");

        btn.disabled = true;

        btn.classList.remove(
            "bg-blue-600",
            "hover:bg-blue-700"
        );

        btn.classList.add(
            "bg-gray-400",
            "cursor-not-allowed"
        );

        btn.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin"></i>
            <span>Memproses...</span>
        `;
    });
});