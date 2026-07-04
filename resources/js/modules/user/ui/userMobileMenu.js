const menuBtn = document.getElementById("menuBtn");
const mobileMenu = document.getElementById("mobileMenu");

let isOpen = false;

if(menuBtn && mobileMenu){
    menuBtn.addEventListener("click", () => {
        isOpen = !isOpen;

        if(isOpen){
            mobileMenu.classList.remove(
                "max-h-0",
                "opacity-0"
            );

            mobileMenu.classList.add(
                "max-h-40",
                "opacity-100"
            );
        } else {
            mobileMenu.classList.remove(
                "max-h-40",
                "opacity-100"
            );

            mobileMenu.classList.add(
                "max-h-0",
                "opacity-0"
            );
        }
    });
}