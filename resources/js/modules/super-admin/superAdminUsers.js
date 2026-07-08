// SHARED
import '../admin/ui/toast';
import '../shared/ui/modalHelper';

// ADMIN
import initCreateAdminModal from './modal/createAdminModal';
import initDeleteAdminModal from './modal/deleteAdminModal';
import initEditAdminModal from './modal/editAdminModal';
import initToggleAdmin from './form/toggleAdmin';
import initEditAdminForm from './form/editAdmin';
import initDeleteAdminForm from './form/deleteAdmin';
import initResetAdminForm from './form/resetAdmin';
import initSessionToast from './toast/sessionToast';

document.addEventListener("DOMContentLoaded", () => {
    initCreateAdminModal();
    initDeleteAdminModal();
    initEditAdminModal();
    initToggleAdmin();
    initEditAdminForm();
    initDeleteAdminForm();
    initResetAdminForm();
    initSessionToast();
});