const modal = document.getElementById("customerModal");
const modalContent = modal.querySelector(".modal-content");

function openModal() {
    modal.classList.remove("hidden");
    modal.classList.add("flex");

    requestAnimationFrame(() => {
        modal.classList.remove("opacity-0");
        modalContent.classList.remove("opacity-0", "scale-95");
        modalContent.classList.add("opacity-100", "scale-100");
    });
}

window.openCustomerEdit = function(customer){
    document.getElementById("customerModalTitle").innerText = "Edit Pelanggan";

    document.getElementById("customer_id").value = customer.id;
    document.getElementById("customer_name").value = customer.name;
    document.getElementById("customer_address").value = customer.address ?? "";
    document.getElementById("customer_subscribed_at").value = customer.subscribed_at ?? "";
    document.getElementById("customer_lat").value = customer.latitude;
    document.getElementById("customer_lng").value = customer.longitude;

    document.getElementById("saveCustomer").dataset.mode = "edit";

    openModal();
}