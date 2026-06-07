import { smoothLine } from "../utils/smoothLine";

let drawing = false;
let modalOpened = false;
let justOpenedModal = false;
let points = [];
let tempLine = null;
let previewLine = null;
let mouseDownPoint = null;

const mapEl = document.getElementById("map");
const drawToolbar = document.getElementById("drawToolbar");
const drawInfo = document.getElementById("drawInfo");

function toggleDrawUI(hide = false){
    const elements = document.querySelectorAll(".draw-hide");

    elements.forEach(el => {
        if(hide){
            el.style.opacity = "0";
            el.style.pointerEvents = "none";
            el.style.transform = "translateY(-10px)";

        }else{
            el.style.opacity = "1";
            el.style.pointerEvents = "auto";
            el.style.transform = "translateY(0)";
        }
    });
}

function enableDrawMode(){
    drawing = true;
    points = [];
    window.tempGeometry = null;

    mapEl.style.cursor = "crosshair";

    drawToolbar.classList.remove("hidden");
    drawInfo.classList.remove("hidden");

    toggleDrawUI(true);
}

function disableDrawMode(){
    modalOpened = false;
    drawing = false;

    mapEl.style.cursor = "";

    drawToolbar.classList.add("hidden");
    drawInfo.classList.add("hidden");

    toggleDrawUI(false);

    if(tempLine){
        map.removeLayer(tempLine);
        tempLine = null;
    }

    if(previewLine){
        map.removeLayer(previewLine);
        previewLine = null;
    }

    points = [];

    window.tempGeometry = null;
}

function redrawLine(){

    if(tempLine){
        map.removeLayer(tempLine);
    }

    tempLine = L.polyline(smoothLine(points),{
        color:"#0ea5e9",
        weight:5,
        lineCap:"round",
        lineJoin:"round"
    }).addTo(map);

    let total = 0;

    for(let i = 0; i < points.length - 1; i++){
        total += points[i]
            .distanceTo(points[i + 1]);
    }

    const lengthInput =
        document.getElementById("create_length");

    if(lengthInput){
        lengthInput.value = Math.round(total);
    }

    window.tempGeometry = {
        type:"LineString",
        coordinates: points.map(p => [
            p.lng,
            p.lat
        ])
    };
}

function startDrawing(){
    enableDrawMode();
}

const btnAddPipe =
    document.getElementById("btnAddPipe");

if(btnAddPipe){
    btnAddPipe.onclick = startDrawing;
}

const mobileBtn =
    document.getElementById("btnAddPipeMobile");

if(mobileBtn){
    mobileBtn.onclick = startDrawing;
}

map.on("mousedown", (e) => {
    if(!drawing) return;

    mouseDownPoint = map.mouseEventToContainerPoint(
        e.originalEvent
    );
});

map.on("mouseup", (e) => {
    if(!drawing) return;
    if(!mouseDownPoint) return;

    const mouseUpPoint =
        map.mouseEventToContainerPoint(
            e.originalEvent
        );

    const distance =
        mouseDownPoint.distanceTo(mouseUpPoint);

    mouseDownPoint = null;

    if(distance > 6){
        return;
    }

    points.push(e.latlng);

    redrawLine();
});

map.on("mousemove",(e)=>{
    if(!drawing) return;
    if(points.length === 0) return;

    const previewPoints = [
        points[points.length - 1],
        e.latlng
    ];

    if(previewLine){
        map.removeLayer(previewLine);
    }

    previewLine = L.polyline(smoothLine(previewPoints),{
        color:"#0ea5e9",
        weight:5,
        opacity:0.9,
        lineCap:"round",
        lineJoin:"round"
    }).addTo(map);
});

document.getElementById("btnUndo").onclick = ()=>{
    if(points.length === 0) return;

    points.pop();
    redrawLine();

    if(previewLine){
        map.removeLayer(previewLine);
        previewLine = null;
    }

    if(points.length === 0){
        if(tempLine){
            map.removeLayer(tempLine);
            tempLine = null;
        }

        window.tempGeometry = null;
    }
};

document.getElementById("btnFinish").onclick = ()=>{
    if(points.length < 2){
        showToast(
            "Minimal 2 titik!",
            "error"
        );

        return;
    }
    drawToolbar.classList.add("hidden");
    drawInfo.classList.add("hidden");

    modalOpened = true;
    justOpenedModal = true;

    openModalById("createModal");

    setTimeout(() => {
        justOpenedModal = false;
    }, 200);
};

document.getElementById("btnCancelDraw").onclick = ()=>{
    disableDrawMode();
};

document.getElementById("cancelCreate").onclick = ()=>{
    modalOpened = false;

    drawToolbar.classList.remove("opacity-30");
    drawInfo.classList.remove("opacity-30");

    closeModalById("createModal");

    disableDrawMode();
};

document.addEventListener("keydown",(e)=>{
    if(modalOpened) return;

    const active = document.activeElement;

    if(
        active && (active.tagName === "INPUT" || active.tagName === "TEXTAREA")
    ){
        return;
    }

    if(!drawing) return;

    if(e.key === "Escape"){
        disableDrawMode();
    }

    if(e.key === "Backspace"){
        e.preventDefault();
        points.pop();
        redrawLine();

        if(previewLine){
            map.removeLayer(previewLine);
            previewLine = null;
        }
    }

    if(
        e.key === "Enter" && !modalOpened
    ){
        document.getElementById("btnFinish").click();
    }
});

document.addEventListener("keydown",(e)=>{
    if(e.key !== "Escape") return;

    const createModal =
        document.getElementById("createModal");

    if(
        createModal &&
        !createModal.classList.contains("hidden")
    ){

        closeModalById("createModal");

        modalOpened = false;

        disableDrawMode();
    }
});

document.addEventListener("keydown",(e)=>{
    if(e.key !== "Enter") return;
    if(justOpenedModal) return;

    const createModal = document.getElementById("createModal");

    if(
        createModal &&
        !createModal.classList.contains("hidden")
    ){
        e.preventDefault();

        document.getElementById("saveCreate").click();
    }
});