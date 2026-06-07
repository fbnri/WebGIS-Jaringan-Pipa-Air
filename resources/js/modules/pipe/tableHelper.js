function reNumberTable() {
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach((row, index) => {
        const firstCell = row.querySelector("td");

        if(firstCell){
            firstCell.innerText = index + 1;
        }
    });
}

function initEmptyTable() {
    const tbody = document.querySelector("tbody");

    if(!tbody){
        return;
    }

    if(document.querySelectorAll("tbody tr").length === 0){

        tbody.innerHTML = `
            <tr>
                <td colspan="${window.pipeTableColspan}"
                    class="text-center py-6 text-gray-400">
                    Data pipa belum tersedia
                </td>
            </tr>
        `;
    }
}

export {
    reNumberTable,
    initEmptyTable
};