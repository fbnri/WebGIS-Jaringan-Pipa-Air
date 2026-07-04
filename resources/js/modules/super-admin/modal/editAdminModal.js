export default function initEditAdminModal() {
    const editAdminModal = document.getElementById("editAdminModal");
    const editAdminForm = document.getElementById("editAdminForm");
    const editAdminName = document.getElementById("editAdminName");
    const editAdminEmail = document.getElementById("editAdminEmail");
    const closeEditAdmin = document.getElementById("closeEditAdmin");

    if (
        !editAdminModal ||
        !editAdminForm ||
        !editAdminName ||
        !editAdminEmail ||
        !closeEditAdmin
    ) {
        return;
    }

    // OPEN MODAL
    document.querySelectorAll(".editAdminBtn").forEach(button => {
        button.addEventListener("click", () => {
            editAdminForm.action = `/super-admin/users/${button.dataset.id}`;

            editAdminName.value = button.dataset.name;
            editAdminEmail.value = button.dataset.email;

            const content = editAdminModal.querySelector(".modal-content");

            editAdminModal.classList.remove("hidden");

            setTimeout(() => {
                editAdminModal.classList.add(
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
    closeEditAdmin.onclick = () => {
        const content = editAdminModal.querySelector(".modal-content");

        content.classList.remove(
            "scale-100",
            "opacity-100"
        );
        content.classList.add(
            "scale-95",
            "opacity-0"
        );

        editAdminModal.classList.remove("opacity-100");

        setTimeout(() => {
            editAdminModal.classList.add("hidden");
            editAdminModal.classList.remove("flex");
        }, 200);
    };
}