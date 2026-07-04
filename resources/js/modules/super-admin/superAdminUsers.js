// SHARED
import '../admin/ui/toast';
import '../shared/ui/modalHelper';

// ADMIN
import initCreateAdminModal from './modal/createAdminModal';
import initDeleteAdminModal from './modal/deleteAdminModal';
import initEditAdminModal from './modal/editAdminModal';
import initSessionToast from './toast/sessionToast';

document.addEventListener("DOMContentLoaded", () => {
    initCreateAdminModal();
    initDeleteAdminModal();
    initEditAdminModal();
    initSessionToast();
});