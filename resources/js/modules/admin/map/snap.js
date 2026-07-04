const SNAP_TOLERANCE = 10;

let snapMarker = null;

// Mengambil seluruh endpoint (node) dari data pipa
export function getPipeNodes() {
    const nodes = [];

    if (!window.pipesData) {
        return nodes;
    }

    window.pipesData.forEach(pipe => {
        if (!pipe.geometry) return;

        const geometry = JSON.parse(pipe.geometry);

        if (
            geometry.type !== "LineString" ||
            geometry.coordinates.length < 2
        ) {
            return;
        }

        const first = geometry.coordinates[0];
        const last = geometry.coordinates[geometry.coordinates.length - 1];

        nodes.push(L.latLng(first[1], first[0]));
        nodes.push(L.latLng(last[1], last[0]));
    });

    return nodes;
}

// Snap ke node terdekat jika masih dalam radius toleransi
export function snapToNode(latlng) {
    const nodes = getPipeNodes();

    let nearest = null;
    let minDistance = Infinity;

    nodes.forEach(node => {
        const clickPoint = map.latLngToContainerPoint(latlng);
        const nodePoint = map.latLngToContainerPoint(node);

        const distance = clickPoint.distanceTo(nodePoint);

        if (distance < minDistance) {
            minDistance = distance;
            nearest = node;
        }
    });

    if (nearest && minDistance <= SNAP_TOLERANCE) {
        showSnapIndicator(nearest);

        return nearest;
    }

    hideSnapIndicator();

    return latlng;
}

export function showSnapIndicator(latlng) {
    if (!snapMarker) {
        snapMarker = L.circleMarker(latlng, {
            radius: 6,
            color: "#22c55e",
            fillColor: "#22c55e",
            fillOpacity: 1,
            weight: 2
        }).addTo(map);
    } else {
        snapMarker.setLatLng(latlng);
    }
}

export function hideSnapIndicator() {
    if (snapMarker) {
        map.removeLayer(snapMarker);

        snapMarker = null;
    }
}