let activeToast = null;

window.showToast = function(message, type = "success") {
    if(activeToast){
        activeToast.remove();
        activeToast = null;
    }

    const toast = document.createElement("div");
    const isSuccess = type === "success";

    toast.className = `
        fixed top-5 right-5 z-[99999]
        flex items-center gap-3
        px-4 py-3 rounded-xl shadow-lg text-white text-sm
        transform translate-x-full opacity-0
        transition-all duration-300
        ${isSuccess ? "bg-green-600" : "bg-red-600"}
    `;

    toast.innerHTML = `
        <i class="fa-solid ${
            isSuccess
            ? "fa-circle-check"
            : "fa-circle-xmark"
        } text-lg"></i>

        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    activeToast = toast;

    setTimeout(() => {
        toast.classList.remove(
            "translate-x-full",
            "opacity-0"
        );
    }, 10);

    setTimeout(() => {
        toast.classList.add(
            "translate-x-full",
            "opacity-0"
        );

        setTimeout(() => {
            toast.remove();

            if(activeToast === toast){
                activeToast = null;
            }
        }, 300);
    }, 3000);
}