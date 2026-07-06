let drawing = false;
let drawMode = "create";
let extendPipeId = null;
let extendDirection = null;

export function setDrawingState(state) {
    drawing = state;
}

export function isDrawing() {
    return drawing;
}

export function setDrawMode(mode){
    drawMode = mode;
}

export function getDrawMode(){
    return drawMode;
}

export function setExtendPipeId(id){
    extendPipeId = id;
}

export function getExtendPipeId(){
    return extendPipeId;
}

export function setExtendDirection(direction){
    extendDirection = direction;
}

export function getExtendDirection(){
    return extendDirection;
}