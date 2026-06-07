function initKeyboardShortcut(){
    // ENTER = SAVE
    document.addEventListener("keydown",(e)=>{
        if(e.key !== "Enter") return;

        const editModal = document.getElementById("editModal");
        const deleteModal = document.getElementById("deleteModal");

        if(
            deleteModal &&
            !deleteModal.classList.contains("hidden")
        ){
            return;
        }

        if(
            editModal &&
            !editModal.classList.contains("hidden")
        ){
            e.preventDefault();

            document
                .getElementById("saveEdit")
                .click();
        }
    });

    // ESC = CLOSE
    document.addEventListener("keydown",(e)=>{
        if(e.key !== "Escape") return;

        const editModal = document.getElementById("editModal");
        const deleteModal = document.getElementById("deleteModal");

        if(
            deleteModal &&
            !deleteModal.classList.contains("hidden")
        ){
            return;
        }

        if(
            editModal &&
            !editModal.classList.contains("hidden")
        ){
            e.preventDefault();

            document
                .getElementById("cancelEdit")
                .click();
        }
    });
}

export default initKeyboardShortcut;