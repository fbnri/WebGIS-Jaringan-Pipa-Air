const osm = L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution:'© OpenStreetMap'
    }
).addTo(map);

const satellite = L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    {
        attribution:'Tiles © Esri'
    }
);

window.osm = osm;
window.satellite = satellite;

const savedBasemap = localStorage.getItem("basemap");

if(savedBasemap){
    document.querySelectorAll(`input[name="basemap"]`)
        .forEach(radio => {
            radio.checked = (radio.value === savedBasemap);
        });

    map.removeLayer(osm);
    map.removeLayer(satellite);

    if(savedBasemap === "sat"){
        satellite.addTo(map);
        window.updateBoundaryStyle?.("sat");
    } else {
        osm.addTo(map);
        window.updateBoundaryStyle?.("osm");
    }
}

const basemapRadios = document.querySelectorAll('input[name="basemap"]');

basemapRadios.forEach(radio => {
    radio.addEventListener("change", function(){
        localStorage.setItem("basemap", this.value);

        map.removeLayer(osm);
        map.removeLayer(satellite);

        if(this.value === "osm"){
            osm.addTo(map);
            window.updateBoundaryStyle?.("osm");
        }

        if(this.value === "sat"){
            satellite.addTo(map);
            window.updateBoundaryStyle?.("sat");
        }
    });
});