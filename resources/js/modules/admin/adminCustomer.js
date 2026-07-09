// SHARED
import './ui/toast';
import '../shared/ui/modalHelper';

// CUSTOMER TABLE
import initEditCustomerTable from './customer/editCustomerTable';
import initDeleteCustomerTable from './customer/deleteCustomerTable';

document.addEventListener("DOMContentLoaded", () => {
    initEditCustomerTable();
    initDeleteCustomerTable();
});