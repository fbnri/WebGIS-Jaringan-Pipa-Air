export default function loadBandungBoundary() {
    fetch('/geojson/bandung.json')
        .then(response => response.json())
        .then(data => {
            const boundaryLayer = L.geoJSON(data, {
                style: {
                    color: '#64748b',
                    weight: 1.5,
                    dashArray: '6,4',
                    fillOpacity: 0
                }
            });

            boundaryLayer.addTo(window.map);
            boundaryLayer.bringToBack();

            window.bandungBoundary = boundaryLayer;

            window.updateBoundaryStyle = function(mode){
                if(!window.bandungBoundary){
                    return;
                }

                if(mode === "sat"){
                    window.bandungBoundary.setStyle({
                        color: '#ccc',
                        weight: 1.5,
                        dashArray: '6,4',
                        fillOpacity: 0
                    });
                } else {
                    window.bandungBoundary.setStyle({
                        color: '#64748b',
                        weight: 1.5,
                        dashArray: '6,4',
                        fillOpacity: 0
                    });
                }
            };

            const savedBasemap = localStorage.getItem("basemap");

            window.updateBoundaryStyle(savedBasemap === "sat" ? "sat" : "osm");

            window.map.fitBounds(
                boundaryLayer.getBounds()
            );
        })

        .catch(error => {
            console.error(
                'Gagal load boundary Bandung:',
                error
            );
        });
}