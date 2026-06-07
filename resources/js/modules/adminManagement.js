// UI
import './ui/toast';
import './ui/modal';

// ADMIN
import initCreateAdminModal from './admin/createAdminModal';
import initDeleteAdminModal from './admin/deleteAdminModal';
import initEditAdminModal from './admin/editAdminModal';
import initSessionToast from './admin/sessionToast';

document.addEventListener(
    "DOMContentLoaded",
    () => {
        initCreateAdminModal();
        initDeleteAdminModal();
        initEditAdminModal();
        initSessionToast();
    }
);