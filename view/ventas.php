<?php
session_start();

if (!isset($_SESSION['IdEmpleado'])) {
    echo '<script>location.href = "login.php";</script>';
} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">

        <?php include 'layout/head.php'; ?>

        <body class="hold-transition skin-blue sidebar-mini">
            <div class="wrapper">

                <!-- start header -->
                <?php include('./layout/header.php') ?>
                <!-- end header -->
                <!-- start menu -->
                <?php include('./layout/menu.php') ?>
                <!-- end menu -->

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">

                    <section class="content-header">
                        <h3 class="no-margin"> Ventas <small> Lista </small> </h3>
                    </section>

                    <section class="content">
                        <!-- Main content -->

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <h4> Resumen de documentos emitidos</h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group text-primary">
                                    <h4 id="lblTotalVenta">Total de venta por Fecha:&nbsp; S/ 0.00</h4>
                                </div>
                            </div>
                        </div>
                        <!---->

                        <div class="row">
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <img src="./image/sunat_logo.png" width="28" height="28" />
                                    <span class="text-xs">Estados SUNAT:</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">  
                                <div class="form-group">
                                    <img src="./image/accept.svg" width="28" height="28" />
                                    <span class="text-xs">Aceptado</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12"> 
                                <div class="form-group">
                                    <img src="./image/unable.svg" width="28" height="28" />
                                    <span class="text-xs"> Rechazado</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">  
                                <div class="form-group">
                                    <img src="./image/reuse.svg" width="28" height="28" />
                                    <span class="text-xs"> Pendiente de Envío</span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <img src="./image/error.svg" width="28" height="28" />  
                                    <span class="text-xs">Comunicación de Baja (Anulado)</span>
                                </div>
                            </div>
                        </div>
                        <!---->

                        <div class="row">
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>Fecha de Inicio:</label>
                                <div class="form-group">
                                    <input class="form-control" type="date" id="txtFechaInicial" />
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>Fecha de Fin:</label>
                                <div class="form-group">
                                    <input class="form-control" type="date" id="txtFechaFinal" />
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>Opción:</label>
                                <div class="form-group">
                                    <select class="form-control">- Seleccione -</select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label>Procesar:</label>
                                <div class="form-group">
                                    <button class="btn btn-primary">                                  
                                        <i class="fa fa-gg-circle"></i> Envío masivo a sunat                           
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">                      
                               <label>Generar Excel:</label>
                                <div class="form-group">
                                    <button class="btn btn-success" id="btnExcel">                                 
                                        <i class="fa fa-file-excel-o"></i> Excel por Fecha
                                    </button>  
                                </div>
                            </div>                            
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <label>Buscar:</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-danger"><i class="fa  fa-refresh"></i> Recargar </button>
                                        </div>
                                        <input class="form-control" type="text" placeholder="Escribir para filtrar" id="txtSearch" />
                                    </div>                                   
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Paginación:</label>
                                <div class="form-group">
                                    <button class="btn btn-primary" id="btnAnterior">                                    
                                        <i class="fa fa-arrow-circle-left"></i>
                                    </button>
                                    <span class="margin" id="lblPaginaActual">0</span>
                                    <span class="margin">de</span>
                                    <span class="margin" id="lblPaginaSiguiente">0</span>
                                    <button class="btn btn-primary" id="btnSiguiente">                               
                                        <i class="fa fa-arrow-circle-right"></i>                                                          
                                    </button>
                                </div>

                            </div>
                        </div>   

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #007bff;">                                   
                                        <thead  style="background-color: #0766cc;color: white;">
                                            <tr>
                                                <th style="width:5%;">#</th>
                                                <th style="width:15%;">Opciones</th>
                                                <th style="width:10%;">Fecha</th>
                                                <th style="width:10%;">Comprobante</th>
                                                <th style="width:15%;">Cliente</th>
                                                <th style="width:10%;">Estado</th>
                                                <th style="width:10%;">Total</th>
                                                <th style="width:10%;">Estado SUNAT</th>
                                                <th style="width:20%;">Observación SUNAT</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbList">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </section>
                    <!--
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
                                                 <button id="btnAccept" class="btn button-primary margin-horizontal-5" type="button">
                                                    <div class="content-button">
                                                        <img src="./image/ok.svg" />
                                                        <span>Facturados</span>
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
                            </div>-->

                    <!-- Modal del detalle de ingreso -->
                    <!--        <div class="modal-detalle-venta" id="id-modal-productos">
                                <div class="modal-detalle-venta-content">
                                    <div class="modal-detalle-venta-content-body padding-10">
                    
                                        <div class="modal-detalle-venta-content-header center-row">
                                            <h4>Detalle del Ingreso</h4>
                                            <div class="productos-btn-close">
                                                <button class="btn button-secondary" id="btnCloseModal">
                                                    <div class="content-button">
                                                        <span>X</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                    
                                        <div class="row">
                                            <table class="table-secundary">
                                                <thead>
                                                    <tr>
                                                        <th class="th-porcent-20 td-left">Comprobante:</th>
                                                        <th class="th-porcent-30 td-left" id="thComprobante">--</th>
                                                        <th class="th-porcent-20 td-left">Cliente:</th>
                                                        <th class="th-porcent-30 td-left" id="thCliente">--</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="th-porcent-20 td-left">Fecha y Hora:</th>
                                                        <th class="th-porcent-30 td-left" id="thFechaHora">--</th>
                                                        <th class="th-porcent-20 td-left">Estado:</th>
                                                        <th class="th-porcent-30 td-left" id="thEstado">--</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="th-porcent-20 td-left">Total:</th>
                                                        <th class="th-porcent-30 td-left" id="thTotal">--</th>
                                                    </tr>
                                                </thead>
                                            </table>
                    
                                             <div class="modal-productos-content-detail-left">
                                                    <div class="block-detail">
                                                        <span class="block-detail-left">Tipo de Movimiento:</span>
                                                        <span class="block-detail-right" id="lblTipoMovimiento">--</span>
                                                    </div>
                                                    <div class="block-detail">
                                                        <span class="block-detail-left">Fecha y Hora:</span>
                                                        <span class="block-detail-right" id="lblFechaHora">--</span>
                                                    </div>
                                                    <div class="block-detail">
                                                        <span class="block-detail-left">Observación:</span>
                                                        <span class="block-detail-right" id="lblObservacion">--</span>
                                                    </div>
                                                </div>
                                                <div class="modal-productos-content-detail-right">
                                                    <div class="block-detail">
                                                        <span class="block-detail-left">Cliente:</span>
                                                        <span class="block-detail-right" id="lblProveedor">--</span>
                                                    </div>
                                                    <div class="block-detail">
                                                        <span class="block-detail-left">Estado del Ingreso:</span>
                                                        <span class="block-detail-right" id="lblEstadoMovimiento">--</span>
                                                    </div>
                                                </div> 
                                        </div>
                    
                                        <div class="modal-detalle-venta-content-detail">
                                            <table class="table-primary">
                                                <thead>
                                                    <tr>
                                                        <th class="th-porcent-5">N°</th>
                                                        <th class="th-porcent-30">Descripción</th>
                                                        <th class="th-porcent-15">Cantidad</th>
                                                        <th class="th-porcent-15">Precio</th>
                                                        <th class="th-porcent-15">Descuento</th>
                                                        <th class="th-porcent-15">Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbIngresosDetalle">
                    
                                                </tbody>
                                            </table>
                                        </div>
                    
                                    </div>
                                </div>
                            </div>-->
                    <!-- Modal del detalle de ingreso -->
                </div> 
            </div>  

            <script>
                let state = false;
                let paginacion = 0;
                let opcion = 0;
                let totalPaginacion = 0;
                let filasPorPagina = 20;
                let tools = new Tools();

                let tbody = $("#tbList");

                $(document).ready(function () {

                    document.getElementById("txtFechaInicial").value = tools.getCurrentDate();
                    document.getElementById("txtFechaFinal").value = tools.getCurrentDate();

                    $("#tbList").on("click", "tr", function (event) {
                        $(".selected-table-tr").removeClass("selected-table-tr");
                        $(this).addClass("selected-table-tr");
                    });

                    loadInitVentas();

                    $("#txtFechaInicial").on("change", function () {
                        var fechaInicial = $("#txtFechaInicial").val();
                        var fechaFinal = $("#txtFechaFinal").val();
                        //var idEmpleado = $("#idEmpleado").val();
                        if (!state) {
                            paginacion = 1;
                            fillVentasTable(3, "", fechaInicial, fechaFinal, '');
                            opcion = 0;
                        }
                    });

                    $("#txtFechaFinal").on("change", function () {
                        var fechaInicial = $("#txtFechaInicial").val();
                        var fechaFinal = $("#txtFechaFinal").val();
                        //var idEmpleado = $("#idEmpleado").val();
                        if (!state) {
                            paginacion = 1;
                            fillVentasTable(3, "", fechaInicial, fechaFinal, '');
                            opcion = 0;
                        }
                    });

                    $("#btnCerrarSession").click(function () {
                        window.location.href = "closesession.php";
                    });

                    $("#txtSearch").on("keyup", function () {
                        let value = $("#txtSearch").val();
                        //var idEmpleado = $("#idEmpleado").val();
                        if (!state) {
                            paginacion = 1;
                            fillVentasTable(2, value.trim(), "", "", '');
                            opcion = 1;
                        }
                    });

                    $("#btnAnterior").click(function () {
                        if (!state) {
                            if (paginacion > 1) {
                                paginacion--;
                                onEventPaginacion();
                            }
                        }
                    });

                    $("#btnSiguiente").click(function () {
                        if (!state) {
                            if (paginacion < totalPaginacion) {
                                paginacion++;
                                onEventPaginacion();
                            }
                        }
                    });

                    $("#btnReload").click(function () {
                        loadInitVentas();
                    });

                    $("#btnExcel").on("click", function () {
                        openExcel();
                    });

                    $("#btnExcel").on("keyup", function (event) {
                        if (event.keyCode === 13) {
                            openExcel();
                        }
                    });

                    $("#btnCloseModal").on("click", function (event) {
                        $("#id-modal-productos").css({
                            "display": "none"
                        });
                    });

                    $("#btnCloseModal").on("keyup", function (event) {
                        if (event.keyCode === 13) {
                            $("#id-modal-productos").css({
                                "display": "none"
                            });
                        }
                    });

                });

                function onEventPaginacion() {
                    let fechaInicial = $("#txtFechaInicial").val();
                    let fechaFinal = $("#txtFechaFinal").val();
                    //let idEmpleado = $("#idEmpleado").val();
                    let value = $("#txtSearch").val();
                    switch (opcion) {
                        case 0:
                            fillVentasTable(3, "", fechaInicial, fechaFinal, '');
                            break;
                        case 1:
                            fillVentasTable(2, value.trim(), "", "", '');
                            break;
                    }
                }

                function loadInitVentas() {
                    let fechaInicial = $("#txtFechaInicial").val();
                    let fechaFinal = $("#txtFechaFinal").val();
                    //var idEmpleado = $("#idEmpleado").val();
                    if (fechaInicial !== "" && fechaInicial !== undefined && fechaFinal !== "" && fechaFinal !== undefined) {
                        if (!state) {
                            paginacion = 1;
                            fillVentasTable(3, "", fechaInicial, fechaFinal, '');
                            opcion = 0;
                        }
                    }
                }

                function fillVentasTable(opcion, busqueda, fechaInicial, fechaFinal, empleado) {
                    $.ajax({
                        url: "../app/controller/ventas/ListarVentas.php",
                        method: "GET",
                        data: {
                            "type": "venta",
                            "opcion": opcion,
                            "busqueda": busqueda,
                            "fechaInicial": fechaInicial,
                            "fechaFinal": fechaFinal,
                            "empleado": empleado,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function () {
                            tbody.empty();
                            state = true;
                        },
                        success: function (result) {
                            let object = result;
                            if (object.estado === 1) {
                                let ventas = object.data;
                                let lblPaginaActual = $("#lblPaginaActual");
                                let lblPaginaSiguiente = $("#lblPaginaSiguiente");
                                let lblTotalVenta = $("#lblTotalVenta");

                                for (let venta of ventas) {

                                    let opciones = '<button class="btn btn-default"><img src="./image/pdf.svg" width="30" /> </button><button class="btn btn-default" onclick="opeModalDetalleIngreso(\'' + venta.IdVenta + '\')"><img src="./image/file.svg" width="30" /></button>';
                                    let datetime = tools.getDateForma(venta.FechaVenta) + "<br>" + tools.getTimeForma(venta.HoraVenta, true);
                                    let comprobante = venta.Comprobante + " <br/>" + (venta.Serie + "-" + venta.Numeracion);
                                    let cliente = venta.DocumentoCliente + "<br>" + venta.Cliente;
                                    let estado = '<div class="' + (venta.Estado == "PENDIENTE" ? "label-medio" : venta.Estado == "ANULADO" ? "label-proceso" : "label-asignacion") + '">' + venta.Estado + '</div>';
                                    let total = venta.Simbolo + " " + tools.formatMoney(venta.Total);

                                    let estadosunat = venta.Estado == "ANULADO" ? (venta.Xmlsunat === "" ?
                                            '<button class="btn btn-default" onclick="resumenDiarioXml(\'' + venta.IdVenta + '\',\'' + venta.Serie + "-" + venta.Numeracion + '\',\'' + tools.getDateYYMMDD(venta.FechaVenta) + '\')"><img src="./image/reuse.svg" width="30" /></button>' :
                                            '<button class="btn btn-default"><img src="./image/error.svg" width="30" /></button>') :
                                            (venta.Xmlsunat === "" ?
                                                    '<button class="btn btn-default" onclick="firmarXml(\'' + venta.IdVenta + '\')">' +
                                                    '<img src="./image/reuse.svg" width="30"/></button>' : venta.Xmlsunat === "0" ?
                                                    '<button class="btn btn-default"><img src="./image/accept.svg" width="30" /></button>' :
                                                    '<button class="btn btn-default" onclick="firmarXml(\'' + venta.IdVenta + '\')"><img src="./image/unable.svg" width="30" /></button>'
                                                    );


                                    let descripcion = '<p class="recortar-texto">' + (venta.Xmldescripcion === "" ? "Por Generar Xml" : venta.Xmldescripcion) + '</p>';
                                    tbody.append('<tr>' +
                                            ' <td class="td-center">' + venta.id + '</td >' +
                                            ' <td>' + opciones + '</td>' +
                                            ' <td class="td-left">' + datetime + '</td>' +
                                            ' <td class="td-left">' + comprobante + '</td>' +
                                            ' <td>' + cliente + '</td>' +
                                            ' <td>' + estado + '</td>' +
                                            ' <td class="td-right">' + total + '</td>' +
                                            ' <td class="td-center">' + estadosunat + '</td>' +
                                            ' <td class="td-left">' + descripcion + '</td>' +
                                            '</tr >');
                                }

                                totalPaginacion = parseInt(Math.ceil((parseFloat(object.total) / filasPorPagina)));
                                lblPaginaActual.html(paginacion);
                                lblPaginaSiguiente.html(totalPaginacion);
                                lblTotalVenta.html("Total de venta por Fecha:&nbsp; S/ " + tools.formatMoney(parseFloat(object.suma)));
                                state = false;
                            } else {
                                tbody.empty();
                                lblPaginaActual.html(0);
                                lblPaginaSiguiente.html(0);
                                tbody.append('<tr>Sin datos a mostrar</tr>');
                                lblTotalVenta.html("S/ " + tools.formatMoney(parseFloat(0)));
                                state = false;
                            }
                        },
                        error: function (error) {
                            tbody.empty();
                            lblPaginaActual.html(0);
                            lblPaginaSiguiente.html(0);
                            tbody.append('<tr>Sin datos a mostrar</tr>');
                            lblTotalVenta.html("S/ " + tools.formatMoney(parseFloat(0)));
                            state = false;
                        }
                    });
                }

                function opeModalDetalleIngreso(idVenta) {
                    $("#id-modal-productos").css({
                        "display": "block"
                    });
                    let thComprobante = $("#thComprobante");
                    let thCliente = $("#thCliente");
                    let thFechaHora = $("#thFechaHora");
                    let thEstado = $("#thEstado");
                    let thTotal = $("#thTotal");
                    let tbIngresosDetalle = $("#tbIngresosDetalle");
                    $.ajax({
                        url: "./sunat/ventas/ListarVentas.php",
                        method: "GET",
                        data: {
                            "type": "allventa",
                            idVenta: idVenta
                        },
                        beforeSend: function () {
                            tbIngresosDetalle.empty();
                        },
                        success: function (result) {
                            let object = result;
                            if (object.estado == 1) {
                                let venta = object.venta;
                                thComprobante.html(venta.Serie + "-" + venta.Numeracion);
                                thCliente.html(venta.NumeroDocumento + " - " + venta.Informacion);
                                thFechaHora.html(tools.getDateForma(venta.FechaVenta) + " - " + tools.getTimeForma(venta.HoraVenta, true));
                                thEstado.html(venta.Estado);
                                thEstado.css({
                                    "color": (venta.Estado == "ANULADO" ? "red" : "#006ac1")
                                });
                                let detalleventa = object.ventadetalle;
                                let total = 0;
                                for (let venta of detalleventa) {
                                    let num = venta.id;
                                    let descripcion = venta.NombreMarca;
                                    let cantidad = venta.Cantidad;
                                    let precio = venta.PrecioVenta;
                                    let descuento = venta.Descuento;
                                    let importe = venta.Importe;

                                    tbIngresosDetalle.append('<tr>' +
                                            '<td>' + num + '</td>' +
                                            '<td class="td-left">' + descripcion + '</td>' +
                                            '<td>' + tools.formatMoney(cantidad) + '</td>' +
                                            '<td>' + tools.formatMoney(precio) + '</td>' +
                                            '<td>' + tools.formatMoney(descuento) + '</td>' +
                                            '<td>' + tools.formatMoney(importe) + '</td>' +
                                            '</tr>');
                                    total += parseFloat(importe);
                                }
                                thTotal.html(venta.Simbolo + " " + tools.formatMoney(total));
                            } else {

                            }
                        },
                        error: function (error) {
                            tbIngresosDetalle.empty();
                        }
                    });
                }

                function firmarXml(idventa, serie, numeracion, tipocomprobante, nombremoneda, tipomoneda) {
                    $.ajax({
                        url: "../app/examples/boleta.php",
                        method: "GET",
                        data: {
                            idventa: idventa,
                            serie: serie,
                            numeracion: numeracion,
                            tipocomprobante: tipocomprobante,
                            nombremoneda: nombremoneda,
                            tipomoneda: tipomoneda
                        },
                        beforeSend: function () {
                            tools.alertLoad("Ventas", "Firmando xml y enviando a la sunat.");
                        },
                        success: function (result) {
                            let object = result;
                            if (object.state === true) {
                                if (object.accept === true) {
                                    tools.alertInformation("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                    onEventPaginacion();
                                } else {
                                    tools.alertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                }
                            } else {
                                tools.alertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                            }
                        },
                        error: function (error) {
                            tools.alertError("Ventas",
                                    "Error en el momento de firmar el xml, intente nuevamente o comuníquese con su proveedor del sistema."
                                    );
                        }
                    });
                }

                function resumenDiarioXml(idventa, comprobante, resumen) {
                    tools.alertConfirmation("Ventas", "¿Realmente Deseas Anular el Documento?", "Se anulará el documento: " + comprobante + ", y se creará el siguiente resumen individual: RC-" + resumen + "-1, estás seguro de anular el documento? los cambios no se podrán revertir!", function (result) {
                        if (result === "close") {
                            $("#idModal").css("display", "none");
                        } else {
                            $.ajax({
                                url: "../app/examples/resumen.php",
                                method: "GET",
                                data: {
                                    idventa: idventa
                                },
                                beforeSend: function () {
                                    alert.alertLoad("Ventas", "Firmando xml y enviando a la sunat.");
                                },
                                success: function (result) {
                                    let object = result;
                                    if (object.state === true) {
                                        if (object.accept === true) {
                                            alert.alertInformation("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                            //onEventPaginacion();
                                        } else {
                                            alert.alertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                        }
                                    } else {
                                        alert.alertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                    }
                                },
                                error: function (error) {
                                    alert.alertError("Ventas",
                                            "Error en el momento de firmar el xml, intente nuevamente o comuníquese con su proveedor del sistema."
                                            );
                                }
                            });
                        }
                    });
                }


                function openPdf(value) {

                }

                function openExcel() {
                    tools.alertConfirmation("Ventas", "", "¿Generar el excel con todos los comprobante o solo los facturados?", function (result) {
                        if (result === "close") {
                            $("#idModal").css("display", "none");
                        } else {
                            let fechaInicial = $("#txtFechaInicial").val();
                            let fechaFinal = $("#txtFechaFinal").val();
                            if (fechaInicial !== "" && fechaInicial !== undefined && fechaFinal !== "" && fechaFinal !== undefined) {
                                window.open("../app/sunat/excelventa.php?txtFechaInicial=" + fechaInicial + "&txtFechaFinal=" + fechaFinal, "_blank");
                            }
                        }
                    });

                }

                // function generarXml(idventa, serie, numeracion, fecha, hora, tipodocumento, monedaletras, monedaabreviatura) {
                //     $.ajax({
                //         url: "./sunat/crearxml.php",
                //         method: "GET",
                //         data: {
                //             idventa: idventa,
                //             serie: serie,
                //             numeracion: numeracion,
                //             fecha: fecha,
                //             hora: hora,
                //             tipodocumento: tipodocumento,
                //             monedaletras: monedaletras,
                //             monedaabreviatura: monedaabreviatura
                //         },
                //         beforeSend: function() {
                //             alertLoad("Ventas", "Generando xml, espere por favor.");
                //         },
                //         success: function(result) {
                //             let object = result;
                //             if (object.estado == 1) {
                //                 alertInformation("ventas", object.message, function() {
                //                     $("#idModal").css("display", "none");
                //                 });
                //                 onEventPaginacion();
                //             } else {
                //                 alertWarning("ventas", object.message + ": " + object.error);
                //             }
                //         },
                //         error: function(error) {
                //             alertError("Ventas",
                //                 "Error en el momento de crear el xml, intente nuevamente o comuníquese con su proveedor del sistema."
                //             );
                //         }
                //     });
                // }
            </script>
        </body>

    </html>
    <?php
}
