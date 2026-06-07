import initEditModal from './editModal';
import initDeleteModal from './deleteModal';
import initFilterPanel from './filterPanel';
import initKeyboardShortcut from './keyboardShortcut';

import {
    initEmptyTable
} from './tableHelper';

document.addEventListener("DOMContentLoaded", () => {
    initEditModal();
    initDeleteModal();
    initFilterPanel();
    initKeyboardShortcut();
    initEmptyTable();
});