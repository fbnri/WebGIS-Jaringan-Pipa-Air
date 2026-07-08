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
        <span>Tunggu...</span>
    `;

    const name = document.getElementById("create_name").value.trim();
    const type = document.getElementById("create_type").value.trim();
    const planned = document.getElementById("planned_at").value;
    const installed = document.getElementById("installed_at").value;
    const length = document.getElementById("create_length").value.trim();

    if(!name){
        resetButton();

        showToast(
            "Nama pipa harus diisi",
            "error"
        );

        return;
    }

    if(!type){
        resetButton();

        showToast(
            "Jenis pipa harus diisi",
            "error"
        );

        return;
    }

    if(!planned){
        resetButton();

        showToast(
            "Tanggal rencana wajib diisi",
            "error"
        );

        return;
    }

    if(length === ""){
        resetButton();

        showToast(
            "Panjang pipa wajib diisi",
            "error"
        );

        return;
    }

    if(Number(length) < 0){
        resetButton();

        showToast(
            "Panjang pipa tidak boleh kurang dari 0",
            "error"
        );

        return;
    }

    if(installed && installed < planned){
        resetButton();

        showToast(
            "Tanggal terpasang tidak boleh sebelum tanggal rencana",
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
            length: Number(length),
            geometry: window.tempGeometry
        })
    })

    .then(async res => {
        const data = await res.json();

        if(!res.ok){
            let errorMessage = data.message || "Gagal tambah data";

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
            "Berhasil tambah data",
            "success"
        );

        setTimeout(() => {
            window.location.reload();
        }, 800);
    })

    .catch((err)=>{
        resetButton();

        showToast(
            err.message,
            "error"
        );
    });
};