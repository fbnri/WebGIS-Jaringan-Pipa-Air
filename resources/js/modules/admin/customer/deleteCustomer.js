const modal = document.getElementById("customerDeleteModal");
const cancelBtn = document.getElementById("cancelDeleteCustomer");
const confirmBtn = document.getElementById("confirmDeleteCustomer");

let selectedCustomer = null;

window.openDeleteCustomer = function(customer){
    selectedCustomer = customer;

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    requestAnimationFrame(() => {
        modal.classList.remove("opacity-0");

        modal.querySelector(".modal-content").classList.remove(
            "opacity-0",
            "scale-95"
        );

        modal.querySelector(".modal-content").classList.add(
            "opacity-100",
            "scale-100"
        );
    });
}

function closeModal(){
    modal.classList.add("opacity-0");

    modal.querySelector(".modal-content").classList.remove(
        "opacity-100",
        "scale-100"
    );

    modal.querySelector(".modal-content").classList.add(
        "opacity-0",
        "scale-95"
    );

    setTimeout(() => {
        modal.classList.remove("flex");
        modal.classList.add("hidden");
    },200);
}

cancelBtn.onclick = () => {
    closeModal();

    selectedCustomer = null;
}

confirmBtn.onclick = async () => {
    if(!selectedCustomer) return;

    const response = await fetch(
        `/admin/customers/${selectedCustomer.id}`,
        {
            method:"DELETE",
            headers:{
                "X-CSRF-TOKEN":document
                    .querySelector('meta[name="csrf-token"]')
                    .content,
                "Accept":"application/json"
            }
        }
    );

    const result = await response.json();

    if(!response.ok){
        showToast(
            result.message ?? "Gagal menghapus pelanggan",
            "error"
        );

        return;
    }

    window.customersData = window.customersData.filter(c =>
        c.id != selectedCustomer.id
    );

    renderCustomers();

    closeModal();

    selectedCustomer = null;

    showToast(
        "Pelanggan berhasil dihapus",
        "success"
    );
}