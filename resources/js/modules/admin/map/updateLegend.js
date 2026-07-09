export default function updateLegend({
    hasInstalled,
    hasPlanning,
    hasCustomer
}) {
    const legendBox = document.getElementById("legendBox");
    const legendItems = document.getElementById("legendItems");

    if (!legendBox || !legendItems) {
        return;
    }

    let html = "";

    if (hasInstalled) {
        html += `
            <div class="flex items-center gap-2">
                <div class="w-6 h-1 bg-blue-600 rounded flex-shrink-0"></div>
                <span>Terpasang</span>
            </div>
        `;
    }

    if (hasPlanning) {
        html += `
            <div class="flex items-center gap-2">
                <div class="w-6 h-1 bg-cyan-300 rounded flex-shrink-0"></div>
                <span>Perencanaan</span>
            </div>
        `;
    }

    if (hasCustomer) {
        html += `
            <div class="flex items-center gap-2">
                <div class="w-6 flex justify-center flex-shrink-0">
                    <i class="fa-solid fa-location-dot text-red-500"></i>
                </div>
                <span>Pelanggan</span>
            </div>
        `;
    }

    if (html === "") {
        legendBox.classList.add("hidden");
        return;
    }

    legendBox.classList.remove("hidden");
    legendItems.innerHTML = html;
}