export default function initDeleteCustomerTable(){
    const modal = document.getElementById("deleteCustomerModal");

    if(!modal) return;

    const modalContent = modal.querySelector(".modal-content");
    const buttons = document.querySelectorAll(".deleteCustomerBtn");

    let selectedId = null;

    function openModal(){
        modal.classList.remove("hidden");
        modal.classList.add("flex");

        requestAnimationFrame(()=>{
            modal.classList.remove(
                "opacity-0"
            );

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
        modal.classList.add(
            "opacity-0"
        );

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

    buttons.forEach(btn=>{
        btn.addEventListener("click",()=>{
            selectedId = btn.dataset.id;

            openModal();
        });
    });

    document
    .getElementById("cancelDeleteCustomer")
    .addEventListener("click",()=>{
        closeModal();

        selectedId = null;
    });

    modal.addEventListener("click",(e)=>{
        if(e.target === modal){
            closeModal();

            selectedId = null;
        }
    });

    document
    .getElementById("deleteCustomerForm")
    .addEventListener("submit",async e=>{
        e.preventDefault();

        if(!selectedId) return;

        const response = await fetch(
            `/admin/customers/${selectedId}`,
            {
                method:"DELETE",
                headers:{
                    "X-CSRF-TOKEN":
                    document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    .content,
                    "Accept":"application/json"
                }
            }
        );

        if(!response.ok){
            showToast(
                "Gagal menghapus pelanggan",
                "error"
            );

            return;
        }

        showToast(
            "Pelanggan berhasil dihapus",
            "success"
        );

        closeModal();

        setTimeout(()=>{
            location.reload();
        },1000);
    });
}