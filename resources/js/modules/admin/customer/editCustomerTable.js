export default function initEditCustomerTable(){
    const modal = document.getElementById("editCustomerModal");
    const modalContent = modal.querySelector(".modal-content");

    function openModal(){
        modal.classList.remove("hidden");
        modal.classList.add("flex");

        requestAnimationFrame(()=>{
            modal.classList.remove("opacity-0");

            modalContent.classList.remove(
                "opacity-0",
                "scale-95"
            );

            modalContent.classList.add(
                "opacity-100",
                "scale-100"
            );
        });
    }

    function closeModal(){
        modal.classList.add("opacity-0");

        modalContent.classList.remove(
            "opacity-100",
            "scale-100"
        );

        modalContent.classList.add(
            "opacity-0",
            "scale-95"
        );

        setTimeout(()=>{
            modal.classList.remove("flex");
            modal.classList.add("hidden");
        },200);
    }

    async function updateCustomer(){
        const id = document.getElementById("editCustomerId").value;
        const button = document.getElementById("saveEditCustomer");

        if(button.dataset.loading){
            return;
        }

        button.dataset.loading = "true";
        button.disabled = true;

        button.classList.add(
            "opacity-70",
            "cursor-not-allowed"
        );

        button.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin mr-1"></i>
            Tunggu...
        `;

        const editButton = document.querySelector(
            `.editCustomerBtn[data-id="${id}"]`
        );

        const body = {
            name: document.getElementById("editCustomerName").value.trim(),
            address: document.getElementById("editCustomerAddress").value,
            subscribed_at: document.getElementById("editCustomerSubscribedAt").value,
            latitude: editButton.dataset.latitude,
            longitude: editButton.dataset.longitude
        };

        const response = await fetch(
            `/admin/customers/${id}`,
            {
                method: "PUT",
                headers:{
                    "Content-Type":"application/json",
                    "Accept":"application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(body)
            }
        );

        const result = await response.json();

        if(!response.ok){
            button.disabled = false;
            button.dataset.loading = "";

            button.classList.remove(
                "opacity-70",
                "cursor-not-allowed"
            );

            button.innerHTML = "Simpan";

            showToast(
                result.message ??
                "Gagal memperbarui pelanggan",
                "error"
            );

            return;
        }

        showToast(
            "Pelanggan berhasil diperbarui",
            "success"
        );

        setTimeout(() => {
            location.reload();
        }, 1200);
    }

    document.querySelectorAll(".editCustomerBtn").forEach(button=>{
        button.addEventListener("click",()=>{
            document.getElementById("editCustomerId").value = button.dataset.id;
            document.getElementById("editCustomerName").value = button.dataset.name;
            document.getElementById("editCustomerAddress").value = button.dataset.address ?? "";
            document.getElementById("editCustomerSubscribedAt").value = button.dataset.subscribed;

            openModal();
        });
    });

    document.getElementById("closeEditCustomer").addEventListener("click",()=>{
        closeModal();
    });

    modal.addEventListener("click",(e)=>{
        if(e.target===modal){
            closeModal();
        }
    });

    document.getElementById("editCustomerForm").addEventListener("submit", async(e)=>{
        e.preventDefault();
        await updateCustomer();
    });
}