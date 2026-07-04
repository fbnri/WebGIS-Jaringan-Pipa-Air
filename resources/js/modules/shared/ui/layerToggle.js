const layerBtn = document.getElementById("layerToggle");
const layerPanelEl = document.getElementById("layerPanel");

if(layerBtn && layerPanelEl){
    const icon = layerBtn.querySelector("i");

    layerBtn.addEventListener("click", () => {
        layerPanelEl.classList.toggle("opacity-0");
        layerPanelEl.classList.toggle("scale-95");
        layerPanelEl.classList.toggle("pointer-events-none");

        const isOpen = !layerPanelEl.classList.contains("opacity-0");

        if(isOpen){
            layerBtn.classList.remove("bg-white");
            layerBtn.classList.add("bg-blue-100");

            if(icon){
                icon.classList.remove("text-gray-600");
                icon.classList.add("text-blue-600");
            }
        } else {
            layerBtn.classList.remove("bg-blue-100");
            layerBtn.classList.add("bg-white");

            if(icon){
                icon.classList.remove("text-blue-600");
                icon.classList.add("text-gray-600");
            }
        }
    });
}