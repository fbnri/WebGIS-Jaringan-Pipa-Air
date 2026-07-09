let editing = false;

let editMarker = null;
let currentCustomer = null;
let originalPosition = null;

const toolbar = document.getElementById("customerLocationToolbar");
const info = document.getElementById("customerLocationInfo");
const finish = document.getElementById("customerLocationFinish");
const cancel = document.getElementById("customerLocationCancel");

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

window.startCustomerLocationEdit = function(customer){
    if(editing) return;

    editing = true;

    currentCustomer = customer;

    originalPosition = [
        Number(customer.latitude),
        Number(customer.longitude)
    ];

    hideUI();

    toolbar.classList.remove("hidden");
    info.classList.remove("hidden");

    map.closePopup();

    editMarker = window.customerLayers.find(layer=>{
        const pos = layer.getLatLng();

        return (
            pos.lat == customer.latitude &&
            pos.lng == customer.longitude
        );
    });

    if(!editMarker){
        editing = false;

        toolbar.classList.add("hidden");
        info.classList.add("hidden");

        showUI();

        showToast("Marker tidak ditemukan","error");

        return;
    }

    editMarker.dragging.enable();
    editMarker.openPopup();
};

finish.onclick = async ()=>{
    if(!editing) return;

    const pos = editMarker.getLatLng();

    try{
        const response = await fetch(
            `/admin/customers/${currentCustomer.id}`,
            {
                method:"PUT",
                headers:{
                    "Content-Type":"application/json",
                    "Accept":"application/json",
                    "X-CSRF-TOKEN":document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                },
                body:JSON.stringify({
                    name:currentCustomer.name,
                    address:currentCustomer.address,
                    latitude:pos.lat,
                    longitude:pos.lng,
                    subscribed_at: currentCustomer.subscribed_at
                })
            }
        );

        const result = await response.json();

        if(!response.ok){
            throw new Error(
                result.message ??
                "Gagal memperbarui lokasi"
            );
        }

        currentCustomer.latitude = pos.lat;
        currentCustomer.longitude = pos.lng;

        editMarker.dragging.disable();

        toolbar.classList.add("hidden");
        info.classList.add("hidden");

        showUI();

        editing = false;

        renderCustomers();

        showToast(
            "Lokasi pelanggan berhasil diperbarui",
            "success"
        );
    }catch(err){
        showToast(
            err.message,
            "error"
        );
    }
};

cancel.onclick = ()=>{
    if(!editing) return;

    editMarker.setLatLng(originalPosition);

    currentCustomer.latitude = originalPosition[0];
    currentCustomer.longitude = originalPosition[1];

    editMarker.dragging.disable();

    toolbar.classList.add("hidden");
    info.classList.add("hidden");

    showUI();

    editing = false;

    renderCustomers();
};

document.addEventListener("keydown",e=>{
    if(!editing) return;

    if(e.key==="Escape"){
        cancel.click();
    }

    if(e.key==="Enter"){
        finish.click();
    }
});