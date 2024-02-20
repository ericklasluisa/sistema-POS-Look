<?php

require_once "conexion.php";

class ModeloUsuarios
{

    /*==============
    MOSTRAR USUARIOS
    ================*/
    static public function mdlMostrarUsuarios($tabla, $item, $valor)
    {

        if ($item != null) {
            $conexion = new Conexion();
            $stmt = $conexion->conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        } else {
            $conexion = new Conexion();
            $stmt = $conexion->conectar()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();
        }


    }

    /*==============
    REGISTRO USUARIOS
    ================*/
    static public function mdlIngresarUsuario($tabla, $datos)
    {
        $conexion = new Conexion();
        $stmt = $conexion->conectar()->prepare("INSERT INTO 
            $tabla(nombre, usuario, password, perfil, foto) 
            VALUES (:nombre, :usuario, :password, :perfil, :ruta)");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta", $datos["ruta"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";

        } else {

            return "error";

        }

    }

    /*==============
    EDITAR USUARIOS
    ================*/
    static public function mdlEditarUsuario($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre, password=:password, perfil=:perfil, foto=:foto WHERE usuario = :usuario");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";

        } else {

            return "error";

        }
    }

}