import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L;

// UI
import './ui/toast';
import './ui/modal';
import './ui/yearNavigator';
import './ui/layerToggle';

// MAP
import './map/initMap';
import './map/basemap';
import './map/renderPipes';
import './map/drawPipe';
import loadBandungBoundary from './map/bandungBoundary';

loadBandungBoundary();

// PIPE
import './pipe/createPipe';
import './pipe/updatePipe';
import './pipe/deletePipe';