import { 
    isDrawing,
    getDrawMode
} from "./drawState";

window.selectedYear = window.currentYear;

let pipeLayers = {};

window.renderPipes = function(){
    Object.values(pipeLayers).forEach(layer => map.removeLayer(layer));

    pipeLayers = {};

    pipesData.forEach(pipe => {
        if(!pipe.geometry) return;

        const geojson = {type:"Feature", geometry:JSON.parse(pipe.geometry)};
        const isInstalled = pipe.installed_at && new Date(pipe.installed_at).getFullYear() <= selectedYear;
        const pipeColor = isInstalled ? "royalblue" : "cyan";
        const layer = L.geoJSON(geojson,{
            style:{
                color: pipeColor,
                weight:4,
                opacity:0.9
            },

            onEachFeature:function(feature, layer){
                layer.on({
                    mouseover:function(e){
                        e.target.setStyle({
                            weight:7,
                            opacity:1
                        });
                    },

                    mouseout:function(e){
                        e.target.setStyle({
                            color:pipeColor,
                            weight:4,
                            opacity:0.9
                        });
                    }
                });
            }
        }).addTo(map);

        pipeLayers[pipe.id] = layer;

        layer.on('add', () => {
            layer.eachLayer(l => {
                const el = l.getElement();

                if(el){
                    el.style.cursor = 'pointer';
                }
            });
        });

        layer.on("click",() => {
            window.currentPipe = pipe;

            if (
                isDrawing() ||
                getDrawMode() === "extend"
            ){
                return;
            }

            window.currentPipe = pipe;

            document.getElementById("edit_id").value = pipe.id;
            document.getElementById("edit_name").value = pipe.name;
            document.getElementById("edit_type").value = pipe.pipe_type;
            document.getElementById("edit_planned_at").value = pipe.planned_at ?? '';
            document.getElementById("edit_installed_at").value = pipe.installed_at ?? '';
            document.getElementById("edit_length").value = pipe.length;
            document.getElementById("extendPipe").onclick = () => {
                closeModalById("editModal");

                setTimeout(()=>{
                    startExtendPipe(pipe);
                },200);
            };

            openModalById("editModal");

            const extendBtn = document.getElementById("extendPipe");

            extendBtn.onclick = () => {
                closeModalById("editModal");

                setTimeout(() => {
                    window.startExtendPipe(pipe);
                },200);
            };
        });
    });
}
renderPipes();