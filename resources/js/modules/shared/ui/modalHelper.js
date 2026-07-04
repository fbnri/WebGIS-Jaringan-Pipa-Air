window.openModalById = function(id){
    const m = document.getElementById(id);
    const content = m.querySelector(".modal-content");

    m.classList.remove("hidden");

    setTimeout(()=>{
        m.classList.add("flex","opacity-100");

        content.classList.remove("scale-95","opacity-0");
        content.classList.add("scale-100","opacity-100");
    },10);
}

window.closeModalById = function(id){
    const m = document.getElementById(id);
    const content = m.querySelector(".modal-content");

    content.classList.remove("scale-100","opacity-100");
    content.classList.add("scale-95","opacity-0");

    m.classList.remove("opacity-100");

    setTimeout(()=>{
        m.classList.add("hidden");
        m.classList.remove("flex");
    },200);
}

const cancelBtn = document.getElementById("cancelBtn");

if(cancelBtn){
    cancelBtn.onclick = () => {
        closeModalById("editModal");
    };
}   