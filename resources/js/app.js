import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

import './modules/layout/sidebar';
import './modules/pipe/index';

// GLOBAL TOAST
import './modules/ui/toast';

Alpine.start();