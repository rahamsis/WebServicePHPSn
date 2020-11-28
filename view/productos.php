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

                <div class="content-wrapper" style="background-color: #FFFFFF;">

                    <section class="content-header">
                        <h3 class="no-margin"> Productos <small> Lista <img src="./image/loading.gif" id="imgLoad" width="28" height="28" /></small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button class="btn btn-success" id="btnAgregar">                                 
                                        <i class="fa fa-plus"></i>  
                                        Agregar                            
                                    </button>     
                                     <button class="btn btn-danger" id="btnReload">                                   
                                        <i class="fa fa-refresh"></i>  
                                        Recargar                                 
                                    </button>                                    
                                </div>                      
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label class="text-xs margin-5">Buscar: </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Clave o clave alterna" class="input-primary " id="txtClaveProducto">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <label class="text-xs margin-5">Buscar:</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Descripción del producto" class="input-primary" id="txtDescripcionProducto">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
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
                                                <th  style="width:5%">N°</th>
                                                <th  style="width:20%">Descripción</th>
                                                <th  style="width:10%">Categoría</th>
                                                <th  style="width:10%">Marca</th>
                                                <th  style="width:10%">Costo</th>
                                                <th  style="width:10%">Precio</th>
                                                <th  style="width:10%">Cantidad</th>
                                                <th  style="width:10%">Imagen</th>
                                                <th  style="width:10%">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbList">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>

            <script>
                let tools = new Tools();
                let state = false;
                let paginacion = 0;
                let opcion = 0;
                let totalPaginacion = 0;
                let filasPorPagina = 20;
                let tbList = $("#tbList");
                let imgLoad = $("#imgLoad");
                let lblPaginaActual = $("#lblPaginaActual");
                let lblPaginaSiguiente = $("#lblPaginaSiguiente");

                $(document).ready(function () {
                    loadInitProductos();

                    $("#tbList").on("click", "tr", function (event) {
                        $(".selected-table-tr").removeClass("selected-table-tr");
                        $(this).addClass("selected-table-tr");
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

                    $("#txtClaveProducto").keyup(function () {
                        if ($("#txtClaveProducto").val().trim() != "") {
                            if (!state) {
                                paginacion = 1;
                                loadListaProductos(1, $("#txtClaveProducto").val().trim(), "");
                                opcion = 1;
                            }
                        }
                    });

                    $("#txtDescripcionProducto").keyup(function () {
                        if ($("#txtDescripcionProducto").val().trim() != "") {
                            if (!state) {
                                paginacion = 1;
                                loadListaProductos(2, "", $("#txtDescripcionProducto").val().trim());
                                opcion = 2;
                            }
                        }
                    });

                    $("#btnAgregar").click(function () {
                        window.location.href = "registrarproducto.php";
                    });

                    $("#btnAgregar").keypress(function (event) {
                        if (event.keyCode === 13) {
                            window.location.href = "registrarproducto.php";
                        }
                        event.preventDefault();
                    });

                    $("#btnReload").click(function () {
                        loadInitProductos();
                    });

                    $("#btnReload").keypress(function (event) {
                        if (event.keyCode === 13) {
                            loadInitProductos();
                        }
                        event.preventDefault();
                    });


                    $("#btnReporte").click(function () {

                    });

                    $("#btnReporte").keypress(function (event) {
                        if (event.keyCode === 13) {

                        }
                        event.preventDefault();
                    });

                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadListaProductos(0, "", "");
                            break;
                        case 1:
                            loadListaProductos(1, $("#txtClaveProducto").val().trim(), "");
                            break;
                        case 2:
                            loadListaProductos(2, "", $("#txtDescripcionProducto").val().trim());
                            break;
                    }
                }


                function loadInitProductos() {
                    if (!state) {
                        paginacion = 1;
                        loadListaProductos(0, "", "");
                        opcion = 0;
                    }
                }

                function loadListaProductos(opcion, clave, nombre) {
                    $.ajax({
                        url: "../app/controller/suministros/ListarSuministros.php",
                        method: "GET",
                        data: {
                            "type": "listaproductos",
                            "opcion": opcion,
                            "clave": clave,
                            "nombre": nombre,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function () {
                            imgLoad.css({
                                "display": "block"
                            });
                            tbList.empty();
                            tbList.append('<tr><td class="text-center" colspan="8">Cargando información...</td></tr>');
                            state = true;
                        },
                        success: function (result) {
                            let object = JSON.parse(result);
                            if (object.estado === 1) {
                                tbList.empty();
                                for (let suministro of object.data) {
                                    let image = "./image/noimage.jpg";
                                    if (suministro.NuevaImagen != '') {
                                        image = ("data:image/png;base64," + suministro.NuevaImagen);
                                    }

                                    let clave = suministro.Clave + " " + (suministro.ClaveAlterna == "" ? "" : " - " + suministro.ClaveAlterna);

                                    let cantidad = parseFloat(suministro.Cantidad) <= 0 ? '<span class="text-xs-bold text-danger">' + tools.formatMoney(suministro.Cantidad) + '</span>' : '<span class="text-xs-bold text-primary">' + tools.formatMoney(suministro.Cantidad) + '</span>';

                                    tbList.append('<tr>' +
                                            '<td class="text-center">' + suministro.Id + '</td>' +
                                            '<td>' + clave + '<br>' + suministro.NombreMarca + '</td>' +
                                            '<td>' + suministro.Categoria + '</td>' +
                                            '<td>' + suministro.Marca + '</td>' +
                                            '<td class="text-right">' + tools.formatMoney(suministro.PrecioCompra) + '</td>' +
                                            '<td class="text-right">' + tools.formatMoney(suministro.PrecioVentaGeneral) + '</td>' +
                                            '<td class="text-right">' + cantidad + '</td>' +
                                            '<td class="text-center"><figure><img style="width:80px;height:80px;object-fit:cover;" src="' + image + '" alt="Producto"/></figure></td>' +
                                            '<td class="text-center">' +
                                            '<button type="button" class="btn btn-warning"><i class="fa fa-edit"></i></button>' +
                                            '<button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>' +
                                            '</td>' +
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
                                tbList.empty();
                                tbList.append('<tr><td class="text-center" colspan="8">' + object.message + '</td></tr>');
                                lblPaginaActual.html("0");
                                lblPaginaSiguiente.html("0");
                                state = false;
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            </script>
        </body>

    </html>
    <?php
}
