window.selectedYear = window.currentYear;

let pipeLayers = {};

window.renderUserPipes = function(){
    Object.values(pipeLayers).forEach(layer => map.removeLayer(layer));

    pipeLayers = {};

    pipesData.forEach(pipe => {
        if(!pipe.geometry) return;

        const geojson = {
            type: "Feature",
            geometry: JSON.parse(pipe.geometry)
        };

        // LOGIC STATUS BERDASARKAN TAHUN
        const isInstalled = pipe.installed_at && new Date(pipe.installed_at).getFullYear() <= selectedYear;
        const pipeColor = isInstalled ? "royalblue" : "cyan";
        const layer = L.geoJSON(geojson, {
            style: {
                color: pipeColor,
                weight: 5,
                opacity: 0.9
            },

            onEachFeature: function(feature, layer){
                layer.on({
                    mouseover: function(e){
                        e.target.setStyle({
                            weight: 7,
                            opacity: 1
                        });
                    },

                    mouseout: function(e){
                        e.target.setStyle({
                            weight: 5,
                            color: pipeColor,
                            opacity: 0.9
                        });
                    }
                });
            }
        }).addTo(map);

        pipeLayers[pipe.id] = layer;

        // FORMAT TANGGAL
        const plannedDate = pipe.planned_at
        ? new Date(pipe.planned_at).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        })
        : '-';

        const installedDate = pipe.installed_at
        ? new Date(pipe.installed_at).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        })
        : '-';

        layer.bindPopup(`
            <div class="min-w-[220px]">
                <div class="flex items-center gap-2 mb-3">
                    <div style="
                        width:10px;
                        height:10px;
                        border-radius:999px;
                        background:${pipeColor};
                    "></div>
                    <div style="
                        font-weight:700;
                        font-size:15px;
                        color:#111827;
                    ">
                        ${pipe.name}
                    </div>
                </div>
                <div style="
                    display:flex;
                    flex-direction:column;
                    gap:8px;
                    font-size:12px;
                    color:#374151;
                ">
                    <div>
                        <b>Status:</b>
                        ${isInstalled ? 'Terpasang' : 'Perencanaan'}
                    </div>
                    <div>
                        <b>Jenis:</b>
                        ${pipe.pipe_type ?? '-'}
                    </div>
                    <div>
                        <b>Panjang:</b>
                        ${pipe.length ?? 0} meter
                    </div>
                    <div>
                        <b>Direncanakan:</b>
                        ${plannedDate}
                    </div>
                    <div>
                        <b>Terpasang:</b>
                        ${installedDate}
                    </div>
                </div>
            </div>
        `);
    });
};

renderUserPipes();

window.updatePipeLegend = function () {
    const legend = document.getElementById("legendContent");

    if (!legend) {
        return;
    }

    let html = "";

    let hasInstalled = false;
    let hasPlanning = false;
    let hasCustomer = false;

    pipesData.forEach(pipe => {
        const plannedYear = pipe.planned_at
            ? new Date(pipe.planned_at).getFullYear()
            : null;

        const installedYear = pipe.installed_at
            ? new Date(pipe.installed_at).getFullYear()
            : null;

        if (plannedYear && plannedYear > selectedYear) {
            return;
        }

        if (
            installedYear &&
            installedYear <= selectedYear
        ) {
            hasInstalled = true;
        } else {
            hasPlanning = true;
        }
    });

    customersData.forEach(customer => {
        const subscribedYear = customer.subscribed_at
            ? new Date(customer.subscribed_at).getFullYear()
            : null;

        if (
            !subscribedYear ||
            subscribedYear <= selectedYear
        ) {
            hasCustomer = true;
        }
    });

    if (hasInstalled) {
        html += `
            <div class="flex items-center gap-2">
                <div class="w-6 flex-shrink-0">
                    <div class="w-6 h-1 bg-blue-600 rounded"></div>
                </div>
                <span>Terpasang</span>
            </div>
        `;
    }

    if (hasPlanning) {
        html += `
            <div class="flex items-center gap-2">
                <div class="w-6 flex-shrink-0">
                    <div class="w-6 h-1 bg-cyan-300 rounded"></div>
                </div>
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

    legend.innerHTML = html;
};

updatePipeLegend();