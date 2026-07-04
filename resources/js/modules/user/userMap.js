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
