export default function initAdminToast(){
    const successMessage = document.body.dataset.success;
    const errorMessage = document.body.dataset.error;

    if(successMessage){
        showToast(
            successMessage,
            "success"
        );
    }

    if(errorMessage){
        showToast(
            errorMessage,
            "error"
        );
    }
}