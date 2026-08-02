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
    iconAnchor: [11,22]
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

        // Filter timeline
        if (
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
                zIndexOffset: 1000,
                interactive: false
            }
        ).addTo(map);

        window.hasCustomerMarker = true;
        window.customerLayers.push(marker);
    });
};

renderCustomers();