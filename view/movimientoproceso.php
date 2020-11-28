<?php
session_start();
if (!isset($_SESSION['IdEmpleado'])) {
    echo '<script>location.href = "login.php";</script>';
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

    <?php include 'layout/head.php'; ?>

    <body>
        <div id="contenedor">
            <div id="cuerpo-contenedor">
                <!--header start-->
                <?php include 'layout/cabecera.php'; ?>
                <!--header finish-->
                <div id="main">
                    <!---->
                    <?php include 'layout/navegacion.php'; ?>
                    <div id="section">
                        <div class="section-content">
                            <!-- Inicio del dashboard -->

                            <section class="row row-reverse padding-10 border-bottom">
                                <div class="col-md-12">
                                    <span class="text-md-bold">Movimiento o ajuste de Productos</span>
                                    <img src="./image/loading.gif" id="imgLoad" width="28" height="28" />
                                </div>
                            </section>

                            <section class="row row-reverse border-bottom">
                                <div class="col-md-12 center-row left-col">
                                    <button class="btn button-primary margin-10" id="btnGuardar">
                                        <div class="content-button">
                                            <img src="./image/accept.png" />
                                            <span>Realizar proceso</span>
                                        </div>
                                    </button>
                                    <button class="btn button-secondary margin-10" id="btnProductos">
                                        <div class="content-button">
                                            <img src="./image/search.png" />
                                            <span>Buscar productos</span>
                                        </div>
                                    </button>
                                    <button class="btn button-secondary margin-10">
                                        <div class="content-button">
                                            <img src="./image/reports.png" />
                                            <span>Generar reporte</span>
                                        </div>
                                    </button>
                                </div>
                            </section>

                            <section class="row padding-10 border-bottom">
                                <table class="table-secundary">
                                    <thead>
                                        <tr>
                                            <th class="th-porcent-15">
                                                <span>Tipo de ajuste:</span>
                                            </th>
                                            <th class="th-porcent-35">
                                                <div class="contenedor-radio-button">
                                                    <div>
                                                        <input type="radio" id="rbIncremento" name="tbTipoAjuste" class="radio-custom" checked />
                                                        <label for="rbIncremento" class="radio-custom-label">
                                                            Incremento
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="rbDecremento" name="tbTipoAjuste" class="radio-custom" />
                                                        <label for="rbDecremento" class="radio-custom-label">
                                                            Decremento
                                                        </label>
                                                    </div>

                                                </div>
                                            </th>
                                            <th class="th-porcent-15">
                                                <span>Estado del movimiento:</span>
                                            </th>
                                            <th class="th-porcent-35">
                                                <input type="checkbox" id="cbEstadoMivimiento" class="checkbox-custom" checked>
                                                <label for="cbEstadoMivimiento" class="checkbox-custom-label" id="lblEstadoMovimiento">Validado</label>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th class="th-porcent-15">
                                                <span>Tipo de Movimiento:</span>
                                            </th>
                                            <th class="th-porcent-35">
                                                <select id="cbTipoMovimiento">
                                                    <option value="0">--TODOS--</option>
                                                </select>
                                            </th>

                                            <th class="th-porcent-15">
                                                <span>Código de Verificación:</span>
                                            </th>
                                            <th class="th-porcent-35">
                                                <input type="text" id="txtCodigoVerificacion" class="input-primary" placeholder="Ingrese el código de verificación" />

                                            </th>
                                        </tr>

                                        <tr>
                                            <th class="th-porcent-15">
                                                <span>Observación:</span>
                                            </th>
                                            <th class="th-porcent-35">
                                                <input type="text" class="input-primary" value="N/D" id="txtObservacion" />
                                            </th>

                                        </tr>

                                    </thead>
                                </table>
                            </section>

                            <div class="row padding-10">
                                <table class="table-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="th-porcent-10">Acción</th>
                                            <th scope="col" class="th-porcent-30">Clave/Nombre</th>
                                            <th scope="col" class="th-porcent-20">Nueva Existencia</th>
                                            <th scope="col" class="th-porcent-20">Existencia Actual</th>
                                            <th scope="col" class="th-porcent-20">Diferencia</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbList">

                                    </tbody>
                                </table>
                            </div>
                            <!---->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal productos -->
        <div class="modal-detalle-venta" id="id-modal-productos">
            <div class="modal-detalle-venta-content md-modal">
                <div class="modal-detalle-venta-content-body">

                    <div class="modal-detalle-venta-content-header center-row padding-10">
                        <h4>Detalle del Ingreso</h4>
                        <div class="productos-btn-close">
                            <button class="btn button-secondary" id="btnCloseModal">
                                <div class="content-button">
                                    <span>X</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="row row-reverse border-bottom padding-10">
                        <div class="col-md-9 center-row">
                            <span class="text-xs">Buscar:</span>
                            <input type="text" class="input-primary" id="txtBuscarProducto" placeholder="Buscar productos por código o descripción" autofocus />
                        </div>
                        <div class="col-md-3 center-row right-col">
                            <button class="btn button-secondary" id="btnRecargarProductos">
                                <div class="content-button">
                                    <img src="./image/reload.png" />
                                    <span>Recargar</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="modal-detalle-venta-content-detail border-bottom padding-10">
                        <div class="row">
                            <table class="table-primary">
                                <thead>
                                    <tr>
                                        <th class="th-porcent-5">N°</th>
                                        <th class="th-porcent-35">Clave/Nombre</th>
                                        <th class="th-porcent-15">Categoría/Marca</th>
                                        <th class="th-porcent-15">Cantidad</th>
                                        <th class="th-porcent-15">Impuesto</th>
                                        <th class="th-porcent-15">Precio</th>
                                    </tr>
                                </thead>
                                <tbody id="tbProductos">

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 right-col center-row padding-10">
                            <button class="btn button-secondary" id="btnAnterior">
                                <div class="content-button">
                                    <img src="./image/left.png" />
                                    <span></span>
                                </div>
                            </button>
                            <span class="margin-5 text-xs" id="lblPaginaActual">0</span>
                            <span class="margin-5 text-xs">de</span>
                            <span class="margin-5 text-xs" id="lblPaginaSiguiente">0</span>
                            <button class="btn button-secondary" id="btnSiguiente">
                                <div class="content-button">
                                    <img src="./image/right.png" />
                                    <span></span>
                                </div>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- modal productos -->

        <!-- alert modal  -->
        <div id="idModal" class="modal-backdrop">
            <div class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-title">
                                <div class="modal-title-text">
                                    <span id="title-text"></span>
                                </div>
                                <div class="modal-title-button">
                                    <button id="btnClose" class="btn button-secondary " type="button">
                                        <div class="content-button">
                                            <span>X</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-message">
                                <div class="modal-message-icon">
                                    <i id="icon-modal" class=" icon-color-info"></i>
                                </div>
                                <div class="modal-message-text">
                                    <div class="title-message">
                                        <span id="icon-text" class=""></span>
                                    </div>
                                    <div class="content-message">
                                        <span id="content-text" class=""></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer padding-10" id="modal-footer-content">
                            <button id="btnAccept" class="btn button-primary" type="button">
                                <div class="content-button">
                                    <img src="./image/ok.svg" />
                                    <span>Aceptar</span>
                                </div>
                            </button>
                            <button id="btnCancel" class="btn button-secundary" type="button">
                                <div class="content-button">
                                    <img src="./image/error.svg" />
                                    <span>Cancelar</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- alert modal -->

        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/tools.js"></script>
        <script>
            let tools = new Tools();

            let state = false;
            let paginacion = 0;
            let opcion = 0;
            let totalPaginacion = 0;
            let filasPorPagina = 10;

            let txtBuscarProducto = $("#txtBuscarProducto");
            let tbProductos = $("#tbProductos");
            let lblPaginaActual = $("#lblPaginaActual");
            let lblPaginaSiguiente = $("#lblPaginaSiguiente");

            let tbList = $("#tbList");
            let rbIncremento = $("#rbIncremento")
            let rbDecremento = $("#rbDecremento");

            let arrayProductos = [];
            let cbTipoMovimiento = $("#cbTipoMovimiento");

            $(document).ready(function() {
                $("#btnCerrarSession").click(function() {
                    window.location.href = "closesession.php";
                });

                $("#btnGuardar").on("click", function(event) {
                    validateIngreso();
                });

                $("#btnGuardar").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        validateIngreso();
                    }
                    event.preventDefault();
                });

                $("#btnProductos").on("click", function(event) {
                    $("#id-modal-productos").css({
                        "display": "flex"
                    });
                    loadInitProductos();
                });

                $("#btnProductos").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        $("#id-modal-productos").css({
                            "display": "flex"
                        });
                        loadInitProductos();
                    }
                });

                rbIncremento.click(function() {
                    loadTipoMovimiento($("#rbIncremento")[0].checked);
                });

                rbDecremento.click(function() {
                    loadTipoMovimiento($("#rbIncremento")[0].checked);
                });

                $("#cbEstadoMivimiento").click(function() {
                    $("#lblEstadoMovimiento").html($("#cbEstadoMivimiento")[0].checked ? "Validado" : "Por Validar");
                });

                $("#txtCodigoVerificacion").val(loadCodeRandom());
                loadComponentsModal();
                loadTipoMovimiento($("#rbIncremento")[0].checked);
            });

            function validateIngreso() {
                let count = 0;
                $("#tbList tr").each(function(row, tr) {
                    for (let producto of arrayProductos) {
                        if ($(tr)[0].id === producto.IdSuministro) {
                            if (!tools.isNumeric($(tr).find("td:eq(2)").find("input").val()) || parseFloat($(tr).find("td:eq(2)").find("input").val()) <= 0) {
                                count++;
                            }
                            break;
                        }
                    }
                });

                if (cbTipoMovimiento.val() === "0" || cbTipoMovimiento.val() === undefined) {
                    tools.alertWarning("Movimiento", "Seleccione un tipo de movimiento.");
                } else if (arrayProductos.length === 0) {
                    tools.alertWarning("Movimiento", "No hay productos en la lista para continuar.");
                } else if (count > 0) {
                    tools.alertWarning("Movimiento", "Hay valores que no son numéricos o menores que 1 en la columna nueva existencia.");
                } else {
                    let newArrayProductos = [];
                    $("#tbList tr").each(function(row, tr) {
                        for (let producto of arrayProductos) {
                            if ($(tr)[0].id === producto.IdSuministro) {
                                let newProducto = producto;
                                newProducto.Movimiento = parseFloat($(tr).find("td:eq(2)").find("input").val());
                                newArrayProductos.push(newProducto);
                                break;
                            }
                        }
                        // console.log($(tr)[0]);
                        // console.log($(tr).find("td:eq(2)").find("input").val());
                    });
                    registrarMovimiento(newArrayProductos);
                }
            }

            function loadComponentsModal() {
                txtBuscarProducto.on("keyup", function(event) {
                    if (txtBuscarProducto.val().trim().length != 0) {
                        if (!state) {
                            paginacion = 1;
                            ListarProductos(1, txtBuscarProducto.val().trim());
                            opcion = 1;
                        }
                    }
                    event.preventDefault();
                });

                $("#btnCloseModal").on("click", function(event) {
                    $("#id-modal-productos").css({
                        "display": "none"
                    });
                });

                $("#btnCloseModal").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        $("#id-modal-productos").css({
                            "display": "none"
                        });
                    }
                    event.preventDefault();
                });

                $("#tbProductos").on("click", "tr", function(event) {
                    $(".selected-table-tr").removeClass("selected-table-tr");
                    $(this).addClass("selected-table-tr");
                });

                $("#btnAnterior").click(function() {
                    if (!state) {
                        if (paginacion > 1) {
                            paginacion--;
                            onEventPaginacion();
                        }
                    }
                });

                $("#btnSiguiente").click(function() {
                    if (!state) {
                        if (paginacion < totalPaginacion) {
                            paginacion++;
                            onEventPaginacion();
                        }
                    }
                });

                $("#btnRecargarProductos").click(function() {
                    loadInitProductos();
                });

                txtBuscarProducto.focus();

            }

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        ListarProductos(0, "");
                        break;
                    case 1:
                        ListarProductos(1, txtBuscarProducto.val().trim());
                        break;
                }
            }

            function loadInitProductos() {
                if (!state) {
                    paginacion = 1;
                    ListarProductos(0, "");
                    opcion = 0;
                }
            }

            function ListarProductos(tipo, value) {
                $.ajax({
                    url: "../app/controller/suministros/ListarSuministros.php",
                    method: "GET",
                    data: {
                        "type": "modalproductos",
                        "tipo": tipo,
                        "value": value,
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        tbProductos.empty();
                        state = true;
                    },
                    success: function(result) {
                        let object = JSON.parse(result);
                        if (object.estado === 1) {
                            let productos = object.data;
                            for (let producto of productos) {
                                tbProductos.append('<tr ondblclick=onSelectProducto(\'' + producto.IdSuministro + '\')>' +
                                    '<td class="td-center">' + producto.Id + '</td>' +
                                    '<td class="td-left">' + producto.Clave + '</br>' + producto.NombreMarca + '</td>' +
                                    '<td class="td-left">' + producto.Categoria + '<br>' + producto.Marca + '</td>' +
                                    '<td class="td-left">' + tools.formatMoney(parseFloat(producto.Cantidad)) + '</td>' +
                                    '<td class="td-left">' + producto.ImpuestoNombre + '</td>' +
                                    '<td class="td-left">' + tools.formatMoney(parseFloat(producto.PrecioVentaGeneral)) + '</td>' +
                                    '</tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(object.total) / filasPorPagina)));
                            lblPaginaActual.html(paginacion);
                            lblPaginaSiguiente.html(totalPaginacion);
                            state = false;
                        } else {
                            tbProductos.empty();
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbProductos.empty();
                        state = false;
                    }
                });
            }

            function loadTipoMovimiento(ajuste) {
                $.get("../app/controller/tipomovimiento/ListarTipoMovimientos.php", {
                    "ajuste": ajuste,
                    "all": "false"
                }, function(data, status) {
                    if (status === "success") {
                        let result = data;
                        if (result.estado === 1) {
                            cbTipoMovimiento.empty();
                            cbTipoMovimiento.append('<option value="0">--TODOS--</option>');
                            for (let tipos of result.data) {
                                cbTipoMovimiento.append('<option value="' + tipos.IdTipoMovimiento + '">' + tipos.Nombre + '</option>');
                            }
                        } else {
                            cbTipoMovimiento.empty();
                        }
                    }
                });
            }

            function onSelectProducto(idSuministro) {
                $("#id-modal-productos").css({
                    "display": "none"
                });
                if (!validateDuplicate(idSuministro)) {
                    $.ajax({
                        url: "../app/controller/suministros/ObtenerSuministro.php",
                        method: "GET",
                        data: {
                            "idSuministro": idSuministro
                        },
                        beforeSend: function() {
                            // tbList.empty();s
                            tools.alertLoad("Movimiento", "Agregando producto.");
                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                let suministro = result.data;
                                arrayProductos.push(suministro);
                                tbList.append('<tr id="' + suministro.IdSuministro + '">' +
                                    '<td class="td-center"><button class="btn button-dark" onclick="removeTableTr(\'' + suministro.IdSuministro + '\')"><div class="content-button"><img src="./image/remove.png" width="32" /><span></span></div></button></td>' +
                                    '<td class="td-left">' + suministro.Clave + '</br>' + suministro.NombreMarca + '</td>' +
                                    '<td class="td-left"><input type="number" value="0.00" class="input-primary" /></td>' +
                                    '<td class="td-left">' + suministro.Cantidad + " " + suministro.UnidadCompraNombre + '</td>' +
                                    '<td class="td-left">0.00</td>' +
                                    '</tr>');
                                $("#idModal").css("display", "none");
                            } else {
                                tools.alertWarning("Movimiento", "Problemas en agregar el producto, intente nuevamente.");
                            }
                        },
                        error: function(error) {
                            tools.alertError("Movimiento", "Error al agregar el producto, comuníquese con su proveedor.");
                        }
                    });
                } else {
                    tools.alertWarning("Movimiento", "Hay producto con las mismas características.");
                }
            }

            function registrarMovimiento(newArrayProductos) {
                $.ajax({
                    url: "../app/controller/tipomovimiento/RegistrarMovimiento.php",
                    method: "POST",
                    accepts: "application/json",
                    contentType: "application/json",
                    data: JSON.stringify({
                        "fecha": tools.getCurrentDate(),
                        "hora": tools.getCurrentTime(),
                        "tipoAjuste": rbIncremento[0].checked,
                        "tipoMovimiento": cbTipoMovimiento.val(),
                        "observacion": $("#txtObservacion").val(),
                        "proveedor": "",
                        "suministro": 1,
                        "articulo": 0,
                        "estado": $("#cbEstadoMivimiento")[0].checked,
                        "codigoVerificacion": $("#txtCodigoVerificacion").val().trim(),
                        "lista": newArrayProductos
                    }),
                    beforeSend: function() {
                        tools.alertLoad("Movimiento", "Agregando producto.");
                    },
                    success: function(result) {
                        if (result.estado === 1) {
                            tools.alertInformation("Movimiento", result.mensaje, function() {
                                $("#idModal").css("display", "none");
                            });
                            arrayProductos.splice(0, arrayProductos.length);
                            tbList.empty();
                            $("#rbIncremento")[0].checked = true;
                            loadTipoMovimiento($("#rbIncremento")[0].checked);
                            $("#txtObservacion").val("N/D");
                            $("#cbEstadoMivimiento")[0].checked = true;
                        } else {
                            tools.alertWarning("Movimiento", result.mensaje);
                        }
                    },
                    error: function(error) {
                        tools.alertError("Movimiento", "Error en problemas de enviar los datos, comuníquese con su proveedor.");
                    }
                });
            }

            function removeTableTr(idSuministro) {
                $("#" + idSuministro).remove();
                for (let i = 0; i < arrayProductos.length; i++) {
                    if (arrayProductos[i].IdSuministro === idSuministro) {
                        arrayProductos.splice(i, 1);
                        break;
                    }
                }
            }

            function loadCodeRandom() {
                let d = new Date();
                let rn = Math.floor(Math.random() * (1000 - 100) + 1000);
                return "M" + rn + "" + d.getHours();
            }

            function validateDuplicate(IdSuministro) {
                let ret = false;
                for (let i = 0; i < arrayProductos.length; i++) {
                    if (arrayProductos[i].IdSuministro === IdSuministro) {
                        ret = true;
                        break;
                    }
                }
                return ret;
            }
        </script>
    </body>

    </html>
<?php
}
