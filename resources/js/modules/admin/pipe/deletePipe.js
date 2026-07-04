const deleteModal = document.getElementById("deleteModal");
const confirmDeleteBtn = document.getElementById("confirmDelete");

document.getElementById("deletePipe").onclick = ()=>{
    closeModalById("editModal");

    setTimeout(()=>{
        openModalById("deleteModal");
    },200);
};

document.getElementById("cancelDelete").onclick = ()=>{
    confirmDeleteBtn.disabled = false;

    confirmDeleteBtn.classList.remove(
        "opacity-70",
        "cursor-not-allowed"
    );

    confirmDeleteBtn.innerHTML = "Hapus";

    closeModalById("deleteModal");
};

deleteModal.addEventListener("click", (e)=>{
    if(e.target === deleteModal){
        closeModalById("deleteModal");
    }
});

confirmDeleteBtn.onclick = () => {
    let id = document.getElementById("edit_id").value;

    if(confirmDeleteBtn.disabled){
        return;
    }

    confirmDeleteBtn.disabled = true;

    confirmDeleteBtn.classList.add(
        "opacity-70",
        "cursor-not-allowed"
    );

    confirmDeleteBtn.innerHTML = `
        <i class="fa-solid fa-spinner fa-spin"></i>
        <span>Menghapus...</span>
    `;

    console.log("DELETE ID =", id);

    fetch(`/admin/pipes/${id}`, {
        method: "DELETE",

        headers: {
            "X-CSRF-TOKEN":
                document.querySelector(
                    'meta[name="csrf-token"]'
                ).getAttribute("content")
        }
    })

    .then(res => {
        if (!res.ok)
            throw new Error();

        return res.json();
    })

    .then(() => {
        showToast(
            "Berhasil hapus data!",
            "success"
        );

        setTimeout(() => {
            window.location.reload();
        }, 800);
    })

    .catch(() => {
        confirmDeleteBtn.disabled = false;

        confirmDeleteBtn.classList.remove(
            "opacity-70",
            "cursor-not-allowed"
        );

        confirmDeleteBtn.innerHTML = "Hapus";

        showToast(
            "Gagal hapus data!",
            "error"
        );
    });
}