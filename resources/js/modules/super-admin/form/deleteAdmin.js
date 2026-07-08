export default function initDeleteAdminForm(){
    const form = document.getElementById("deleteAdminForm");

    if(!form){
        return;
    }

    form.addEventListener("submit",()=>{
        const button = form.querySelector(".deleteAdminSubmit");

        if(!button){
            return;
        }

        if(button.dataset.loading){
            return;
        }

        button.dataset.loading = "true";
        button.disabled = true;

        button.classList.add(
            "opacity-70",
            "cursor-not-allowed"
        );

        button.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin mr-1"></i>
            Tunggu...
        `;
    });
}