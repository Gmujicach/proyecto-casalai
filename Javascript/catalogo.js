document.addEventListener("DOMContentLoaded", function () {
    const modalCrearCombo = new bootstrap.Modal(document.getElementById('modalCrearCombo'));
    const modalSeleccionarProducto = new bootstrap.Modal(document.getElementById('modalSeleccionarProducto'));
    const productosSeleccionados = document.getElementById('productosSeleccionados');
    const btnCrearCombo = document.getElementById('btnCrearCombo');
    const btnAgregarProducto = document.getElementById('btnAgregarProducto');
    let listaProductos = [];

    function renderProductos() {
        productosSeleccionados.innerHTML = '';
        listaProductos.forEach((p, index) => {
            productosSeleccionados.innerHTML += `
                <div class="mb-2">
                    <strong>${p.nombre}</strong>
                    <button type="button" class="btn btn-sm btn-danger ms-2" onclick="eliminarProducto(${index})">X</button><br>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cambiarCantidad(${index}, -1)">-</button>
                    <input type="number" value="${p.cantidad}" class="mx-1" min="1" onchange="actualizarCantidad(${index}, this.value)">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cambiarCantidad(${index}, 1)">+</button>
                </div>`;
        });
    }

    window.cambiarCantidad = function (index, cambio) {
        listaProductos[index].cantidad = Math.max(1, listaProductos[index].cantidad + cambio);
        renderProductos();
    }

    window.actualizarCantidad = function (index, valor) {
        listaProductos[index].cantidad = Math.max(1, parseInt(valor) || 1);
        renderProductos();
    }

    window.eliminarProducto = function (index) {
        listaProductos.splice(index, 1);
        renderProductos();
    }

    document.querySelectorAll(".seleccionar-producto").forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            listaProductos = [{ id, nombre, cantidad: 1 }];
            renderProductos();
            modalCrearCombo.show();
        });
    });

    btnAgregarProducto.addEventListener("click", function () {
        modalSeleccionarProducto.show();
    });

    document.querySelectorAll(".seleccionar-producto-modal").forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            if (!listaProductos.some(p => p.id === id)) {
                listaProductos.push({ id, nombre, cantidad: 1 });
                renderProductos();
            } else {
                Swal.fire('Advertencia', 'El producto ya está agregado al combo', 'warning');
            }
            modalSeleccionarProducto.hide();
        });
    });

    document.getElementById("formCrearCombo").addEventListener("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "./Controlador/combos.php",
            type: "POST",
            data: {
                accion: "crear_combo",
                productos: JSON.stringify(listaProductos)
            },
            dataType: "json",
            success: function (res) {
                if (res.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Combo creado exitosamente',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    let combo = res.combo;
                    let html = `
                        <tr>
                            <td>${combo.id_combo}</td>
                            <td>${combo.productos}</td>
                            <td>${combo.precio_total}</td>
                        </tr>`;
                    document.querySelector("#tablaCombo tbody").innerHTML += html;
                    modalCrearCombo.hide();
                    listaProductos = [];
                    renderProductos();
                } else {
                    Swal.fire('Error', res.message || 'Error desconocido', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
            }
        });
    });
});
