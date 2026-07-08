import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import '../../../css/admin/dashboard.css';

window.L = L;

// UI
import './ui/toast';
import './ui/yearNavigator';
import '../shared/ui/modalHelper';
import '../shared/ui/layerToggle';

// MAP
import '../shared/map/initMap';
import '../shared/map/basemap';
import './map/renderPipes';
import './map/renderCustomers';
import './map/snap';
import './map/drawPipe';
import loadBandungBoundary from '../shared/map/bandungBoundary';

loadBandungBoundary();

// PIPE ACTIONS
import './pipe/createPipe';
import './pipe/updatePipe';
import './pipe/deletePipe';

// CUSTOMER
import './customer/createCustomer';
import './customer/editCustomerLocation';
import './customer/editCustomer';
import './customer/deleteCustomer';