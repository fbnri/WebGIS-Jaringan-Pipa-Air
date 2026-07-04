function initFilterPanel(){
    const filterBtn = document.getElementById("filterToggle");
    const filterPanel = document.getElementById("filterPanel");

    if(!filterBtn || !filterPanel){
        return;
    }

    filterBtn.addEventListener("click", (e) => {

        e.stopPropagation();

        filterPanel.classList.toggle("opacity-0");
        filterPanel.classList.toggle("scale-95");
        filterPanel.classList.toggle("pointer-events-none");
    });

    document.addEventListener("click", function(e){
        if(
            !filterPanel.contains(e.target) &&
            !filterBtn.contains(e.target)
        ){
            filterPanel.classList.add(
                "opacity-0",
                "scale-95",
                "pointer-events-none"
            );
        }
    });
}

export default initFilterPanel;