import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L;

// UI
import './ui/layerToggle';
import './ui/userYearNavigator';
import './ui/userMobileMenu';

// MAP
import './map/initMap';
import './map/basemap';
import './map/renderUserPipes';
import loadBandungBoundary from './map/bandungBoundary';

loadBandungBoundary();

// PIPE
import './pipe/filterPanel';