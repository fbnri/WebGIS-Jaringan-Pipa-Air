import L from 'leaflet';

window.L = L;

const map = L.map('map', {
    zoomControl: false
}).setView([-6.914744,107.609810],13);

map.doubleClickZoom.disable();

L.control.zoom({
    position: 'bottomright'
}).addTo(map);

window.map = map;
