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