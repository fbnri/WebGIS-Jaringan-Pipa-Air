import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import '../../../css/user/map.css';

window.L = L;

// UI
import '../shared/ui/layerToggle';
import './ui/userYearNavigator';
import './ui/userMobileMenu';

// MAP
import '../shared/map/initMap';
import '../shared/map/basemap';
import './map/renderUserPipes';
import './map/renderCustomers';
import loadBandungBoundary from '../shared/map/bandungBoundary';

loadBandungBoundary();

document.addEventListener("DOMContentLoaded", () => {
    const toggleBoundary = document.getElementById("toggleBoundary");

    if(!toggleBoundary){
        return;
    }

    const visible = localStorage.getItem("boundaryVisible") !== "false";
    toggleBoundary.checked = visible;

    toggleBoundary.addEventListener("change", function(){
        localStorage.setItem(
            "boundaryVisible",
            this.checked
        );

        if(!window.bandungBoundary){
            return;
        }

        if(this.checked){
            if(!window.map.hasLayer(window.bandungBoundary)){
                window.bandungBoundary.addTo(window.map);
                window.bandungBoundary.bringToBack();
            }
        }else{
            if(window.map.hasLayer(window.bandungBoundary)){
                window.map.removeLayer(window.bandungBoundary);
            }
        }
    });
});