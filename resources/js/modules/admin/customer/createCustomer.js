let customerMarker = null;

const btnDesktop = document.getElementById("btnAddCustomer");
const btnMobile = document.getElementById("btnAddCustomerMobile");
const modal = document.getElementById("customerModal");
const modalContent = modal.querySelector(".modal-content");
const btnCancel = document.getElementById("cancelCustomer");
const createToolbar = document.getElementById("customerCreateToolbar");
const createInfo = document.getElementById("customerCreateInfo");
const createCancel = document.getElementById("customerCreateCancel");

let selectingLocation = false;

function hideUI(){
    document.querySelectorAll(".draw-hide").forEach(el=>{
        el.style.opacity="0";
        el.style.pointerEvents="none";
        el.style.transform="translateY(-10px)";
    });
}

function showUI(){
    document.querySelectorAll(".draw-hide").forEach(el=>{
        el.style.opacity="1";
        el.style.pointerEvents="auto";
        el.style.transform="translateY(0)";
    });
}

function openModal(){
    modal.classList.remove("hidden");
    modal.classList.add("flex");

    requestAnimationFrame(()=>{
        modal.classList.remove("opacity-0");
        modalContent.classList.remove("opacity-0","scale-95");
        modalContent.classList.add("opacity-100","scale-100");
    });
}

function closeModal(){
    modal.classList.add("opacity-0");
    modalContent.classList.remove("opacity-100","scale-100");
    modalContent.classList.add("opacity-0","scale-95");

    setTimeout(()=>{
        modal.classList.remove("flex");
        modal.classList.add("hidden");
        showUI();
    },200);
}

function startSelecting(){
    selectingLocation = true;

    hideUI();

    createToolbar.classList.remove("hidden");
    createInfo.classList.remove("hidden");

    map.closePopup();
    map.getContainer().style.cursor="crosshair";
}

btnDesktop?.addEventListener("click",startSelecting);
btnMobile?.addEventListener("click",startSelecting);

map.on("click",(e)=>{
    if(!selectingLocation) return;

    selectingLocation = false;

    createToolbar.classList.add("hidden");
    createInfo.classList.add("hidden");

    map.getContainer().style.cursor="";

    if(customerMarker){
        map.removeLayer(customerMarker);
    }

    customerMarker=L.marker(e.latlng,{
        draggable:true
    }).addTo(map);

    document.getElementById("customer_lat").value=e.latlng.lat.toFixed(7);
    document.getElementById("customer_lng").value=e.latlng.lng.toFixed(7);

    customerMarker.on("dragend",function(){
        const pos=this.getLatLng();

        document.getElementById("customer_lat").value=pos.lat.toFixed(7);
        document.getElementById("customer_lng").value=pos.lng.toFixed(7);
    });

    openModal();
});

btnCancel.addEventListener("click",()=>{
    closeModal();

    if(customerMarker){
        map.removeLayer(customerMarker);

        customerMarker=null;
    }
});

createCancel.addEventListener("click",()=>{
    selectingLocation = false;
    map.getContainer().style.cursor="";

    createToolbar.classList.add("hidden");
    createInfo.classList.add("hidden");

    showUI();
});

document.getElementById("saveCustomer").addEventListener("click",async()=>{
    const name = document.getElementById("customer_name").value.trim();

    if(name===""){
        showToast(
            "Nama pelanggan wajib diisi",
            "error"
        );

        return;
    }

    const body={
        name:name,
        address:document.getElementById("customer_address").value,
        latitude:document.getElementById("customer_lat").value,
        longitude:document.getElementById("customer_lng").value
    };

    const mode = document.getElementById("saveCustomer").dataset.mode;

    let response;

    if(mode==="edit"){
        const id=document.getElementById("customer_id").value;

        response=await fetch(`/admin/customers/${id}`,{
            method:"PUT",
            headers:{
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content
            },
            body:JSON.stringify(body)
        });
    }else{
        response=await fetch("/admin/customers",{
            method:"POST",
            headers:{
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content
            },
            body:JSON.stringify(body)
        });
    }

    const result=await response.json();

    if(!response.ok){
        showToast(
            result.message ?? "Terjadi kesalahan",
            "error"
        );

        return;
    }

    if(mode==="edit"){
        const id=document.getElementById("customer_id").value;
        const index=window.customersData.findIndex(c=>c.id==id);

        if(index!==-1){
            window.customersData[index]={
                ...window.customersData[index],
                ...body
            };
        }

        showToast("Pelanggan berhasil diperbarui");
    }else{
        window.customersData.push(result);

        showToast("Pelanggan berhasil ditambahkan");
    }

    renderCustomers();
    closeModal();

    document.getElementById("customer_name").value="";
    document.getElementById("customer_address").value="";
    document.getElementById("customer_lat").value="";
    document.getElementById("customer_lng").value="";
    document.getElementById("customer_id").value="";

    document.getElementById("customerModalTitle").innerText="Tambah Pelanggan";
    document.getElementById("saveCustomer").dataset.mode="create";

    if(customerMarker){
        map.removeLayer(customerMarker);

        customerMarker=null;
    }

    showUI();
});