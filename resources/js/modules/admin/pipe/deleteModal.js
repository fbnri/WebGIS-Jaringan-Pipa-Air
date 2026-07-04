import { reNumberTable } from './tableHelper';

function initDeleteModal(){
    const deleteModal = document.getElementById("deleteModal");
    const cancelBtn = document.getElementById("cancelDelete");
    const confirmBtn = document.getElementById("confirmDelete");

    if(
        !deleteModal || 
        !cancelBtn || 
        !confirmBtn || 
        !document.querySelector('.btnDelete')
    ){
        return;
    }

    let deleteId = null;
    let isDeleting = false;

    // OPEN
    document.querySelectorAll('.btnDelete').forEach(btn => {
        btn.addEventListener('click', function(){
            deleteId = this.dataset.id;

            const content = deleteModal.querySelector(".modal-content");

            deleteModal.classList.remove("hidden");

            setTimeout(() => {
                deleteModal.classList.add(
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

    // CLOSE
    cancelBtn.onclick = () => {
        if (isDeleting) return;

        confirmBtn.disabled = false;

        confirmBtn.classList.remove(
            "opacity-70",
            "cursor-not-allowed"
        );

        confirmBtn.innerHTML = "Hapus";

        const content = deleteModal.querySelector(".modal-content");

        content.classList.remove(
            "scale-100",
            "opacity-100"
        );

        content.classList.add(
            "scale-95",
            "opacity-0"
        );

        deleteModal.classList.remove("opacity-100");

        setTimeout(() => {
            deleteModal.classList.add("hidden");
            deleteModal.classList.remove("flex");
        }, 200);
    };

    // CONFIRM DELETE
    confirmBtn.onclick = async (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();

        if (isDeleting) {
            return;
        }

        confirmBtn.onclick = null;

        isDeleting = true;
        confirmBtn.disabled = true;

        confirmBtn.classList.add(
            "opacity-70",
            "cursor-not-allowed"
        );

        const originalText = confirmBtn.innerHTML;

        confirmBtn.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin"></i>
            <span>Menghapus...</span>
        `;

        fetch(`/admin/pipes/${deleteId}`, {
            method: "DELETE",

            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
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

            const row = document
                .querySelector(`button[data-id="${deleteId}"]`)
                .closest("tr");

            row.remove();
            reNumberTable();

            isDeleting = false;

            cancelBtn.click();
        })

        .catch(() => {
            isDeleting = false;
            confirmBtn.disabled = false;

            confirmBtn.classList.remove(
                "opacity-70",
                "cursor-not-allowed"
            );

            confirmBtn.innerHTML = originalText;

            showToast(
                "Gagal hapus data!",
                "error"
            );
        });
    };
}

export default initDeleteModal;