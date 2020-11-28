<?php
session_start();

if (!isset($_SESSION['IdEmpleado'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <?php include './layout/head.php'; ?>
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            <div class="wrapper">

                <!-- start header -->
                <?php include('./layout/header.php') ?>
                <!-- end header -->
                <!-- start menu -->
                <?php include('./layout/menu.php') ?>
                <!-- end menu -->

                <div class="content-wrapper" style="background-color: #FFFFFF;">

                    <section class="content-header">
                        <h1><font _mstmutation="1" _msthash="824720" _msttexthash="94224"> Dashboard </font><small _msthash="1230957" _msttexthash="261833">Panel de control</small>
                        </h1>
                    </section>

                    <!-- Main content -->
                    <div class="content">                                                                                        

                        <div class="row">
                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <!--<div id="lblNumeroVentas"></div>-->
                                        <h3 id="lblTotalVentas">S/ 0.00</h3>
                                        <p>Ventas</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="#" class="small-box-footer"><font _mstmutation="1" _msthash="1728272" _msttexthash="305162">Más información </font><i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <!--<div id="lblNumeroVentasAnuladas"></div>-->
                                        <!--<div id="lblTotalVentasAnuladas"></div>-->
                                        <h3 id="lblTotalVentasAnuladas">S/ 0.00</h3>
                                        <p>Ventas Anuladas</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer"><font _mstmutation="1" _msthash="1731860" _msttexthash="305162">Más información </font><i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <!--                                         <div id="lblNumeroCompras"></div>
                                                                                                            <div id="lblTotalCompras">-->
                                        <h3><font id="lblTotalCompras">S/ 0.00</font></h3>

                                        <p _msthash="2129751" _msttexthash="202969">Compras</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer"><font _mstmutation="1" _msthash="1729468" _msttexthash="305162">Más información </font><i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3 _msthash="2165566" _msttexthash="10140">S/ 0.00</h3>
                                        <p _msthash="2130947" _msttexthash="431912">Gastos</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="#" class="small-box-footer"><font _mstmutation="1" _msthash="1730664" _msttexthash="305162">Más información </font><i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title" _msthash="2163538" _msttexthash="577746">Informe de resumen mensual</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p class="text-center">
                                                    <strong _msthash="3030235" _msttexthash="484380">Ventas: 1 ene, 2014 - 30 jul, 2014</strong>
                                                </p>

                                                <div class="chart">
                                                    <!-- Sales Chart Canvas -->
                                                    <canvas id="salesChart" style="height: 180px; width: 542px;" height="180" width="542"></canvas>
                                                </div>
                                                <!-- /.chart-responsive -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-4">
                                                <p class="text-center">
                                                    <strong _msthash="3032055" _msttexthash="604318">Finalización de objetivos</strong>
                                                </p>

                                                <div class="progress-group">
                                                    <span class="progress-text" _msthash="3237416" _msttexthash="634413">Añadir productos al carrito</span>
                                                    <span class="progress-number" _msthash="3883854" _msttexthash="44551"><b>160</b>/200</span>

                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                                                    </div>
                                                </div>
                                                <!-- /.progress-group -->
                                                <div class="progress-group">
                                                    <span class="progress-text" _msthash="3239392" _msttexthash="259246">Compra completa</span>
                                                    <span class="progress-number" _msthash="3885830" _msttexthash="44499"><b>310</b>/400</span>

                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                                                    </div>
                                                </div>
                                                <!-- /.progress-group -->
                                                <div class="progress-group">
                                                    <span class="progress-text" _msthash="3241368" _msttexthash="512421">Visita la página Premium</span>
                                                    <span class="progress-number" _msthash="3887806" _msttexthash="45890"><b>480</b>/800</span>

                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                                                    </div>
                                                </div>
                                                <!-- /.progress-group -->
                                                <div class="progress-group">
                                                    <span class="progress-text" _msthash="3243344" _msttexthash="295529">Enviar consultas</span>
                                                    <span class="progress-number" _msthash="3889782" _msttexthash="44967"><b>250</b>/500</span>

                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                                                    </div>
                                                </div>
                                                <!-- /.progress-group -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- ./box-body -->
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-sm-3 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i><font _mstmutation="1" _msthash="3880396" _msttexthash="14508"> 17%</font></span>
                                                    <h5 class="description-header" _msthash="3590548" _msttexthash="72527">$35,210.43</h5>
                                                    <span class="description-text" _msthash="3236116" _msttexthash="210951">INGRESOS TOTALES</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-3 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i><font _mstmutation="1" _msthash="3882216" _msttexthash="8216"> 0%</font></span>
                                                    <h5 class="description-header" _msthash="3592368" _msttexthash="73476">$10,390.90</h5>
                                                    <span class="description-text" _msthash="3237936" _msttexthash="116467">COSTO TOTAL</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-3 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i><font _mstmutation="1" _msthash="3884036" _msttexthash="13871"> 20%</font></span>
                                                    <h5 class="description-header" _msthash="3594188" _msttexthash="73866">$24,813.53</h5>
                                                    <span class="description-text" _msthash="3239756" _msttexthash="183092">BENEFICIO TOTAL</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-3 col-xs-6">
                                                <div class="description-block">
                                                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i><font _mstmutation="1" _msthash="3885856" _msttexthash="14612"> 18%</font></span>
                                                    <h5 class="description-header" _msthash="3596008" _msttexthash="21515">1200</h5>
                                                    <span class="description-text" _msthash="3241576" _msttexthash="466037">FINALIZACIONES DE OBJETIVOS</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.box-footer -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
                        </div>

                        <!--                        <div class="row">                           
                        
                                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <h4>
                                                                        INGRESOS / GASTOS DEL DÍA
                                                                    </h4>                                    
                                                                </div>                               
                                                            </div>                                    
                                                        </div>
                        
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <img src="./image/shop.png" alt="">
                                                                <div id="lblTotalVenta">S/ 0.00</div>
                                                                <div>UTILIDAD BRUTA SEMANAL</div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button class="btn btn-primary" id="btnSemana">semana</button>
                                                                <button class="btn btn-default" id="btnMes">meses</button>
                                                            </div>
                        
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div id="diagrama-linea"></div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div id="diagrama-linea-Mes"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="col-md-4 col-sm-12 col-xs-12">                         
                                                        <div class="form-group"><h4>Productos Más Vendidos del Mes y Día</h4></div>
                                                        <div id="tvProductos" style="overflow-y:auto">                                  
                        
                                                        </div>                           
                                                    </div>
                        
                                                </div>-->

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title" _msthash="2213159" _msttexthash="921323">Productos Más Vendidos del Mes y Día</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <ul id="tvProductos" class="products-list product-list-in-box">
                                        </ul>
                                    </div>
                                    <!-- /.box-body -->
                                    <!--                                    <div class="box-footer text-center">
                                                                            <a href="javascript:void(0)" class="uppercase" _msthash="1940926" _msttexthash="472199">Ver todos los productos</a>
                                                                        </div>-->
                                    <!-- /.box-footer -->
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title" _msthash="2213159" _msttexthash="921323">Estado de Productos</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <button class="btn button-primary" id="btnPrdAgotados">
                                                Productos Agotados
                                            </button>
                                            <button class="btn button-secondary" id="btnPrdPorAgotarse">
                                                Productos Por Agotarse
                                            </button>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-md-12 col-sm-12 col-xs-12" id="tvProductoAgotado">

                                            </div>
                                            <div class="row"> 
                                                <div id="tvProductoPorAgotarse">    
                                                    <div class="col-md-12 col-sm-12 col-xs-12" id="tvProductoPorAgotarse">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>     
                    </div>
                </div>
                <?php include('./layout/footer.php') ?>
            </div>
            <script>
                let tools = new Tools();
                let buttonSelected = false;
                let buttonAgotadosSelected = false;
                $(document).ready(function () {

                    $("#btnCerrarSession").click(function () {
                        window.location.href = "./closesession.php";
                    });
                    //botones del diagrama de lineas
                    $("#btnSemana").removeClass();
                    $("#btnSemana").addClass("btn btn-primary");
                    $("#diagrama-linea").css({
                        "display": "block"
                    });
                    $("#diagrama-linea-Mes").css({
                        "display": "none"
                    });
                    $("#btnSemana").click(function (event) {
                        buttonSelected = true;
                        if (buttonSelected) {
                            $("#btnSemana").removeClass();
                            $("#btnSemana").addClass("btn btn-primary");
                            $("#btnMes").removeClass();
                            $("#btnMes").addClass("btn btn-default");
                            $("#diagrama-linea").empty();
                            $("#diagrama-linea").css({
                                "display": "block"
                            });
                            $("#diagrama-linea-Mes").css({
                                "display": "none"
                            });
                            loadDiagramaDeLineas("semana");
                        }
                    });
                    $("#btnMes").click(function (event) {
                        buttonSelected = false;
                        if (!buttonSelected) {
                            $("#btnMes").removeClass();
                            $("#btnMes").addClass("btn btn-primary");
                            $("#btnSemana").removeClass();
                            $("#btnSemana").addClass("btn btn-default");
                            $("#diagrama-linea-Mes").empty();
                            $("#diagrama-linea-Mes").css({
                                "display": "block"
                            });
                            $("#diagrama-linea").css({
                                "display": "none"
                            });
                            loadDiagramaDeLineas("mes");
                        }
                    });
                    //botones de Productos por agotarse
                    $("#btnPrdAgotados").removeClass();
                    $("#btnPrdAgotados").addClass("btn btn-primary");
                    $("#tvProductoAgotado").css({
                        "display": "block"
                    });
                    $("#tvProductoPorAgotarse").css({
                        "display": "none"
                    });
                    $("#btnPrdAgotados").click(function (event) {
                        buttonAgotadosSelected = true;
                        if (buttonAgotadosSelected) {
                            $("#btnPrdAgotados").removeClass();
                            $("#btnPrdAgotados").addClass("btn btn-primary");
                            $("#btnPrdPorAgotarse").removeClass();
                            $("#btnPrdPorAgotarse").addClass("btn btn-default");
                            $("#tvProductoAgotado").css({
                                "display": "block"
                            });
                            $("#tvProductoPorAgotarse").css({
                                "display": "none"
                            });
                        }
                    });
                    $("#btnPrdPorAgotarse").click(function (event) {
                        buttonAgotadosSelected = false;
                        if (!buttonAgotadosSelected) {
                            $("#btnPrdPorAgotarse").removeClass();
                            $("#btnPrdPorAgotarse").addClass("btn btn-primary");
                            $("#btnPrdAgotados").removeClass();
                            $("#btnPrdAgotados").addClass("btn btn-default");
                            $("#tvProductoPorAgotarse").css({
                                "display": "block"
                            });
                            $("#tvProductoAgotado").css({
                                "display": "none"
                            });
                        }
                    });
                    cargarDashboard();
                });
                function cargarDashboard() {
                    let numeroVentas = $("#lblNumeroVentas");
                    let totalVentas = $("#lblTotalVentas");
                    let numeroVentasAnuladas = $("#lblNumeroVentasAnuladas");
                    let totalVentasAnuladas = $("#lblTotalVentasAnuladas");
                    let numeroCompras = $('#lblNumeroCompras');
                    let totalCompras = $('#lblTotalCompras');
                    let productoVendidos = $("#tvProductos");
                    let productoAgotado = $("#tvProductoAgotado");
                    let productosPorAgotarse = $("#tvProductoPorAgotarse");
                    $.ajax({
                        url: "../app/controller/ventas/CargarDashboard.php",
                        method: "GET",
                        data: {
                            fechaActual: tools.getCurrentDate()
                        },
                        beforeSend: function () {
                            productoVendidos.empty();
                        },
                        success: function (result) {
                            console.log(result)
                            numeroVentas.html(result.data[0].numeroVentas);
                            totalVentas.html("S/  " + tools.formatMoney(result.data[0].TotalVentas));
                            numeroVentasAnuladas.html(result.data[0].NumeroVentasAnuladas);
                            totalVentasAnuladas.html("S/  " + tools.formatMoney(result.data[0].TotalVentasAnuladas));
                            numeroCompras.html(result.data[0].NumeroCompras);
                            totalCompras.html("S/  " + tools.formatMoney(result.data[0].TotalCompras));
                            let productosVendidos = result.data[0].ProductosMasVendidos;
                            for (let data of productosVendidos) {
                                let image = "./image/noimage.jpg";
                                if (data.Imagen != '') {
                                    image = ("data:image/png;base64," + data.Imagen);
                                }


                                productoVendidos.append('<li class="item">' +
                                        '<div class="product-img">' +
                                        '    <img src="' + image + '" style="object-fit:cover; max-width:100px; max-height:100px" width="100%" alt="Producto">' +
                                        '</div>' +
                                        ' <div class="product-info padding">' +
                                        '     <span href="javascript:void(0)" class="product-title"><font>' +
                                        ' ' + data.NombreMarca.substr(0, 52) + '</font>' +
                                        ' </span>' +
                                        '     <span class="product-description">Precio ' + tools.formatMoney(data.PrecioVenta, 2) + '</span>' +
                                        '<span class="label label-primary pull-right">Cantidad: ' + tools.formatMoney(data.Cantidad, 0) + '</span>' +
                                        ' </div>' +
                                        ' </li>');
                            }

                            // /*vista donde carga el diagrama de lineas*/
                            // /*linea de semanas*/
                            let DigramadeLinea = result.data[0].DiagramaLinea;
                            let dataline = [];
                            for (let data of DigramadeLinea) {
                                dataline.push({
                                    year: data.FechaIngreso,
                                    value1: tools.formatMoney(data.Valor1, 0),
                                    value2: tools.formatMoney(data.Valor2, 0)
                                });
                            }
                            // diagramaLinea(dataline);

                            // /*vista donde carga */
                            let productosAgotados = result.data[0].ProductosAgotados;
                            for (let data of productosAgotados) {

                                productoAgotado.append(' <div class="info-box bg-red">' +
                                        ' <span class="info-box-icon"><i class="fa fa-bell-slash"></i></span>' +
                                        '  <div class="info-box-content">' +
                                        '   <span class="info-box-text" >' + data.NombreProducto.substr(0, 35) + ' (S/ ' + tools.formatMoney(data.Pecio, 2) + ')</span>' +
                                        '    <span class="info-box-number">Cantidad: ' + tools.formatMoney(data.Cantidad, 0) + '</span>' +
                                        '      <span class="progress-description"> Tienda Principal - Almacen </span>' +
                                        '    </div>' +
                                        '  </div>');
                            }

                            let prodcutosAgotados = result.data[0].ProductosPorAgotarse;
                            for (let data of prodcutosAgotados) {
                                productosPorAgotarse.append(' <div class="info-box bg-yellow">' +
                                        ' <span class="info-box-icon"><i class="fa fa-bell-slash"></i></span>' +
                                        '  <div class="info-box-content">' +
                                        '   <span class="info-box-text" >' + data.NombreProducto.substr(0, 35) + ' (S/ ' + tools.formatMoney(data.Pecio, 2) + ')</span>' +
                                        '    <span class="info-box-number">P/Agotarse: ' + tools.formatMoney(data.Cantidad, 0) + '</span>' +
                                        '      <span class="progress-description"> Tienda Principal - Almacen </span>' +
                                        '    </div>' +
                                        '  </div>');
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }

                function loadDiagramaDeLineas(tipo) {
                    $.ajax({
                        url: "./app/controller/ventas/CargarDiagramaSemanaMes.php",
                        method: "GET",
                        data: {

                        },
                        beforeSend: function () {},
                        success: function (result) {
                            if (result.estado === 1) {
                                if (tipo === "semana") {
                                    let DigramadeLinea = result.data[0].DiagramaLinea;
                                    let dataline = [];
                                    for (let data of DigramadeLinea) {
                                        dataline.push({
                                            year: data.FechaIngreso,
                                            value1: tools.formatMoney(data.Valor1, 0),
                                            value2: tools.formatMoney(data.Valor2, 0),
                                        });
                                    }
                                    diagramaLinea(dataline);
                                } else {
                                    let DiagramadeLineaMes = result.data[0].DiagramaLineaMes;
                                    let datalineMes = [];
                                    for (let data of DiagramadeLineaMes) {
                                        datalineMes.push({
                                            year: data.FechaIngreso,
                                            value1: tools.formatMoney(data.Valor1, 0),
                                            value2: tools.formatMoney(data.Valor2, 0)
                                        });
                                    }
                                    diagramaLineaMes(datalineMes);
                                }
                            } else {
                                $("#diagrama-linea").empty();
                                $("#diagrama-linea-Mes").empty();
                            }

                        },
                        error: function (error) {
                            $("#diagrama-linea").empty();
                            $("#diagrama-linea-Mes").empty();
                        }
                    });
                }



                function diagramaLinea(list) {
                    new Morris.Line({
                        // ID of the element in which to draw the chart.
                        element: 'diagrama-linea',
                        // Chart data records -- each entry in this array corresponds to a point on
                        data: list,
                        // The name of the data record attribute that contains x-values.
                        xkey: 'year',
                        // A list of names of data record attributes that contain y-values.
                        ykeys: ['value1', 'value2'],
                        // Labels for the ykeys -- will be displayed when you hover over the
                        // chart.
                        labels: ['Ingresos', 'egresos'],
                        resize: true,
                        LineColors: ['#53a0e4', '#70D942'],
                        xlabels: "day"

                    });
                }

                function diagramaLineaMes(list) {
                    new Morris.Line({
                        // ID of the element in which to draw the chart.
                        element: 'diagrama-linea-Mes',
                        // Chart data records -- each entry in this array corresponds to a point on
                        data: list,
                        // The name of the data record attribute that contains x-values.
                        xkey: 'year',
                        // A list of names of data record attributes that contain y-values.
                        ykeys: ['value1', 'value2'],
                        // Labels for the ykeys -- will be displayed when you hover over the
                        // chart.
                        labels: ['Ingresos', 'egresos'],
                        resize: true,
                        LineColors: ['#53a0e4', '#70D942'],
                        xlabels: "day"

                    });
                }
            </script>
        </body>

    </html>
    <?php
}
