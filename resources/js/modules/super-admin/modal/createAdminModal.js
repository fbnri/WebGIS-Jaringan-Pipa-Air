function initCreateAdminModal() {
    const createAdminModal = document.getElementById("createAdminModal");
    const openCreateAdmin = document.getElementById("openCreateAdmin");
    const closeCreateAdmin = document.getElementById("closeCreateAdmin");

    if (
        !createAdminModal ||
        !openCreateAdmin ||
        !closeCreateAdmin
    ) {
        return;
    }

    openCreateAdmin.addEventListener("click", () => {
        openModalById("createAdminModal");
    });

    closeCreateAdmin.addEventListener("click", () => {
        closeModalById("createAdminModal");
    });
}

export default initCreateAdminModal;