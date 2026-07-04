document.addEventListener('alpine:init', () => {
    Alpine.data('sidebar', () => ({
        sidebarOpen: false,

        sidebarCollapsed:
            window.innerWidth >= 768
                ? localStorage.getItem('sidebarCollapsed') === 'true'
                : false,

        init() {
            window.addEventListener('resize', () => {
                // MOBILE
                if (window.innerWidth < 768) {
                    this.sidebarCollapsed = false;
                }

                // DESKTOP
                else {
                    this.sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                }
            });
        },

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },

        closeSidebar() {
            this.sidebarOpen = false;
        },

        toggleCollapse() {
            // collapse cuma desktop
            if (window.innerWidth >= 768) {
                this.sidebarCollapsed = !this.sidebarCollapsed;

                localStorage.setItem(
                    'sidebarCollapsed',
                    this.sidebarCollapsed
                );
            }
        }
    }));
});

// LOGOUT BUTTON
document.addEventListener("DOMContentLoaded", () => {
        const logoutForm = document.getElementById("logoutForm");
        const logoutBtn = document.getElementById("logoutBtn");
        const logoutBtnText = document.getElementById("logoutBtnText");

        if(
            !logoutForm ||
            !logoutBtn ||
            !logoutBtnText
        ){
            return;
        }

        logoutForm.addEventListener("submit", () => {
                logoutBtn.disabled = true;

                logoutBtn.classList.remove(
                    "bg-red-600",
                    "hover:bg-red-700"
                );

                logoutBtn.classList.add(
                    "bg-gray-500",
                    "cursor-not-allowed"
                );

                logoutBtnText.textContent = "Keluar...";

                const icon = logoutBtn.querySelector("i");

                if(icon){
                    icon.className ="fa-solid fa-spinner fa-spin";
                }
            }
        );
    }
);