import { smoothLine } from "../../shared/utils/smoothLine";
import { snapToNode } from "./snap";
import { setDrawingState,
    setDrawMode,
    getDrawMode,
    setExtendPipeId,
    getExtendPipeId,
    setExtendDirection,
    getExtendDirection
} from "./drawState";

let drawing = false;
let modalOpened = false;
let justOpenedModal = false;
let savingExtend = false;
let points = []; let originalGeometry = [];
let tempLine = null;
let previewLine = null;
let startExtendMarker = null;
let endExtendMarker = null;
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
    setDrawingState(true);

    const lengthInput = document.getElementById("create_length");

    if(lengthInput){
        lengthInput.value = "";
    }

    mapEl.style.cursor = "crosshair";

    drawToolbar.classList.remove("hidden");
    drawInfo.classList.remove("hidden");

    toggleDrawUI(true);

    if(getDrawMode() === "create"){
        points = [];
        window.tempGeometry = null;
    }
}

function disableDrawMode(){
    modalOpened = false;
    drawing = false;
    savingExtend = false;

    setDrawingState(false);

    mapEl.style.cursor = "";

    const finishBtn = document.getElementById("btnFinish");

    finishBtn.disabled = false;

    finishBtn.classList.remove(
        "opacity-70",
        "cursor-not-allowed"
    );

    finishBtn.innerHTML = `<i class="fa-solid fa-check"></i>`;

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

    setDrawMode("create");
    setExtendPipeId(null);
    setExtendDirection(null);

    originalGeometry = [];
    clearExtendMarker();
}

function calculateLength() {
    if (points.length < 2) {
        const lengthInput = document.getElementById("create_length");

        if (lengthInput) {
            lengthInput.value = "";
        }

        return 0;
    }

    let total = 0;

    for (let i = 1; i < points.length; i++) {
        total += points[i - 1].distanceTo(points[i]);
    }

    const rounded = Math.round(total);

    const lengthInput = document.getElementById("create_length");

    if (lengthInput) {
        lengthInput.value = rounded;
    }

    return rounded;
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

    window.tempGeometry = {
        type:"LineString",
        coordinates: points.map(p => [
            p.lng, p.lat
        ])
    };

    calculateLength();
}

function clearExtendMarker(){
    if(startExtendMarker){
        map.removeLayer(startExtendMarker);
        startExtendMarker = null;
    }

    if(endExtendMarker){
        map.removeLayer(endExtendMarker);
        endExtendMarker = null;
    }
}

function startDrawing(){
    enableDrawMode();
}

window.startExtendPipe = function(pipe){
    setDrawMode("extend");
    setExtendPipeId(pipe.id);
    setExtendDirection(null);

    originalGeometry = JSON.parse(pipe.geometry).coordinates.map(c => L.latLng(c[1], c[0]));
    points = [];
    drawing = false;

    setDrawingState(false);
    toggleDrawUI(true);

    drawToolbar.classList.add("hidden");
    drawInfo.classList.add("hidden");
    mapEl.style.cursor = "";

    if(tempLine){
        map.removeLayer(tempLine);
        tempLine = null;
    }

    if(previewLine){
        map.removeLayer(previewLine);
        previewLine = null;
    }

    clearExtendMarker();

    startExtendMarker = L.circleMarker(
        originalGeometry[0],
        {
            radius:10,
            color:"#22c55e",
            fillColor:"#22c55e",
            fillOpacity:1
        }
    ).addTo(map);

    endExtendMarker = L.circleMarker(
        originalGeometry[
            originalGeometry.length-1
        ],
        {
            radius:10,
            color:"#22c55e",
            fillColor:"#22c55e",
            fillOpacity:1
        }
    ).addTo(map);

    startExtendMarker.on("click",()=>{
        setExtendDirection("start");
        points=[...originalGeometry];
        enableDrawMode();
        redrawLine();
        clearExtendMarker();
    });

    endExtendMarker.on("click",()=>{
        setExtendDirection("end");
        points=[...originalGeometry];
        enableDrawMode();
        redrawLine();
        clearExtendMarker();
    });

    if(tempLine){
        map.removeLayer(tempLine);
        tempLine = null;
    }

    if(previewLine){
        map.removeLayer(previewLine);
        previewLine = null;
    }

    drawToolbar.classList.add("hidden");
    drawInfo.classList.add("hidden");

    mapEl.style.cursor = "";

    showToast(
        "Pilih ujung pipa yang ingin diperpanjang",
        "success"
    );
}

function updateExtendedPipe(){
    if(savingExtend){
        return;
    }

    savingExtend = true;

    const finishBtn = document.getElementById("btnFinish");

    finishBtn.disabled = true;

    finishBtn.classList.add(
        "opacity-70",
        "cursor-not-allowed"
    );

    finishBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i>`;

    const id = getExtendPipeId();

    fetch(`/admin/pipes/${id}`,{
        method:"PUT",
        headers:{
            "Content-Type":"application/json",
            "Accept":"application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },

        body:JSON.stringify({
            name:window.currentPipe.name,
            pipe_type:window.currentPipe.pipe_type,
            planned_at:window.currentPipe.planned_at,
            installed_at:window.currentPipe.installed_at,
            length: calculateLength(),
            geometry:window.tempGeometry
        })
    })

    .then(async res=>{
        const data = await res.json();

        if(!res.ok){
            let errorMessage = data.message || "Gagal memperpanjang pipa";

            if(data.errors){
                const first = Object.values(data.errors)[0];

                if(first){
                    errorMessage = first[0];
                }
            }
            throw new Error(errorMessage);
        }
        return data;
    })

    .then(()=>{
        drawToolbar.classList.add("hidden");
        drawInfo.classList.add("hidden");

        showToast(
            "Jalur pipa berhasil diperpanjang",
            "success"
        );

        setTimeout(()=>{
            location.reload();
        },800);
    })

    .catch(err=>{
        savingExtend = false;
        finishBtn.disabled = false;

        finishBtn.classList.remove(
            "opacity-70",
            "cursor-not-allowed"
        );

        finishBtn.innerHTML = `<i class="fa-solid fa-check"></i>`;

        showToast(
            err.message,
            "error"
        );
    });
}

const btnAddPipe = document.getElementById("btnAddPipe");

if(btnAddPipe){
    btnAddPipe.onclick = startDrawing;
}

const mobileBtn = document.getElementById("btnAddPipeMobile");

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
    if(!mouseDownPoint) return;

    const mouseUpPoint = map.mouseEventToContainerPoint(e.originalEvent);
    const distance = mouseDownPoint.distanceTo(mouseUpPoint);

    mouseDownPoint = null;

    if(distance > 6){
        return;
    }

    const point = snapToNode(e.latlng);

    if(getDrawMode() === "extend"){
        if(getExtendDirection() === "start"){
            points.unshift(point);
        }else{ points.push(point);

        }
    }else{
        points.push(point);
    }

    redrawLine();
});

map.on("mousemove",(e)=>{
    if(!drawing) return;

    const snappedPoint = snapToNode(e.latlng);

    if(points.length === 0) return;

    let previewPoints;

    if( getDrawMode() === "extend" && getExtendDirection() === "start"){
        previewPoints = [ snappedPoint, points[0] ];
    }else{
        previewPoints = [ points[points.length-1],
        snappedPoint ];
    } if(previewLine){
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
    if(getDrawMode() === "extend"){
        if(points.length <= originalGeometry.length){
            showToast(
                "Jalur asli tidak dapat dihapus",
                "error"
            );

            return;
        }
    }

    if(points.length === 0){
        return;
    }

    if(
        getDrawMode() === "extend" &&
        getExtendDirection() === "start"
    ){
        points.shift();
    }else{
        points.pop();
    }

    redrawLine();

    if(previewLine){
        map.removeLayer(previewLine);
        previewLine = null;
    }

    if(
        getDrawMode() === "create" &&
        points.length === 0
    ){

        if(tempLine){
            map.removeLayer(tempLine);
            tempLine = null;
        }

        window.tempGeometry = null;
    }
};

document.getElementById("btnFinish").onclick = ()=>{
    if(getDrawMode() === "extend"){
        if(points.length === originalGeometry.length){
            showToast(
                "Tambahkan minimal 1 titik baru untuk memperpanjang pipa",
                "error"
            );

            return;
        }
    }else{
        if(points.length < 2){
            showToast(
                "Minimal 2 titik",
                "error"
            );

            return;
        }
    }

    if(getDrawMode() === "extend"){
        updateExtendedPipe();

        return;
    }

    modalOpened = true;
    justOpenedModal = true;

    drawToolbar.classList.add("hidden");
    drawInfo.classList.add("hidden");

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

        if(getDrawMode() === "extend"){
            if(points.length <= originalGeometry.length){
                showToast(
                    "Jalur asli tidak dapat dihapus",
                    "error"
                );

                return;
            }
        }

        if(points.length === 0){
            return;
        }

        if(
            getDrawMode() === "extend" &&
            getExtendDirection() === "start"
        ){
            points.shift();
        }else{
            points.pop();
        }

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

    const createModal = document.getElementById("createModal");

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