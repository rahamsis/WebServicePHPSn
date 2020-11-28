<?php
session_start();
if (isset($_SESSION['IdEmpleado'])) {
    echo '<script>location.href = "./index.php";</script>';
} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <?php include 'layout/head.php'; ?>
        </head>

        <body class="hold-transition login-page" style='background-image: url("image/fondo3.jpg"); height: auto;background-repeat: no-repeat;min-height: 100vh;background-position: center center;background-size: cover;'>

            <div class="login-box">
                <div class="login-logo">
                    <div>
                        <img class="logo" src="./image/logo.png" width="100">
                    </div>
                    <div>
                        <a class="login-box-msg" href="index.php"><b>SysSoft</b> Integra</a>
                    </div>                  
                </div>

                <div class="login-box-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <h3 class="login-box-msg">Iniciar Sesión</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Ingresar usuario" id="txtUsuario">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Ingresar contraseña" id="txtClave">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="btnEntrar">
                                    <i class="fa  fa-windows"></i> Ingresar                                
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <span class="text-danger" id="lblMessageError"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-lg-12 col-md-12">
                            <span>SysSoft Integra</span>
                        </div>
                    </div>

                </div>


            </div>

            <script>
                $(document).ready(function () {
                    $("#txtUsuario").on("keydown", function (event) {
                        if (event.keyCode === 13) {
                            validarIngreso($("#txtUsuario").val().trim(), $("#txtClave").val().trim());
                        }
                    });

                    $("#txtClave").on("keydown", function (event) {
                        if (event.keyCode === 13) {
                            validarIngreso($("#txtUsuario").val(), $("#txtClave").val());
                        }
                    });

                    $("#btnEntrar").click(function () {
                        validarIngreso($("#txtUsuario").val(), $("#txtClave").val());
                    });

                    $("#btnEntrar").click(function (event) {
                        if (event.keyCode === 13) {
                            validarIngreso($("#txtUsuario").val(), $("#txtClave").val());
                        }
                        event.preventDefault();
                    });
                });


                function validarIngreso(usuario, clave) {
                    if (usuario.trim().length === 0) {
                        $("#lblMessageError").html("Ingrese su usuario.");
                        $("#txtUsuario").focus();
                    } else if (clave.trim().length === 0) {
                        $("#lblMessageError").html("Ingrese su contraseña.");
                        $("#txtClave").focus();
                    } else {
                        $.ajax({
                            url: "../app/controller/login/Login.php",
                            method: "GET",
                            data: {
                                "usuario": usuario.trim(),
                                "clave": clave.trim()
                            },
                            beforeSend: function () {
                                $("#lblMessageError").html("Validando ingreso...");
                                $("#btnEntrar").removeClass("button-primary");
                                $("#btnEntrar").addClass("button-primary-disable");
                            },
                            success: function (result) {
                                let object = result;
                                if (object.estado == 1) {
                                    $("#btnEntrar").removeClass("button-primary-disable");
                                    $("#btnEntrar").addClass("button-primary");
                                    window.location.href = "./index.php";
                                } else if (object.estado == 2) {
                                    $("#btnEntrar").removeClass("button-primary-disable");
                                    $("#btnEntrar").addClass("button-primary");
                                    $("#lblMessageError").html(object.message);
                                    $("#txtUsuario").focus();
                                } else {
                                    $("#btnEntrar").removeClass("button-primary-disable");
                                    $("#btnEntrar").addClass("button-primary");
                                    $("#lblMessageError").html(object.message);
                                    $("#txtUsuario").focus();
                                }
                            },
                            error: function (error) {
                                $("#btnEntrar").removeClass("button-primary-disable");
                                $("#btnEntrar").addClass("button-primary");
                                $("#lblMessageError").html(error);
                            }
                        });
                    }
                }
            </script>
        </body>

    </html>
    <?php
}
