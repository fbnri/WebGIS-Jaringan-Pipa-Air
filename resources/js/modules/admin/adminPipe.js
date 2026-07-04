import './ui/toast';

import initEditModal from './pipe/editModal';
import initDeleteModal from './pipe/deleteModal';
import initFilterPanel from '../shared/ui/filterPanel';
import initKeyboardShortcut from './pipe/keyboardShortcut';
import { initEmptyTable } from './pipe/tableHelper';

document.addEventListener("DOMContentLoaded", () => {
    initEditModal();
    initDeleteModal();
    initFilterPanel();
    initKeyboardShortcut();
    initEmptyTable();
});