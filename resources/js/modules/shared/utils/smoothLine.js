export function smoothLine(latlngs){
    if(latlngs.length < 3) return latlngs;

    let smoothed = [];

    for(let i = 0; i < latlngs.length - 1; i++){
        let p0 = latlngs[i];
        let p1 = latlngs[i + 1];

        let midLat = (p0.lat + p1.lat) / 2;
        let midLng = (p0.lng + p1.lng) / 2;

        smoothed.push(p0);
        smoothed.push(L.latLng(midLat, midLng));
    }

    smoothed.push(latlngs[latlngs.length - 1]);

    return smoothed;
}