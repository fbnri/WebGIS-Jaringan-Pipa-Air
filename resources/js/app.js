import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// LAYOUT
import './modules/layout/sidebar';

// GLOBAL HELPER
import './modules/shared/ui/modalHelper';
import './modules/admin/ui/toast';

// ADMIN
import './modules/admin/adminPipe';

// SUPER ADMIN
import './modules/super-admin/superAdminUsers';

// AUTH
import './modules/auth/login';
import './modules/auth/forcePassword';

Alpine.start();