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
window.hasCustomerMarker = false;

window.renderCustomers = function () {
    if (!window.customersData) return;

    window.customerLayers.forEach(layer => {
        map.removeLayer(layer);
    });

    window.customerLayers = [];
    window.hasCustomerMarker = false;

    customersData.forEach(customer => {
        const subscribedYear = customer.subscribed_at
        ? new Date(customer.subscribed_at).getFullYear()
        : null;

        // FILTER TAHUN
        if(
            subscribedYear &&
            subscribedYear > window.currentYear
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
                zIndexOffset:1000
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
                    Mulai Berlangganan :
                    <span class="font-medium">
                        ${
                            customer.subscribed_at
                            ? new Date(customer.subscribed_at).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            })
                            : '-'
                        }
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2">
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
            </div>
        `);

        window.hasCustomerMarker = true;

        window.customerLayers.push(marker);
    });
};

renderCustomers();