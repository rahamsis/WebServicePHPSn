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
                                    <span class="text-md-bold">Inventario General</span>
                                    <img src="./image/loading.gif" id="imgLoad" width="28" height="28" />
                                </div>
                            </section>

                            <section class="row row-reverse center-row border-bottom">
                                <button class="btn button-secondary margin-10" id="btnReload">
                                    <div class="content-button">
                                        <img src="./image/reload.png" />
                                        <span>Recargar</span>
                                    </div>
                                </button>
                                <!-- <button class="btn button-secondary margin-10">
                                    <div class="content-button">
                                        <img src="./image/complete.png" />
                                        <span>Reporte</span>
                                    </div>
                                </button> -->
                            </section>

                            <section class="row row-reverse border-bottom center-row">
                                <div class="col-md-3 padding-10">
                                    <input type="text" placeholder="Ingrese la clave o clave alterna" class="input-primary " id="txtClaveProducto">
                                </div>
                                <div class="col-md-5 padding-10">
                                    <input type="text" placeholder="Ingrese la descripción del producto" class="input-primary" id="txtDescripcionProducto">
                                </div>
                                <div class="col-md-4 right-col padding-10">
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
                            </section>

                            <div class="row padding-10">
                                <table class="table-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="th-porcent-5">N°</th>
                                            <th scope="col" class="th-porcent-30">Descripción</th>
                                            <th scope="col" class="th-porcent-10">Categoría</th>
                                            <th scope="col" class="th-porcent-10">Marca</th>
                                            <th scope="col" class="th-porcent-15">Cantidad</th>
                                            <th scope="col" class="th-porcent-10">Inv.Min / Inv.Max</th>
                                            <th scope="col" class="th-porcent-10">Inventario</th>
                                            <th scope="col" class="th-porcent-10">Estado</th>
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
      
        <script>
            let state = false;
            let paginacion = 0;
            let opcion = 0;
            let totalPaginacion = 0;
            let filasPorPagina = 20;

            let tools = new Tools();

            let txtClaveProducto = $("#txtClaveProducto");
            let txtDescripcionProducto = $("#txtDescripcionProducto");

            $(document).ready(function() {
                $("#btnCerrarSession").click(function() {
                    window.location.href = "closesession.php";
                });

                loadInitInventario();

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

                $("#btnReload").on("click", function(event) {
                    loadInitInventario();
                });

                $("#btnReload").on("keydown", function(event) {
                    if (event.keyCode === 13) {
                        loadInitInventario();
                    }
                });

                txtClaveProducto.on("keyup", function() {
                    if (!state) {
                        paginacion = 1;
                        fillInventarioTable(txtClaveProducto.val(), "", 1);
                        opcion = 1;
                    }
                });

                txtDescripcionProducto.on("keyup", function() {
                    if (!state) {
                        paginacion = 1;
                        fillInventarioTable("", txtDescripcionProducto.val(), 2);
                        opcion = 2;
                    }
                });

                $("#tbList").on("click", "tr", function(event) {
                    $(".selected-table-tr").removeClass("selected-table-tr");
                    $(this).addClass("selected-table-tr");
                });

            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        fillInventarioTable("", "", 0);
                        break;
                    case 1:
                        fillInventarioTable(txtClaveProducto.val(), "", 1);
                        break;
                    case 2:
                        fillInventarioTable("", txtDescripcionProducto.val(), 2);
                        break;
                }
            }

            function loadInitInventario() {
                if (!state) {
                    paginacion = 1;
                    fillInventarioTable("", "", 0);
                    opcion = 0;
                }
            }

            function fillInventarioTable(producto, nombre, opcion) {
                let tbody = $("#tbList");
                let imgLoad = $("#imgLoad");

                $.ajax({
                    url: "../app/controller/suministros/ListarInventario.php",
                    method: "GET",
                    data: {
                        "producto": producto,
                        "existencia": 0,
                        "nombre": nombre,
                        "opcion": opcion,
                        "categoria": 0,
                        "marca": 0,
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
                            let suministros = object.data;
                            let lblPaginaActual = $("#lblPaginaActual");
                            let lblPaginaSiguiente = $("#lblPaginaSiguiente");
                            for (let suministro of suministros) {
                                tbody.append('<tr>' +
                                    '<td data-label="N°" class="td-center">' + suministro.count + '</td>' +
                                    '<td data-label="Descripción" class="td-left">' + suministro.Clave + (suministro.ClaveAlterna === "" ? "" : "-" + suministro.ClaveAlterna) + "</br>" + suministro.NombreMarca + '</td>' +
                                    '<td data-label="Categoría" class="td-left">' + suministro.Categoria + '</td>' +
                                    '<td data-label="Marca" class="td-left">' + suministro.Marca + '</td>' +
                                    '<td data-label="Cantidad" class="td-right ' + (suministro.Cantidad <= 0 ? "text-danger " : "text-success") + '">' +
                                    tools.formatMoney(suministro.Cantidad) + " " + suministro.UnidadCompra +
                                    '</td>' +
                                    //                                            '<td data-label="Costo General" class="td-right">' + formatMoney(suministro.PrecioCompra) + '</td>' +
                                    //                                            '<td data-label="Precio General" class="td-right">' + formatMoney(suministro.PrecioVentaGeneral) + '</td>' +
                                    '<td data-label="Inv.Min / Inv.Max" class="td-right">' + (tools.formatMoney(suministro.StockMinimo) + " - " + tools.formatMoney(suministro.StockMaximo)) + '</td>' +
                                    '<td data-label="Estado" class="td-center">' + (suministro.Inventario === "1" ? "Si" : "No") + '</td>' +
                                    '<td data-label="Estado" class="td-center">' + (suministro.Estado === "1" ? "Activo" : "Inactivo") + '</td>' +
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
                            lblPaginaActual.html(0);
                            lblPaginaSiguiente.html(0);
                            tbody.append('<tr>Sin datos a mostrar</tr>');
                            imgLoad.css({
                                "display": "none"
                            });
                            state = false;
                        }
                    },
                    error: function(error) {
                        lblPaginaActual.html(0);
                        lblPaginaSiguiente.html(0);
                        imgLoad.css({
                            "display": "none"
                        });
                        state = false;
                    }
                });
            }
        </script>
    </body>

    </html>
<?php
}
