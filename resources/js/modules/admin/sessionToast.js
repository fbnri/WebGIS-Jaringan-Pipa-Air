export default function initSessionToast(){
    const pageData = document.getElementById(
        "adminPageData"
    );

    if(!pageData){
        return;
    }

    const successMessage = pageData.dataset.success;
    const errorMessage = pageData.dataset.error;

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