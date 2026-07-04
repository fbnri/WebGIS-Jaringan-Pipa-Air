document.getElementById("saveCreate").onclick = ()=>{
    const saveBtn = document.getElementById("saveCreate");

    const resetButton = () => {
        saveBtn.disabled = false;

        saveBtn.classList.remove(
            "opacity-70",
            "cursor-not-allowed"
        );

        saveBtn.innerHTML = "Simpan";
    };

    if(saveBtn.disabled){
        return;
    }

    saveBtn.disabled = true;

    saveBtn.classList.add(
        "opacity-70",
        "cursor-not-allowed"
    );

    saveBtn.innerHTML = `
        <i class="fa-solid fa-spinner fa-spin"></i>
        <span>Menyimpan...</span>
    `;

    const name = document.getElementById("create_name").value.trim();
    const type = document.getElementById("create_type").value.trim();
    const planned = document.getElementById("planned_at").value;
    const installed = document.getElementById("installed_at").value;

    if(!name){
        resetButton();

        showToast(
            "Nama pipa harus diisi terlebih dahulu!",
            "error"
        );

        return;
    }

    if(!type){
        resetButton();

        showToast(
            "Jenis pipa harus diisi terlebih dahulu!",
            "error"
        );

        return;
    }

    if(!planned){
        resetButton();

        showToast(
            "Tanggal rencana wajib diisi!",
            "error"
        );

        return;
    }

    if(installed && installed < planned){
        resetButton();

        showToast(
            "Tanggal terpasang tidak boleh sebelum tanggal rencana!",
            "error"
        );

        return;
    }

    fetch("/admin/pipes",{
        method:"POST",

        headers:{
            "Content-Type":"application/json",

            "X-CSRF-TOKEN":
                document.querySelector(
                    'meta[name="csrf-token"]'
                ).getAttribute("content")
        },

        body:JSON.stringify({
            name: name,
            pipe_type: type,
            planned_at: planned,
            installed_at: installed || null,
            length:
                document.getElementById("create_length")
                .value,
            geometry: window.tempGeometry
        })
    })

    .then(res => {
        if (!res.ok)
            throw new Error("Gagal simpan data");

        return res.json();
    })

    .then(() => {
        showToast(
            "Berhasil tambah data!",
            "success"
        );

        setTimeout(() => {
            window.location.reload();
        }, 800);
    })

    .catch(() => {
        resetButton();

        showToast(
            "Gagal tambah data!",
            "error"
        );  
    });
};