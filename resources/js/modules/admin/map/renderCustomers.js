const customerIcon = L.divIcon({
    html: `
        <i class="fa-solid fa-location-dot"
        style="
            color:#ef4444;
            font-size:22px;
            text-shadow:0 2px 4px rgba(0,0,0,.3);
        ">
        </i>
    `,
    className: '',
    iconSize: [22,22],
    iconAnchor: [11,22],
    popupAnchor: [0,-20]
});

window.customerLayers = [];

window.renderCustomers = function () {
    if (!window.customersData) return;

    customerLayers.forEach(layer => {
        map.removeLayer(layer);
    });

    customerLayers = [];

    customersData.forEach(customer => {
        const subscribedYear = customer.subscribed_at ? new Date(customer.subscribed_at).getFullYear() : null;

        if (
            subscribedYear &&
            subscribedYear > selectedYear
        ){
            return;
        }

        const marker = L.marker(
            [
                customer.latitude,
                customer.longitude
            ],
            {
                icon: customerIcon,
                zIndexOffset: 1000
            }
        ).addTo(map);

        marker.bindPopup(`
            <div class="min-w-[215px]">
                <div class="font-semibold text-red-600 text-sm mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-location-dot"></i>
                    ${customer.name}
                </div>
                <div class="text-xs text-gray-500 mb-2 leading-relaxed">
                    ${customer.address ?? '-'}
                </div>
                <div class="text-xs text-gray-500 mb-2">
                    Mengajukan Sambungan :
                    <span class="font-medium">
                        ${
                            customer.subscribed_at ? customer.subscribed_at : "-"
                        }
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div class="bg-gray-100 rounded-md p-2">
                        <div class="text-[10px] text-gray-500">
                            Latitude
                        </div>
                        <div class="text-[11px] font-medium break-all">
                            ${Number(customer.latitude).toFixed(7)}
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-md p-2">
                        <div class="text-[10px] text-gray-500">
                            Longitude
                        </div>
                        <div class="text-[11px] font-medium break-all">
                            ${Number(customer.longitude).toFixed(7)}
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-1">
                    <button
                        title="Edit Data"
                        class="editCustomer h-8 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-[11px] font-medium"
                        data-id="${customer.id}">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button
                        title="Edit Marker"
                        class="editCustomerLocation h-8 bg-amber-500 hover:bg-amber-600 text-white rounded-md text-[11px]"
                        data-id="${customer.id}">
                        <i class="fa-solid fa-location-crosshairs"></i>
                    </button>
                    <button
                        title="Hapus"
                        class="deleteCustomer h-8 bg-red-600 hover:bg-red-700 text-white rounded-md text-[11px]"
                        data-id="${customer.id}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        `);

        marker.on("popupopen", () => {
            const editBtn = document.querySelector(
                ".editCustomer[data-id='" + customer.id + "']"
            );

            if(editBtn){
                editBtn.onclick = () => {
                    window.openCustomerEdit(customer);
                };
            }

            const editLocationBtn = document.querySelector(
                ".editCustomerLocation[data-id='" + customer.id + "']"
            );

            if (editLocationBtn) {
                editLocationBtn.onclick = () => {
                    window.startCustomerLocationEdit(customer);
                };
            }

            const deleteBtn = document.querySelector(
                ".deleteCustomer[data-id='" + customer.id + "']"
            );

            if (deleteBtn) {
                deleteBtn.onclick = () => {
                    window.openDeleteCustomer(customer);
                };
            }
        });

        customerLayers.push(marker);
    });
};

renderCustomers();