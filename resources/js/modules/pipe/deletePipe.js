const deleteModal =
    document.getElementById("deleteModal");

document.getElementById("deletePipe")
.onclick = ()=>{

    closeModalById("editModal");

    setTimeout(()=>{

        openModalById("deleteModal");

    },200);

};

document.getElementById("cancelDelete")
.onclick = ()=>{

    closeModalById("deleteModal");

};

deleteModal.addEventListener("click", (e)=>{

    if(e.target === deleteModal){

        closeModalById("deleteModal");

    }

});

document.getElementById("confirmDelete")
.onclick = () => {

    let id =
        document.getElementById("edit_id").value;

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

        showToast(
            "Gagal hapus data!",
            "error"
        );

    });

}