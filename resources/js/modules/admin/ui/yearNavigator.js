const currentYear = Number(window.currentYear);
const minYear = Number(window.minYear);
const maxYear = Number(window.maxYear);

let selectedYearNav = currentYear;

const prevYearBtn = document.getElementById("prevYear");
const nextYearBtn = document.getElementById("nextYear");
const yearDisplay = document.getElementById("yearDisplay");
const yearPanel = document.getElementById("yearPanel");

yearDisplay?.addEventListener("click", () => {
    const layerPanel = document.getElementById("layerPanel");

    layerPanel?.classList.add(
        "opacity-0",
        "scale-95",
        "pointer-events-none"
    );

    yearPanel.classList.toggle("opacity-0");
    yearPanel.classList.toggle("scale-95");
    yearPanel.classList.toggle("pointer-events-none");
});

document.querySelectorAll(".year-option").forEach(btn => {
    btn.addEventListener("click", () => {
        const year = btn.dataset.year;
        window.location.href = `?year=${year}`;
    });
});

prevYearBtn?.addEventListener("click", () => {
    if(selectedYearNav > minYear){
        selectedYearNav--;
        window.location.href = `?year=${selectedYearNav}`;
    }
});

nextYearBtn?.addEventListener("click", () => {
    if(selectedYearNav < maxYear){
        selectedYearNav++;
        window.location.href = `?year=${selectedYearNav}`;
    }
});

document.addEventListener("click", (e) => {
    if(
        yearPanel &&
        !yearPanel.contains(e.target) &&
        !yearDisplay.contains(e.target)
    ){
        yearPanel.classList.add(
            "opacity-0",
            "scale-95",
            "pointer-events-none"
        );
    }
});

const mobileYearBtn = document.getElementById("mobileYearBtn");
const mobileYearModal = document.getElementById("mobileYearModal");

mobileYearBtn?.addEventListener("click", () => {
    mobileYearModal.classList.remove("hidden");
    mobileYearModal.classList.add("flex");

    document.body.style.overflow = "hidden";
});

document.querySelectorAll(".mobile-year-option").forEach(btn => {
    btn.addEventListener("click", () => {
        const year = btn.dataset.year;
        window.location.href = `?year=${year}`;
    });
});

mobileYearModal?.addEventListener("click", (e) => {
    if(e.target === mobileYearModal){
        const modalContent = mobileYearModal.firstElementChild;

        modalContent.classList.remove("animate-slideUp");
        modalContent.classList.add("animate-slideDown");

        setTimeout(() => {
            mobileYearModal.classList.add("hidden");
            mobileYearModal.classList.remove("flex");

            modalContent.classList.remove("animate-slideDown");
            modalContent.classList.add("animate-slideUp");

            document.body.style.overflow = "";
        }, 200);
    }
});

const modalSheet = mobileYearModal?.firstElementChild;

let startY = 0;
let currentY = 0;
let isDragging = false;

modalSheet?.addEventListener("touchstart", (e) => {
    startY = e.touches[0].clientY;
    isDragging = true;

    modalSheet.style.transition = "none";
});

modalSheet?.addEventListener("touchmove", (e) => {
    if(!isDragging) return;

    currentY = e.touches[0].clientY;

    const diff = currentY - startY;

    if(diff > 0){
        modalSheet.style.transform = `translateY(${diff}px)`;
    }
});

modalSheet?.addEventListener("touchend", () => {
    if(!isDragging) return;

    isDragging = false;

    const diff = currentY - startY;

    modalSheet.style.transition = "transform 0.25s ease";

    if(diff > 180){
        modalSheet.style.transform = "translateY(100%)";

        setTimeout(() => {
            mobileYearModal.classList.add("hidden");
            mobileYearModal.classList.remove("flex");

            modalSheet.style.transition = "";
            modalSheet.style.transform = "";

            document.body.style.overflow = "";
        }, 250);
    } else {
        modalSheet.style.transform = "translateY(0)";
    }
});