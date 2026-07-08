export default function initResetAdminForm() {
    document.querySelectorAll(".resetAdminForm").forEach(form => {
        form.addEventListener("submit", () => {
            const button = form.querySelector(".resetAdminBtn");

            if (!button) {
                return;
            }

            if (button.dataset.loading) {
                return;
            }

            button.dataset.loading = "true";
            button.disabled = true;

            button.classList.remove(
                "hover:bg-blue-200"
            );

            button.classList.add(
                "opacity-70",
                "cursor-not-allowed"
            );
        });
    });
}