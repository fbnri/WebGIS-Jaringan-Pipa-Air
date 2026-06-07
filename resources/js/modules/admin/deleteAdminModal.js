export default function initDeleteAdminModal() {
    const deleteAdminModal = document.getElementById("deleteAdminModal");
    const deleteAdminForm = document.getElementById("deleteAdminForm");
    const cancelDeleteAdmin = document.getElementById("cancelDeleteAdmin");

    if(
        !deleteAdminModal ||
        !deleteAdminForm ||
        !cancelDeleteAdmin
    ){
        return;
    }

    document.querySelectorAll(".deleteAdminBtn").forEach(button => {
        button.addEventListener("click", () => {
            deleteAdminForm.action = button.dataset.action;

            openModalById("deleteAdminModal");
        });
    });

    cancelDeleteAdmin.addEventListener("click", () => {
        closeModalById("deleteAdminModal");
    });
}