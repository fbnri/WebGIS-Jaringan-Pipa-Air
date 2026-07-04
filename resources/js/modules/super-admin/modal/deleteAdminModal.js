export default function initDeleteAdminModal() {
    const deleteAdminModal = document.getElementById("deleteAdminModal");
    const deleteAdminForm = document.getElementById("deleteAdminForm");
    const cancelDeleteAdmin = document.getElementById("cancelDeleteAdmin");

    if (
        !deleteAdminModal ||
        !deleteAdminForm ||
        !cancelDeleteAdmin
    ) {
        return;
    }

    // OPEN MODAL
    document.querySelectorAll(".deleteAdminBtn").forEach(button => {
        button.addEventListener("click", () => {
            deleteAdminForm.action = button.dataset.action;

            const content = deleteAdminModal.querySelector(".modal-content");

            deleteAdminModal.classList.remove("hidden");

            setTimeout(() => {
                deleteAdminModal.classList.add(
                    "flex",
                    "opacity-100"
                );
                content.classList.remove(
                    "scale-95",
                    "opacity-0"
                );
                content.classList.add(
                    "scale-100",
                    "opacity-100"
                );
            }, 10);
        });
    });

    // CLOSE MODAL
    cancelDeleteAdmin.onclick = () => {
        const content = deleteAdminModal.querySelector(".modal-content");

        content.classList.remove(
            "scale-100",
            "opacity-100"
        );
        content.classList.add(
            "scale-95",
            "opacity-0"
        );

        deleteAdminModal.classList.remove("opacity-100");

        setTimeout(() => {
            deleteAdminModal.classList.add("hidden");
            deleteAdminModal.classList.remove("flex");
        }, 200);
    };
}