<?php

class ControladorUsuarios
{

    /* ================
    INGRESO DE USUARIO
    ===================*/

    static public function ctrIngresoUsuario()
    {
        if (isset($_POST["ingUsuario"])) {

            if (
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])
            ) {

                $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $tabla = "usuarios";

                $item = "usuario";
                $valor = $_POST["ingUsuario"];

                $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

                if (
                    $respuesta["usuario"] == $_POST["ingUsuario"] &&
                    $respuesta["password"] == $encriptar
                ) {

                    if ($respuesta["estado"] == 1) {

                        $_SESSION["iniciarSesion"] = "ok";
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["nombre"] = $respuesta["nombre"];
                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["foto"] = $respuesta["foto"];
                        $_SESSION["perfil"] = $respuesta["perfil"];

                        /* ===================
                        REGISTRAR ULTIMO LOGIN
                        ====================== */
                        date_default_timezone_set("America/Guayaquil");

                        $fecha = date("Y-m-d");
                        $hora = date("H:i:s");

                        $fechaActual = $fecha . " " . $hora;

                        $item1 = "ultimo_login";
                        $valor1 = $fechaActual;

                        $item2 = "id";
                        $valor2 = $respuesta["id"];

                        $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

                        echo '
                            <script>
                                window.location = "inicio"
                            </script>
                        ';
                    } else {
                        echo "<br><div class='alert alert-danger'>El Usuario no está Activado</div>";
                    }
                } else {
                    echo "<br><div class='alert alert-danger'>Usuario o Contraseña incorrectos, 
                    vuelve a intentarlo</div>";
                }
            }
        }
    }

    /* ========================
    REGISTRAR UN NUEVO USUARIO
    ===========================*/
    static public function ctrCrearUsuario()
    {

        if (isset($_POST["nuevoUsuario"])) {

            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])
            ) {

                /* ============
                VALIDAR IMAGEN
                ===============*/

                $ruta = "";

                if (isset($_FILES["nuevaFoto"]["tmp_name"]) && $_FILES["nuevaFoto"]["size"] > 0) {

                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /* =======================================================
                    CREAR DIRECTORIO DONDE SE VA A GUARDAR LA FOTO DEL USUARIO
                    ========================================================== */
                    $directorio = "vistas/img/usuarios/" . $_POST["nuevoUsuario"];

                    mkdir($directorio, 0755);

                    /* =======================================================
                    DE ACUERDO AL TIPO DE IMG SE APLICAN DIFERENTES FUNCIONES DE PHP
                    ========================================================== */
                    if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {

                        /* ===============================
                        GUARDAR LA IMAGEN JPG EN EL DIRECTORIO
                        ================================== */

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "vistas/img/usuarios/" . $_POST["nuevoUsuario"] . "/" . $aleatorio . ".jpg";

                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);
                    }

                    if ($_FILES["nuevaFoto"]["type"] == "image/png") {

                        /* ===============================
                        GUARDAR LA IMAGEN PNG EN EL DIRECTORIO
                        ================================== */

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "vistas/img/usuarios/" . $_POST["nuevoUsuario"] . "/" . $aleatorio . ".jpg";

                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);
                    }
                }

                $tabla = "usuarios";

                $encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $datos = array(
                    "nombre" => $_POST["nuevoNombre"],
                    "usuario" => $_POST["nuevoUsuario"],
                    "password" => $encriptar,
                    "perfil" => $_POST["nuevoPerfil"],
                    "ruta" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

                if ($respuesta == "ok") {

                    echo '
                    <script>

                        swal({

                            type: "success",
                            title: "¡El usuario ha sido guardado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result)=>{

                            if(result.value){

                                window.location = "usuarios";

                            }

                        });

                    </script>
                    ';
                }
            } else {
                echo '
                <script>

                    swal({

                        type: "error",
                        title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{

                        if(result.value){

                            window.location = "usuarios";

                        }

                    });

                </script>
                ';
            }
        }
    }

    /* ============
    MOSTRAR USUARIO
    ===============*/
    static public function ctrMostrarUsuarios($item, $valor)
    {

        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

        return $respuesta;
    }

    /* ============
    EDITAR USUARIO
    ===============*/

    public function ctrEditarUsuario()
    {

        // ? SI NO FUNCIONA RECORDAR QUE SE DEBE DESCOMENTAR (QUITAR PUNTO Y COMA) DE XAMPP PHP_INI
        // ? EXTENSION=GD

        if (isset($_POST["editarUsuario"])) {
            echo '<script>console.log("' . $_POST["editarUsuario"] . '")</script>';
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])
            ) {
                echo '<script>console.log("' . $_POST["editarUsuario"] . '")</script>';

                /* ============
                VALIDAR IMAGEN
                ===============*/

                $ruta = $_POST["fotoActual"];
                echo '<script>console.log("' . $ruta . '")</script>';


                if (isset($_FILES["editarFoto"]["tmp_name"]) && $_FILES["editarFoto"]["size"] > 0) {

                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /* =======================================================
                    CREAR DIRECTORIO DONDE SE VA A GUARDAR LA FOTO DEL USUARIO
                    ========================================================== */
                    $directorio = "vistas/img/usuarios/" . $_POST["editarUsuario"];


                    /* =====================================
                    VALIDAMOS SI EXISTE UNA IMAGEN EN LA BD
                    ======================================== */
                    if (!empty($_POST["fotoActual"])) {

                        unlink($_POST["fotoActual"]);
                    } else {

                        mkdir($directorio, 0755);
                    }

                    /* =======================================================
                    DE ACUERDO AL TIPO DE IMG SE APLICAN DIFERENTES FUNCIONES DE PHP
                    ========================================================== */
                    if ($_FILES["editarFoto"]["type"] == "image/jpeg") {

                        /* ===============================
                        GUARDAR LA IMAGEN JPG EN EL DIRECTORIO
                        ================================== */

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "vistas/img/usuarios/" . $_POST["editarUsuario"] . "/" . $aleatorio . ".jpg";

                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);
                    }

                    if ($_FILES["editarFoto"]["type"] == "image/png") {

                        /* ===============================
                        GUARDAR LA IMAGEN PNG EN EL DIRECTORIO
                        ================================== */

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "vistas/img/usuarios/" . $_POST["editarUsuario"] . "/" . $aleatorio . ".jpg";

                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);
                    }
                }
                echo '<script>console.log("si se muestra la ruta:  ' . $ruta . '")</script>';
            } else {

                echo '
                    <script>

                        swal({
                            type: "error",
                            title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result)=>{

                            if(result.value){

                                window.location = "usuarios";

                            }

                        });

                    </script>
                ';
            }

            $tabla = "usuarios";

            if ($_POST["editarPassword"] != "") {
                if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])) {

                    $encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                } else {
                    echo '
                        <script>

                            swal({
                                type: "error",
                                title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            }).then((result)=>{

                                if(result.value){

                                    window.location = "usuarios";

                                }

                            });

                        </script>
                    ';
                }
            } else {
                $encriptar = $_POST["passwordActual"];
            }

            $datos = array(
                "nombre" => $_POST["editarNombre"],
                "usuario" => $_POST["editarUsuario"],
                "password" => $encriptar,
                "perfil" => $_POST["editarPerfil"],
                "foto" => $ruta
            );
            echo '<script>console.log("' . $datos['nombre'] . '")</script>';
            echo '<script>console.log("' . $datos['usuario'] . '")</script>';
            echo '<script>console.log("' . $datos['password'] . '")</script>';
            echo '<script>console.log("' . $datos['perfil'] . '")</script>';
            echo '<script>console.log("' . $datos['foto'] . '")</script>';

            echo '<script>console.log("ANTES DE RESPUESTA")</script>';

            $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
            echo '<script>console.log("DESPUES DE RESPUESTA")</script>';

            if ($respuesta == "ok") {
                echo '
                    <script>

                        swal({

                            type: "success",
                            title: "¡El usuario ha sido editado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result)=>{

                            if(result.value){

                                window.location = "usuarios";

                            }

                        });

                    </script>
                ';
            }
        }
    }

    /* ===============================
    ELIMINAR USUARIO
    ================================== */

    static public function ctrBorrarUsuario()
    {
        if (isset($_GET["idUsuario"])) {
            $tabla = "usuarios";
            $datos = $_GET["idUsuario"];
            if ($_GET["fotoUsuario"] != "") {
                unlink($_GET["fotoUsuario"]);
                rmdir('vistas/img/usuarios/' . $_GET["usuario"]);
            }
            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
            if ($respuesta == "ok") {
                echo '
                    <script>
                        swal({
                            type: "success",
                            title: "¡El usuario ha sido eliminado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result)=>{
                            if(result.value){
                                window.location = "usuarios";
                            }
                        });
                    </script>
                ';
            }
        }
    }
}
