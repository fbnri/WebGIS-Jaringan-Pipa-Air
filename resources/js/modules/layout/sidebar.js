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
                    this.sidebarCollapsed =
                        localStorage.getItem('sidebarCollapsed') === 'true';
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