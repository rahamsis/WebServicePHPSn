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
                                    <span class="text-md-bold">Movimientos Realizados</span>
                                    <img src="./image/loading.gif" id="imgLoad" width="28" height="28" />
                                </div>
                            </section>

                            <section class="row row-reverse border-bottom">
                                <button class="btn button-primary margin-10" id="btnMovimiento">
                                    <div class="content-button">
                                        <img src="./image/plazos.png" />
                                        <span>Realizar M o A</span>
                                    </div>
                                </button>
                                <button class="btn button-secondary margin-10" id="btnReload">
                                    <div class="content-button">
                                        <img src="./image/reload.png" />
                                        <span>Recargar</span>
                                    </div>
                                </button>
                            </section>

                            <div class="row row-reverse border-bottom">
                                <div class="col-md-5 center-row padding-10">
                                    <span class="text-xs margin-5">Moviminento:</span>
                                    <select id="cbTipoMovimiento">
                                        <option value="0">--TODOS--</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row row-reverse border-bottom">
                                <div class="col-md-4 center-row padding-10">
                                    <span class="text-xs margin-5">Inicio:</span>
                                    <input type="date" class="input-date" id="txtFechaInicio">
                                </div>
                                <div class="col-md-4 center-row padding-10">
                                    <span class="text-xs margin-5">Término:</span>
                                    <input type="date" class="input-date" id="txtFechaTermino">
                                </div>
                                <div class="col-md-4 right-col center-row padding-10">
                                    <button class="btn button-danger" id="btnAnterior">
                                        <div class="content-button">
                                            <img src="./image/left.png" />
                                            <span></span>
                                        </div>
                                    </button>
                                    <span class="margin-5 text-xs" id="lblPaginaActual">0</span>
                                    <span class="margin-5 text-xs">de</span>
                                    <span class="margin-5 text-xs" id="lblPaginaSiguiente">0</span>
                                    <button class="btn button-danger" id="btnSiguiente">
                                        <div class="content-button">
                                            <img src="./image/right.png" />
                                            <span></span>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <div class="row padding-10">
                                <table class="table-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="th-porcent-5">N°</th>
                                            <th scope="col" class="th-porcent-15">Tipo Movimiento</th>
                                            <th scope="col" class="th-porcent-10">Fecha y Hora</th>
                                            <th scope="col" class="th-porcent-25">Observación</th>
                                            <th scope="col" class="th-porcent-20">Información</th>
                                            <th scope="col" class="th-porcent-15">Estado</th>
                                            <th scope="col" class="th-porcent-10">Opciones</th>
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
                            <button id="btnAccept" class="btn button-primary margin-horizontal-5" type="button">
                                <div class="content-button">
                                    <img src="./image/ok.svg" />
                                    <span>Aceptar</span>
                                </div>
                            </button>
                            <button id="btnCancel" class="btn button-secondary margin-horizontal-5" type="button">
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


        <!-- Modal del detalle de ingreso -->
        <div class="modal-detalle-venta" id="id-modal-productos">
            <div class="modal-detalle-venta-content md-modal">
                <div class="modal-detalle-venta-content-body">

                    <div class="modal-detalle-venta-content-header center-row padding-10">
                        <h4>Detalle del Movimiento</h4>
                        <div class="productos-btn-close">
                            <button class="btn button-secondary" id="btnCloseModal">
                                <div class="content-button">
                                    <span>X</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="row border-bottom padding-horizontal-10">
                        <div class="col-md-12 margin-vertical-5">
                            <table class="table-secundary">
                                <thead>
                                    <tr>
                                        <th class="th-porcent-10 td-left text-primary">Tipo de Movimiento:</th>
                                        <th class="th-porcent-30 td-left" id="lblTipoMovimiento">--</th>
                                        <th class="th-porcent-10 td-left text-primary">Proveedor:</th>
                                        <th class="th-porcent-30 td-left" id="lblProveedor">--</th>
                                    </tr>
                                    <tr>
                                        <th class="th-porcent-10 td-left text-primary">Fecha y Hora:</th>
                                        <th class="th-porcent-30 td-left" id="lblFechaHora">--</th>
                                        <th class="th-porcent-10 td-left text-primary">Estado:</th>
                                        <th class="th-porcent-30 td-left"><span id="lblEstadoMovimiento">--</span></th>
                                    </tr>
                                    <tr>
                                        <th class="th-porcent-10 td-left text-primary">Observación:</th>
                                        <th class="th-porcent-30 td-left" colspan="2" id="lblObservacion">--</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-12 margin-vertical-5">
                            <button class="btn button-secondary" id="btnCancelarMovimiento">
                                <div class="content-button">
                                    <img src="./image/unable.svg" />
                                    <span>Cancelar</span>
                                </div>
                            </button>
                        </div>
                    </div>


                    <div class="modal-detalle-venta-content-detail padding-10">
                        <table class="table-primary">
                            <thead>
                                <tr>
                                    <th class="th-porcent-5">N°</th>
                                    <th class="th-porcent-35">Descripción</th>
                                    <th class="th-porcent-15">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tbMovimientos">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal del detalle de ingreso -->
        <script>
            let state = false;
            let paginacion = 0;
            let opcion = 0;
            let totalPaginacion = 0;
            let filasPorPagina = 20;

            let tbody = $("#tbList");
            let imgLoad = $("#imgLoad");
            let lblPaginaActual = $("#lblPaginaActual");
            let lblPaginaSiguiente = $("#lblPaginaSiguiente");

            let cbTipoMovimiento = $("#cbTipoMovimiento");
            let txtFechaInicio = $("#txtFechaInicio");
            let txtFechaTermino = $("#txtFechaTermino");

            let lblTipoMovimiento = $("#lblTipoMovimiento");
            let lblFechaHora = $("#lblFechaHora");
            let lblObservacion = $("#lblObservacion");
            let lblProveedor = $("#lblProveedor");
            let lblEstadoMovimiento = $("#lblEstadoMovimiento");
            let lblCodigoVerificacion = $("#lblCodigoVerificacion");
            let tbMovimientos = $("#tbMovimientos");

            let tools = new Tools();

            $(document).ready(function() {
                $("#btnCerrarSession").click(function() {
                    window.location.href = "closesession.php";
                });

                $("#tbList").on("click", "tr", function(event) {
                    $(".selected-table-tr").removeClass("selected-table-tr");
                    $(this).addClass("selected-table-tr");
                });

                document.getElementById("txtFechaInicio").value = tools.getCurrentDate();
                document.getElementById("txtFechaTermino").value = tools.getCurrentDate();

                $("#btnMovimiento").on("click", function() {
                    window.location.href = "movimientoproceso.php";
                });

                $("#btnMovimiento").on("keyup", function(event) {
                    window.location.href = "movimientoproceso.php";
                });

                $("#btnReload").on("click", function() {
                    if (!state) {
                        loadComponents();
                    }
                });

                $("#btnReload").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        if (!state) {
                            loadComponents();
                        }
                    }
                });

                txtFechaInicio.on("change", function() {
                    if (txtFechaInicio.val() !== "" && txtFechaTermino.val() !== "") {
                        if (!state) {
                            paginacion = 1;
                            fillInventarioTable(true, parseInt(cbTipoMovimiento.val()), txtFechaInicio.val(), txtFechaTermino.val());
                            opcion = 1;
                        }
                    }
                });

                txtFechaTermino.on("change", function() {
                    if (txtFechaInicio.val() !== "" && txtFechaTermino.val() !== "") {
                        if (!state) {
                            paginacion = 1;
                            fillInventarioTable(true, parseInt(cbTipoMovimiento.val()), txtFechaInicio.val(), txtFechaTermino.val());
                            opcion = 1;
                        }
                    }
                });

                cbTipoMovimiento.on("change", function() {
                    if (txtFechaInicio.val() !== "" && txtFechaTermino.val() !== "") {
                        if (!state) {
                            paginacion = 1;
                            fillInventarioTable(true, parseInt($(this).children("option:selected").val()), txtFechaInicio.val(), txtFechaTermino.val());
                            opcion = 1;
                        }
                    }
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

                loadComponents();
            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        fillInventarioTable(false, parseInt(cbTipoMovimiento.val()), "", "");
                        break;
                    case 1:
                        fillInventarioTable(true, parseInt(cbTipoMovimiento.val()), txtFechaInicio.val(), txtFechaTermino.val());
                        break;
                }
            }

            function loadComponents() {
                $.get("../app/controller/tipomovimiento/ListarTipoMovimientos.php", {
                    "ajuste": true,
                    "all": "true"
                }, function(data, status) {
                    if (status === "success") {
                        let cbTipoMovimiento = $("#cbTipoMovimiento");
                        let result = data;
                        if (result.estado === 1) {
                            cbTipoMovimiento.empty();
                            cbTipoMovimiento.append('<option value="0">--TODOS--</option>');
                            for (let tipos of result.data) {
                                cbTipoMovimiento.append('<option value="' + tipos.IdTipoMovimiento + '">' + tipos.Nombre + '</option>');
                            }
                            loadInitTable();
                        } else {
                            cbTipoMovimiento.empty();
                        }
                    }
                });
            }

            function loadInitTable() {
                if (!state) {
                    paginacion = 1;
                    fillInventarioTable(false, parseInt(cbTipoMovimiento.val()), "", "");
                    opcion = 0;
                }
            }

            function fillInventarioTable(init, movimiento, fechaInicial, fechaFinal) {
                $.ajax({
                    url: "../app/controller/suministros/ListarMovimiento.php",
                    method: "GET",
                    data: {
                        "init": init,
                        "opcion": 1,
                        "movimiento": movimiento,
                        "fechaInicial": fechaInicial,
                        "fechaFinal": fechaFinal,
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        imgLoad.css({
                            "display": "block"
                        });
                        tbody.empty();
                        state = true;
                    },
                    success: function(result) {
                        let object = JSON.parse(result);
                        if (object.estado === 1) {
                            let movimientos = object.data;
                            for (let moviminento of movimientos) {
                                let estadoStyle = moviminento.Estado === "COMPLETADO" ? "label-asignacion" : moviminento.Estado === "CANCELADO" ? "label-proceso" : moviminento.Estado === "EN PROCESO" ? "label-medio" : "label-asignacion";
                                tbody.append('<tr>' +
                                    '<td data-label="N°" class="td-center">' + moviminento.count + '</td>' +
                                    '<td data-label="Tipo Movimiento" class="td-left">' + (moviminento.TipoAjuste == 0 ? "DECREMENTO" : "INCREMENTO") + '<br>' + moviminento.TipoMovimiento + '</td>' +
                                    '<td data-label="Fecha y Hora" class="td-left">' + tools.getDateForma(moviminento.Fecha) + "</br>" + tools.getTimeForma(moviminento.Hora, true) + '</td>' +
                                    '<td data-label="Observación" class="td-left">' + moviminento.Observacion + '</td>' +
                                    '<td data-label="Información" class="td-left">' + moviminento.Informacion + '</td>' +
                                    '<td data-label="Estado" class="td-center">' + '<div class="' + estadoStyle + '">' + moviminento.Estado + '</div>' + '</td>' +
                                    '<td data-label="Opciones" class="td-center"><button class="btn button-warning" onclick="loadDetalleMovimiento(\'' + moviminento.IdMovimientoInventario + '\')"><div class="content-button"><img src="./image/search.png" /><span>Ver</span></div></button></td>' +
                                    '</tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(object.total) / filasPorPagina)));
                            lblPaginaActual.html(paginacion);
                            lblPaginaSiguiente.html(totalPaginacion);
                            imgLoad.css({
                                "display": "none"
                            });
                            state = false;
                        } else {
                            tbody.append('<tr>Sin datos a mostrar</tr>');
                            imgLoad.css({
                                "display": "none"
                            });
                            state = false;
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        imgLoad.css({
                            "display": "none"
                        });
                        state = false;
                    }
                });
            }

            function loadDetalleMovimiento(idMovimiento) {
                $("#id-modal-productos").css({
                    "display": "flex"
                });
                $.ajax({
                    url: "../app/controller/tipomovimiento/ListarMovimientoPorId.php",
                    method: "GET",
                    data: {
                        idMovimiento: idMovimiento
                    },
                    beforeSend: function() {
                        tbMovimientos.empty();
                        tbMovimientos.append('<tr><td class="td-center" colspan="3">Cargando información...</td></tr>');
                    },
                    success: function(result) {
                        if (result.estado === 1) {
                            tbMovimientos.empty();
                            let movimiento = result.data[0];
                            let movimientoDetalle = result.data[1];

                            lblTipoMovimiento.html(movimiento.TipoMovimiento);
                            lblFechaHora.html(tools.getDateForma(movimiento.Fecha) + " " + tools.getTimeForma(movimiento.Hora, true));
                            lblObservacion.html(movimiento.Observacion);
                            lblProveedor.html(movimiento.Proveedor);
                            //lblEstadoMovimiento.removeClass("block-detail-right");
                            lblEstadoMovimiento.addClass("label-asignacion");
                            lblEstadoMovimiento.html(movimiento.Estado);
                            lblCodigoVerificacion.html(movimiento.CodigoVerificacion);

                            $("#btnCancelarMovimiento").unbind();

                            $("#btnCancelarMovimiento").bind("click", function() {
                                cancelarMovimiento(idMovimiento);
                            });

                            $("#btnCancelarMovimiento").bind("keydown", function(event) {
                                if (event.keyCode === 13) {
                                    cancelarMovimiento(idMovimiento);
                                }
                                event.preventDefault();
                            });

                            for (let md of movimientoDetalle) {
                                tbMovimientos.append('<tr>' +
                                    '<td class="td-center">' + md.Id + '</td>' +
                                    '<td class="td-left">' + md.Clave + '</br>' + md.NombreMarca + '</td>' +
                                    '<td class="td-right">' + tools.formatMoney(md.Cantidad) + '</td>' +
                                    +'</tr>');
                            }
                        } else {
                            tbMovimientos.empty();
                            tbMovimientos.append('<tr><td class="td-center" colspan="3">' + result.mensaje + '</td></tr>');
                        }
                    },
                    error: function(error) {
                        tbMovimientos.empty();
                        tbMovimientos.append('<tr><td class="td-center" colspan="3">Error en cargar la información.</td></tr>');
                    }
                });
            }

            function cancelarMovimiento(idMovimiento) {
                tools.alertConfirmation("Movimiento", "", "¿Está seguro de cancelar el movimiento?", function(value) {
                    if (value == "accept") {
                        $.ajax({
                            url: "../app/controller/tipomovimiento/CancelarMovimiento.php",
                            method: "GET",
                            data: {
                                "idMovimiento": idMovimiento
                            },
                            beforeSend: function() {
                                tools.alertLoad("Movimiento", "Procesando petición");
                            },
                            success: function(result) {
                                if (result.estado === 1) {
                                    tools.alertInformation("Movimiento", result.mensaje);
                                } else if (result.estado === 2) {
                                    tools.alertWarning("Movimiento", result.mensaje);
                                } else {
                                    tools.alertWarning("Movimiento", result.mensaje);
                                }
                            },
                            error: function(error) {
                                tools.alertError("Movimiento", "Error en procesar petición, si el error persiste comuníquese con sus proveedor.");
                            }
                        });
                    } else {
                        $("#idModal").css("display", "none");
                    }
                });

            }
        </script>
    </body>

    </html>
<?php
}
