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
            <div class="min-w-[200px]">
                <div class="font-bold text-red-600 mb-2">
                    <i class="fa-solid fa-location-dot"></i>
                    ${customer.name}
                </div>

                <div class="text-sm text-gray-600">
                    ${customer.address ?? '-'}
                </div>
            </div>
        `);

        customerLayers.push(marker);
    });
};

renderCustomers();