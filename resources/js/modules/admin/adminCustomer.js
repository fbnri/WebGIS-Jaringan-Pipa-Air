import './ui/toast';
import '../shared/ui/modalHelper';

import initEditCustomerTable from './customer/editCustomerTable';
import initDeleteCustomerTable from './customer/deleteCustomerTable';
import initFilterPanel from '../shared/ui/filterPanel';

document.addEventListener("DOMContentLoaded",()=>{
    initFilterPanel();
    initEditCustomerTable();
    initDeleteCustomerTable();
});