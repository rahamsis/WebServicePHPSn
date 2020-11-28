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

                            <div class="row">
                                <!-- titulo -->
                                <div class="tituloprincipal">
                                    <span class="text-md-bold">
                                        Configurar mi Empresa
                                    </span>
                                </div>
                                <!-- fin titulo -->
                            </div>

                            <!-- inicio de subtitulo -->
                            <div class="md-content">
                                <!--inicio otros datos-->
                                <div class="md-lista-form">

                                    <div class="md100 pd-normal">
                                        <div>
                                            <label class="lbl-titulo">
                                                <i></i>
                                                R.U.C:
                                            </label>
                                            <div>
                                                <input id="txtNumDocumento" class="input-primary" type="text" placeholder="R.U.C.">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="md100 pd-normal">
                                        <div>
                                            <label class="lbl-titulo ">
                                                <i></i>
                                                Razón Social
                                            </label>
                                            <div>
                                                <input id="txtRazonSocial" class="input-primary" type="text" placeholder="Razón Social" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="md100 pd-normal">
                                        <div>
                                            <label class="lbl-titulo ">
                                                <i></i>
                                                Nombre Comercial
                                            </label>
                                            <div>
                                                <input id="txtNomComercial" class="input-primary" type="text" placeholder="Nombre Comercial">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--fin-->

                                <!--inicio subir logo-->

                                <div class="imagenprincipal">
                                    <div class="imagen1">
                                        <img src="./image/noimage.jpg" id="lblImagen" />
                                    </div>
                                    <div class="logoselect">
                                        <input type="file" id="fileImage" accept="image/png, image/jpeg, image/gif, image/svg" hidden />
                                        <label class="logoselect1" for="fileImage" id="txtFile">Subir Imagen</label>
                                    </div>
                                </div>

                                <!--fin-->
                            </div>

                            <!-- inicio dirección -->
                            <div class="md-content">
                                <div class="md100 pd-normal-tb">
                                    <div>
                                        <label class="lbl-titulo">
                                            <i></i>
                                            Dirección Fiscal:
                                        </label>
                                        <div>
                                            <input id="txtDireccion" class="input-primary" type="text" placeholder="Ingrese su dirección fiscal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fin dirección -->

                            <div class="md-content ">

                                <div class="md50 pd-normal">
                                    <div>
                                        <label class="lbl-titulo ">
                                            <i></i>
                                            Teléfono
                                        </label>
                                        <div>
                                            <input id="txtTelefono" class="input-primary" type="text" placeholder="Teléfono">

                                        </div>
                                    </div>
                                </div>

                                <div class="md50 pd-normal">
                                    <div>
                                        <label class="lbl-titulo ">
                                            <i></i>
                                            Celular
                                        </label>
                                        <div>
                                            <input id="txtCelular" class="input-primary" type="text" placeholder="Celular">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="md-content">

                                <div class="md50 pd-normal">
                                    <div>
                                        <label class="lbl-titulo">
                                            <i></i>
                                            Página Web
                                        </label>
                                        <div>
                                            <input id="txtPaginWeb" class="input-primary" type="text" placeholder="Página Web">

                                        </div>
                                    </div>
                                </div>

                                <div class="md50 pd-normal">
                                    <div class="clase5">
                                        <label class="lbl-titulo ">
                                            <i></i>
                                            Email
                                        </label>
                                        <div>
                                            <input id="txtEmail" class="input-primary" type="text" placeholder="Email" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- fin de subtitulo -->

                            <!-- inicio password -->
                            <div class="subtitulo">
                                <div class="subtitulo-texto">
                                    Usuario y Password SOL - SUNAT
                                </div>
                                <div class="subtitulo-linea"></div>
                            </div>

                            <div class="md-content">
                                <div class="md50 pd-normal">
                                    <div class="clase5">
                                        <label class="lbl-titulo ">
                                            <i></i>
                                            Usuario Sol
                                        </label>
                                        <div>
                                            <input id="txtUsuarioSol" class="input-primary" type="text" placeholder="Usuario Sol" />
                                        </div>
                                    </div>
                                </div>
                                <div class="md50 pd-normal">
                                    <div class="clase5">
                                        <label class="lbl-titulo ">
                                            <i></i>
                                            Contraseña Sol
                                        </label>
                                        <div>
                                            <input id="txtClaveSol" class="input-primary" type="password" placeholder="Password SOL" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="subtitulo">
                                <div class="subtitulo-texto">
                                    Certificado Electrónico y Password
                                </div>
                                <div class="subtitulo-linea"></div>
                            </div>

                            <div class="md-content">

                                <div class="md50 pd-normal">
                                    <div class="md50-content">
                                        <div class="clase5">
                                            <label class="lbl-titulo">
                                                <i></i>
                                                Seleccionar Archivo
                                            </label>
                                            <div class="input-content">
                                                <input type="file" id="fileCertificado" hidden />
                                                <label class="filename" for="fileCertificado" id="lblNameCertificado">Seleccione el certificado</label>
                                                <label class="btn-action" for="fileCertificado">Subir</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="md50 pd-normal">
                                    <div class="clase5">
                                        <label class="lbl-titulo ">
                                            <i></i>
                                            Contraseña de tu Certificado
                                        </label>
                                        <div>
                                            <input id="txtClaveCertificado" class="input-primary" type="password" placeholder="Contraseña de tu Certificado" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- fin de password -->

                            <!---->
                            <div class="pd-normal button-content">
                                <div class="pd-normal-tb">
                                    <button id="btnGuardar" class="btn button-primary" type="button">
                                        <div class="content-button">
                                            <img src="./image/save.svg" />
                                            <span>Guardar Información</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
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

        <script>
            let tools = new Tools();

            let idEmpresa = 0;
            let txtNumDocumento = $("#txtNumDocumento");
            let txtRazonSocial = $("#txtRazonSocial");
            let txtNomComercial = $("#txtNomComercial");
            let lblImagen = $("#lblImagen");
            let fileImage = $("#fileImage");
            let txtDireccion = $("#txtDireccion");
            let txtTelefono = $("#txtTelefono");
            let txtCelular = $("#txtCelular");
            let txtPaginWeb = $("#txtPaginWeb");
            let txtEmail = $("#txtEmail");
            let txtUsuarioSol = $("#txtUsuarioSol");
            let txtClaveSol = $("#txtClaveSol");
            let lblNameCertificado = $("#lblNameCertificado");
            let fileCertificado = $("#fileCertificado");
            let txtClaveCertificado = $("#txtClaveCertificado");
            $(document).ready(function() {
                $("#btnCerrarSession").click(function() {
                    window.location.href = "closesession.php";
                });

                $("#fileImage").on('change', function(event) {
                    lblImagen.attr("src", URL.createObjectURL(event.target.files[0]));
                });

                $("#fileCertificado").on('change', function(event) {
                    lblNameCertificado.html(event.target.files[0].name);
                });

                $("#btnGuardar").on("keyup", function(event) {
                    if (event.keyCode == 13) {
                        crudEmpresa();
                    }
                });

                $("#btnGuardar").on("click", function() {
                    crudEmpresa();
                });

                LoadDataEmpresa();
            });

            function LoadDataEmpresa() {
                $.ajax({
                    url: "../app/controller/empresa/ListarEmpresa.php",
                    method: "GET",
                    data: {},
                    beforeSend: function() {

                    },
                    success: function(result) {
                        let data = result;
                        if (data.estado == 1) {
                            idEmpresa = data.result.IdEmpresa;
                            txtNumDocumento.val(data.result.NumeroDocumento);
                            txtRazonSocial.val(data.result.RazonSocial);
                            txtNomComercial.val(data.result.NombreComercial);
                            if (data.result.Image == "") {
                                lblImagen.attr("src", "./image/noimage.jpg");
                            } else {
                                lblImagen.attr("src", "data:image/png;base64," + data.result.Image);
                            }
                            txtDireccion.val(data.result.Domicilio)
                            txtTelefono.val(data.result.Telefono);
                            txtCelular.val(data.result.Celular);
                            txtPaginWeb.val(data.result.PaginaWeb);
                            txtEmail.val(data.result.Email);
                            txtUsuarioSol.val(data.result.UsuarioSol);
                            txtClaveSol.val(data.result.ClaveSol);
                            lblNameCertificado.html(data.result.CertificadoRuta);
                            txtClaveCertificado.val(data.result.CertificadoClave);
                        } else {

                        }
                    },
                    error: function(error) {
                        console.log("Error");
                        console.log(error);
                    }

                });
            }

            function crudEmpresa() {
                var formData = new FormData();
                formData.append("idEmpresa", idEmpresa);
                formData.append("txtNumDocumento", txtNumDocumento.val());
                formData.append("txtRazonSocial", txtRazonSocial.val());
                formData.append("txtNomComercial", txtNomComercial.val());
                formData.append("txtDireccion", txtDireccion.val());
                formData.append("txtTelefono", txtTelefono.val());
                formData.append("txtCelular", txtCelular.val());
                formData.append("txtPaginWeb", txtPaginWeb.val());
                formData.append("txtEmail", txtEmail.val());

                formData.append("imageType", fileImage[0].files.length);
                formData.append("image", fileImage[0].files[0]);

                formData.append("txtUsuarioSol", txtUsuarioSol.val());
                formData.append("txtClaveSol", txtClaveSol.val());
                formData.append("certificadoUrl", lblNameCertificado.html());
                formData.append("certificadoType", fileCertificado[0].files.length);
                formData.append("certificado", fileCertificado[0].files[0]);
                formData.append("txtClaveCertificado", txtClaveCertificado.val());

                $.ajax({
                    url: "./sunat/empresa/CrudEmpresa.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        tools.alertLoad("Mi Empresa", "Procesando el envío de la información.");
                    },
                    success: function(result) {
                        if (result.state == 1) {
                            tools.alertInformation("Mi Empresa", result.message);
                        } else {
                            tools.alertWarning("Mi Empresa", result.message);
                        }
                    },
                    error: function(error) {
                        tools.alertError("Mi Empresa",
                            "Error en el procreso de envío intente nuevamente."
                        );
                    }
                });
            }
        </script>
    </body>

    </html>
<?php
}
?>