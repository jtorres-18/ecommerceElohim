let estadosGlobal = [];

window.onload = function () {
    cargarEstados();
};

function cargarEstados() {
    $.get("get_estados.php", function (res) {
        const data = typeof res === "object" ? res : JSON.parse(res);
        console.log("Respuesta de get_estados.php:", data); // Para debug

        if (data.success) {
            estadosGlobal = data.estados;

            const selectFiltro = document.getElementById("filtro_estado");
            selectFiltro.innerHTML = '<option value="0">Todos</option>'; // opción general

            estadosGlobal.forEach(e => {
                const option = document.createElement("option");
                option.value = e.id;
                option.textContent = e.nombre;
                selectFiltro.appendChild(option);
            });

            cargarPedidos();
        } else {
            Swal.fire("Error", "No se pudo cargar los estados", "error");
        }
    });
}

function cargarPedidos() {
    const estadoSeleccionado = parseInt(document.getElementById("filtro_estado").value);

    $.get("listar_todos_pedidos.php", function (res) {
        const data = typeof res === "object" ? res : JSON.parse(res);
        const tbody = document.getElementById("tablaVentasPendientes");
        tbody.innerHTML = "";

        const ventasFiltradas = estadoSeleccionado === 0
            ? data.ventas
            : data.ventas.filter(v => parseInt(v.id_estado) === estadoSeleccionado);

            ventasFiltradas.forEach(v => {
                const opciones = estadosGlobal.map(e =>
                    `<option value="${e.id}" ${e.id == v.id_estado ? "selected" : ""}>${e.nombre}</option>`
                ).join("");
            
                tbody.innerHTML += `
                    <tr>
                        <td>${v.factura}</td>
                        <td>${v.direccion}</td>
                        <td>${v.fecha_hora}</td>
                        <td>${v.metodo_pago}</td>
                        <td>${v.total_venta}</td>
                        <td>${generarBadgeEstado(v.estado_nombre)}</td>
                        <td>
                            <select class="form-select form-select-sm ${claseSelect}" onchange="cambiarEstado(${v.id}, this.value)">
                                ${opciones}
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="verDetalles(${v.id})">Detalles</button>
                        </td>
                    </tr>`;
            });
    });
}

function cambiarEstado(id_venta, id_estado) {
    const estadoSeleccionado = document.getElementById("filtro_estado").value;

    $.post("cambiar_estado_venta.php", { id_venta, id_estado }, function (res) {
        const data = typeof res === "object" ? res : JSON.parse(res);
        if (data.success) {
            Swal.fire("Estado actualizado", "", "success");
            document.getElementById("filtro_estado").value = estadoSeleccionado;
            cargarPedidos();
        } else {
            Swal.fire("Error", data.message, "error");
        }
    });
}

function filtrarPorEstado() {
    const estadoSeleccionado = parseInt(document.getElementById("filtro_estado").value);
    const facturaBuscada = document.getElementById("filtro_factura").value.toLowerCase();

    $.get("listar_todos_pedidos.php", function (res) {
        const data = typeof res === "object" ? res : JSON.parse(res);
        const tbody = document.getElementById("tablaVentasPendientes");
        tbody.innerHTML = "";

        let ventasFiltradas = data.ventas;

        if (estadoSeleccionado !== 0) {
            ventasFiltradas = ventasFiltradas.filter(v => parseInt(v.id_estado) === estadoSeleccionado);
        }

        if (facturaBuscada !== "") {
            ventasFiltradas = ventasFiltradas.filter(v => v.factura.toLowerCase().includes(facturaBuscada));
        }

        ventasFiltradas.forEach(v => {
            const opciones = estadosGlobal.map(e =>
                `<option value="${e.id}" ${e.id == v.id_estado ? "selected" : ""}>${e.nombre}</option>`
            ).join("");

            let claseSelect = "";
            switch (v.estado_nombre.toLowerCase()) {
                case "pendiente": claseSelect = "border-warning text-warning"; break;
                case "aprobado": claseSelect = "border-success text-success"; break;
                case "cancelado": claseSelect = "border-danger text-danger"; break;
                case "enviado": claseSelect = "border-primary text-primary"; break;
                case "recibido": claseSelect = "border-info text-info"; break;
                case "listo para recoger": claseSelect = "border-dark text-dark"; break;
                default: claseSelect = "border-secondary text-secondary";
            }

            tbody.innerHTML += `
                <tr>
                    <td>${v.factura}</td>
                    <td>${v.total_venta}</td>
                    <td>${v.direccion}</td>
                    <td>${v.fecha_hora}</td>
                    <td>${v.metodo_pago}</td>
                    <td>$${v.total_venta}</td>
                    <td>${generarBadgeEstado(v.estado_nombre)}</td>
                    <td>
                        <select class="form-select form-select-sm ${claseSelect}" onchange="cambiarEstado(${v.id}, this.value)">
                            ${opciones}
                        </select>
                    </td>
                </tr>`;
        });
    });
}


function generarBadgeEstado(estado) {
    let clase = "secondary"; // clase por defecto

    switch (estado.toLowerCase()) {
        case "pendiente":
            clase = "warning";
            break;
        case "aprobado":
            clase = "success";
            break;
        case "cancelado":
            clase = "danger";
            break;
        case "enviado":
            clase = "primary";
            break;
        case "recibido":
            clase = "info";
            break;
        case "listo para recoger":
            clase = "dark";
            break;
    }

    return `<span class="badge bg-${clase}">${estado}</span>`;
}


let claseSelect = "";

switch (v.estado_nombre.toLowerCase()) {
    case "pendiente": claseSelect = "border-warning text-warning"; break;
    case "aprobado": claseSelect = "border-success text-success"; break;
    case "cancelado": claseSelect = "border-danger text-danger"; break;
    case "enviado": claseSelect = "border-primary text-primary"; break;
    case "recibido": claseSelect = "border-info text-info"; break;
    case "listo para recoger": claseSelect = "border-dark text-dark"; break;
    default: claseSelect = "border-secondary text-secondary";
}

function limpiarFiltros() {
  document.getElementById("filtro_factura").value = "";
  document.getElementById("filtro_estado").value = "0";
  filtrarPorEstado();
}
