export default function initToggleAdmin() {
    document.querySelectorAll(".toggleAdminForm").forEach(form => {
        form.addEventListener("submit", () => {
            const button = form.querySelector(".toggleAdminBtn");

            if (!button) return;

            button.disabled = true;

            button.classList.add(
                "opacity-50",
                "cursor-not-allowed"
            );
        });
    });
}