function initEditModal(){
    const editModal = document.getElementById("editModal");
    const cancelBtn = document.getElementById("cancelEdit");
    const saveBtn = document.getElementById("saveEdit");

    if(!editModal || !cancelBtn || !saveBtn){
        return;
    }

    // OPEN MODAL
    document.querySelectorAll('.btnEdit').forEach(btn => {
        btn.addEventListener('click', function(){
            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_name").value = this.dataset.name;
            document.getElementById("edit_type").value = this.dataset.type;
            document.getElementById("edit_planned_at").value = this.dataset.planned ?? '';
            document.getElementById("edit_installed_at").value = this.dataset.installed ?? '';
            document.getElementById("edit_length").value = this.dataset.length;

            const content = editModal.querySelector(".modal-content");

            editModal.classList.remove("hidden");

            setTimeout(() => {
                editModal.classList.add(
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
    cancelBtn.onclick = () => {
        saveBtn.disabled = false;

        saveBtn.classList.remove(
            "opacity-70",
            "cursor-not-allowed"
        );

        saveBtn.innerHTML = "Simpan";

        const content = editModal.querySelector(".modal-content");

        content.classList.remove(
            "scale-100",
            "opacity-100"
        );

        content.classList.add(
            "scale-95",
            "opacity-0"
        );

        editModal.classList.remove("opacity-100");

        setTimeout(() => {
            editModal.classList.add("hidden");
            editModal.classList.remove("flex");
        }, 200);
    };

    // SAVE EDIT
    saveBtn.onclick = async () => {
        // Cegah double click
        if (saveBtn.disabled) {
            return;
        }

        saveBtn.disabled = true;

        saveBtn.classList.add(
            "opacity-70",
            "cursor-not-allowed"
        );

        const originalText = saveBtn.innerHTML;

        saveBtn.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin"></i>
            <span>Simpan</span>
        `;

        let id = document.getElementById("edit_id").value;

        try {
            const res = await fetch(`/admin/pipes/${id}`, {
                method: "PUT",

                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },

                body: JSON.stringify({
                    name: document.getElementById("edit_name").value,
                    pipe_type: document.getElementById("edit_type").value,
                    planned_at: document.getElementById("edit_planned_at").value,
                    installed_at: document.getElementById("edit_installed_at").value,
                    length:document.getElementById("edit_length").value
                })
            });

            const data = await res.json();

            if(!res.ok){
                let errorMessage = data.message || "Gagal update data!";

                if(data.errors){
                    const firstError = Object.values(data.errors)[0];

                    if(firstError){
                        errorMessage = firstError[0];
                    }
                }

                throw new Error(errorMessage);
            }

            showToast(
                "Berhasil perbarui data",
                "success"
            );

            setTimeout(() => {
                location.reload();
            }, 1000);
        } catch(err){
            showToast(
                err.message,
                "error"
            );

            saveBtn.disabled = false;

            saveBtn.classList.remove(
                "opacity-70",
                "cursor-not-allowed"
            );

            saveBtn.innerHTML = originalText;
        }
    };
}

export default initEditModal;