export default function initEditAdminModal() {
    const editAdminModal = document.getElementById("editAdminModal");
    const editAdminForm = document.getElementById("editAdminForm");
    const editAdminName = document.getElementById("editAdminName");
    const editAdminEmail = document.getElementById("editAdminEmail");
    const closeEditAdmin = document.getElementById("closeEditAdmin");

    if(
        !editAdminModal ||
        !editAdminForm ||
        !editAdminName ||
        !editAdminEmail ||
        !closeEditAdmin
    ){
        return;
    }

    document.querySelectorAll(".editAdminBtn").forEach(button => {
        button.addEventListener(
            "click",
            () => {
            editAdminForm.action = `/super-admin/users/${button.dataset.id}`;

            editAdminName.value = button.dataset.name;
            editAdminEmail.value = button.dataset.email;

            openModalById("editAdminModal");
        });
    });

    closeEditAdmin.addEventListener("click", () => {
        closeModalById("editAdminModal");
    });
}