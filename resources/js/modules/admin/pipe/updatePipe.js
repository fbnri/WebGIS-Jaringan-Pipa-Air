document.getElementById("saveEdit").onclick = ()=>{
    const saveBtn = document.getElementById("saveEdit");

    saveBtn.classList.add(
        "opacity-70",
        "cursor-not-allowed"
    );

    if(saveBtn.disabled) return;

    saveBtn.disabled = true;

    saveBtn.innerHTML = `
        <i class="fa-solid fa-spinner fa-spin"></i>
        <span>Menyimpan...</span>
    `;

    let id = document.getElementById("edit_id").value;
    const length = document.getElementById("edit_length").value.trim();

    if(!length){
        saveBtn.disabled = false;

        saveBtn.classList.remove(
            "opacity-70",
            "cursor-not-allowed"
        );

        saveBtn.innerHTML = "Simpan";

        showToast(
            "Panjang pipa wajib diisi",
            "error"
        );

        return;
    }

    fetch(`/admin/pipes/${id}`,{
        method:"PUT",

        headers:{
            "Content-Type":"application/json",
            "Accept":"application/json",

            "X-CSRF-TOKEN":
            document.querySelector(
                'meta[name="csrf-token"]'
            ).getAttribute("content")
        },

        body:JSON.stringify({
            name: document.getElementById("edit_name").value,
            pipe_type: document.getElementById("edit_type").value,
            planned_at: document.getElementById("edit_planned_at").value,
            installed_at: document.getElementById("edit_installed_at").value,
            length: length
        })
    })

    .then(async res => {
        const data = await res.json();

        if(!res.ok){
            let errorMessage = data.message || "Gagal update data";

            if(data.errors){
                const firstError = Object.values(data.errors)[0];

                if(firstError){
                    errorMessage = firstError[0];
                }
            }
            throw new Error(errorMessage);
        }
        return data;
    })

    .then(() => {
        showToast(
            "Berhasil update data",
            "success"
        );

        setTimeout(() => {
            window.location.reload();
        }, 800);
    })

    .catch((err) => {
        saveBtn.disabled = false;

        saveBtn.classList.remove(
            "opacity-70",
            "cursor-not-allowed"
        );

        saveBtn.innerHTML = "Simpan";

        showToast(
            err.message,
            "error"
        );
    });

    document.getElementById("cancelEdit").onclick = ()=>{
        saveBtn.disabled=false;

        saveBtn.classList.remove(
            "opacity-70",
            "cursor-not-allowed"
        );

        saveBtn.innerHTML="Simpan";

        closeModalById("editModal");
    };
}

document.addEventListener("keydown",(e)=>{
    if(e.key !== "Enter") return;

    const editModal = document.getElementById("editModal");

    if(
        editModal &&
        !editModal.classList.contains("hidden")
    ){
        e.preventDefault();

        document.getElementById("saveEdit").click();
    }
});

document.addEventListener("keydown",(e)=>{
    if(e.key !== "Escape") return;

    const editModal = document.getElementById("editModal");

    if(
        editModal &&
        !editModal.classList.contains("hidden")
    ){
        e.preventDefault();

        closeModalById("editModal");
    }
});