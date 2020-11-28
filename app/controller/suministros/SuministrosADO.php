<?php

/**
 * Representa el la estructura de las Clientes
 * almacenadas en la base de datos
 */
require '../../database/DataBaseConexion.php';

class SuministrosADO
{

    function __construct()
    {
    }

    public static function ListarInventario($producto, $tipoExistencia, $nameProduct, $opcion, $categoria, $marca, $posicionPaginacion, $filasPorPagina)
    {
        $consulta = "{CALL Sp_Listar_Inventario_Suministros(?,?,?,?,?,?,?,?)}";
        $array = array();
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, $producto, PDO::PARAM_STR);
            $comando->bindValue(2, $tipoExistencia, PDO::PARAM_INT);
            $comando->bindValue(3, $nameProduct, PDO::PARAM_STR);
            $comando->bindValue(4, $opcion, PDO::PARAM_INT);
            $comando->bindValue(5, $categoria, PDO::PARAM_INT);
            $comando->bindValue(6, $marca, PDO::PARAM_INT);
            $comando->bindValue(7, $posicionPaginacion, PDO::PARAM_INT);
            $comando->bindValue(8, $filasPorPagina, PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "count" => $count + $posicionPaginacion,
                    "IdSuministro" => $row["IdSuministro"],
                    "Clave" => $row["Clave"],
                    "ClaveAlterna" => $row["ClaveAlterna"],
                    "NombreMarca" => $row["NombreMarca"],
                    "PrecioCompra" => $row["PrecioCompra"],
                    "PrecioVentaGeneral" => $row["PrecioVentaGeneral"],
                    "Cantidad" => $row["Cantidad"],
                    "UnidadCompra" => $row["UnidadCompra"],
                    "Estado" => $row["Estado"],
                    "Total" => $row["Total"],
                    "StockMinimo" => $row["StockMinimo"],
                    "StockMaximo" => $row["StockMaximo"],
                    "Categoria" => $row["Categoria"],
                    "Marca" => $row["Marca"],
                    "Inventario" => $row["Inventario"],
                    "Estado" => $row["Estado"]
                ));
            }
            return $array;
        } catch (PDOException $e) {
            return $array;
        }
    }

    public static function ListarInventarioCount($producto, $tipoExistencia, $nameProduct, $opcion, $categoria, $marca)
    {
        $consulta = "{CALL Sp_Listar_Inventario_Suministros_Count(?,?,?,?,?,?)}";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, $producto, PDO::PARAM_STR);
            $comando->bindValue(2, $tipoExistencia, PDO::PARAM_INT);
            $comando->bindValue(3, $nameProduct, PDO::PARAM_STR);
            $comando->bindValue(4, $opcion, PDO::PARAM_INT);
            $comando->bindValue(5, $categoria, PDO::PARAM_INT);
            $comando->bindValue(6, $marca, PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public static function ListarMoviminentos($init, $opcion, $movimiento, $fechaInicial, $fechaFinal, $posicionPagina, $filasPorPagina)
    {

        try {
            $array = array();

            $arrayMovimiento = array();
            $cmdMovimiento = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Movimiento_Inventario(?,?,?,?,?,?,?)}");
            $cmdMovimiento->bindValue(1, $init, PDO::PARAM_BOOL);
            $cmdMovimiento->bindValue(2, $opcion, PDO::PARAM_INT);
            $cmdMovimiento->bindValue(3, $movimiento, PDO::PARAM_INT);
            $cmdMovimiento->bindValue(4, $fechaInicial, PDO::PARAM_STR);
            $cmdMovimiento->bindValue(5, $fechaFinal, PDO::PARAM_STR);
            $cmdMovimiento->bindValue(6, $posicionPagina, PDO::PARAM_INT);
            $cmdMovimiento->bindValue(7, $filasPorPagina, PDO::PARAM_INT);
            $cmdMovimiento->execute();
            $count = 0;
            while ($row = $cmdMovimiento->fetch()) {
                $count++;
                array_push($arrayMovimiento, array(
                    "count" => $count + $posicionPagina,
                    "IdMovimientoInventario" => $row["IdMovimientoInventario"],
                    "Fecha" => $row["Fecha"],
                    "Hora" => $row["Hora"],
                    "TipoAjuste" => $row["TipoAjuste"],
                    "TipoMovimiento" => $row["TipoMovimiento"],
                    "Observacion" => $row["Observacion"],
                    "Informacion" => $row["Informacion"],
                    "Proveedor" => $row["Proveedor"],
                    "Estado" => $row["Estado"]
                ));
            }

            $cmdMovimientoCount = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Movimiento_Inventario_Count(?,?,?,?,?)}");
            $cmdMovimientoCount->bindValue(1, $init, PDO::PARAM_BOOL);
            $cmdMovimientoCount->bindValue(2, $opcion, PDO::PARAM_INT);
            $cmdMovimientoCount->bindValue(3, $movimiento, PDO::PARAM_INT);
            $cmdMovimientoCount->bindValue(4, $fechaInicial, PDO::PARAM_STR);
            $cmdMovimientoCount->bindValue(5, $fechaFinal, PDO::PARAM_STR);
            $cmdMovimientoCount->execute();
            $resultMovimientoCount = $cmdMovimientoCount->fetchColumn();

            array_push($array, $arrayMovimiento, $resultMovimientoCount);
            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function ListarSuministroView($tipo, $value, $posicionPaginacion, $filasPorPagina)
    {
        try {
            $array = array();
            // Preparar sentencia
            $arraySuministro = array();
            $cmdSuministro = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Suministros_Lista_View(?,?,?,?)}");
            $cmdSuministro->bindValue(1, $tipo, PDO::PARAM_INT);
            $cmdSuministro->bindValue(2, $value, PDO::PARAM_STR);
            $cmdSuministro->bindValue(3, $posicionPaginacion, PDO::PARAM_INT);
            $cmdSuministro->bindValue(4, $filasPorPagina, PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $cmdSuministro->execute();
            $count = 0;
            while ($row = $cmdSuministro->fetch()) {
                $count++;
                array_push($arraySuministro, array(
                    "Id" => $count + $posicionPaginacion,
                    "IdSuministro" => $row["IdSuministro"],
                    "Clave" => $row["Clave"],
                    "NombreMarca" => $row["NombreMarca"],
                    "Categoria" => $row["Categoria"],
                    "Marca" => $row["Marca"],
                    "Cantidad" => $row["Cantidad"],
                    "PrecioCompra" => $row["PrecioCompra"],
                    "PrecioVentaGeneral" => $row["PrecioVentaGeneral"],
                    "UnidadCompra" => $row["UnidadCompra"],
                    "UnidadVenta" => $row["UnidadVenta"],
                    "Inventario" => $row["Inventario"],
                    "Operacion" => $row["Operacion"],
                    "Impuesto" => $row["Impuesto"],
                    "ImpuestoNombre" => $row["ImpuestoNombre"],
                    "Valor" => $row["Valor"],
                    "Lote" => $row["Lote"],
                    "ValorInventario" => $row["ValorInventario"],
                ));
            }

            // Preparar sentencia
            $cmdTotal = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Suministros_Lista_View_Count(?,?)}");
            $cmdTotal->bindValue(1, $tipo, PDO::PARAM_INT);
            $cmdTotal->bindValue(2, $value, PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $cmdTotal->execute();
            $resultTotal = $cmdTotal->fetchColumn();
            array_push($array, $arraySuministro, $resultTotal);

            return $array;
        } catch (PDOException $e) {
            return $array;
        }
    }

    public static function ListarSuministros($opcion, $clave, $nombreMarca, $categoria, $marca, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $cmdSuministros = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Suministros(?,?,?,?,?,?,?)}");
            $cmdSuministros->bindParam(1, $opcion, PDO::PARAM_INT);
            $cmdSuministros->bindParam(2, $clave, PDO::PARAM_STR);
            $cmdSuministros->bindParam(3, $nombreMarca, PDO::PARAM_STR);
            $cmdSuministros->bindParam(4, $categoria, PDO::PARAM_INT);
            $cmdSuministros->bindParam(5, $marca, PDO::PARAM_INT);
            $cmdSuministros->bindParam(6, $posicionPagina, PDO::PARAM_INT);
            $cmdSuministros->bindParam(7, $filasPorPagina, PDO::PARAM_INT);
            $cmdSuministros->execute();

            $arraSuministro = array();
            $count = 0;
            while ($row = $cmdSuministros->fetch()) {
                $count++;
                array_push($arraSuministro, array(
                    "Id" => $count + $posicionPagina,
                    "IdSuministro" => $row["IdSuministro"],
                    "Clave" => $row["Clave"],
                    "ClaveAlterna" => $row["ClaveAlterna"],
                    "NombreMarca" => $row["NombreMarca"],
                    "NombreGenerico" => $row["NombreGenerico"],
                    "StockMinimo" => $row["StockMinimo"],
                    "StockMaximo" => $row["StockMaximo"],
                    "Cantidad" => $row["Cantidad"],
                    "UnidadCompraNombre" => $row["UnidadCompraNombre"],
                    "PrecioCompra" => $row["PrecioCompra"],
                    "PrecioVentaGeneral" => $row["PrecioVentaGeneral"],
                    "Categoria" => $row["Categoria"],
                    "Marca" => $row["Marca"],
                    "Estado" => $row["Estado"],
                    "Inventario" => $row["Inventario"],
                    "ValorInventario" => $row["ValorInventario"],
                    "NuevaImagen" => ($row["NuevaImagen"] != null ? base64_encode($row["NuevaImagen"]) : ''),
                    "ImpuestoNombre" => $row["ImpuestoNombre"],
                    "Valor" => $row["Valor"],
                ));
            }

            $cmdTotales = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Suministros_Count(?,?,?,?,?)}");
            $cmdTotales->bindParam(1, $opcion, PDO::PARAM_STR);
            $cmdTotales->bindParam(2, $clave, PDO::PARAM_STR);
            $cmdTotales->bindParam(3, $nombreMarca, PDO::PARAM_STR);
            $cmdTotales->bindParam(4, $categoria, PDO::PARAM_STR);
            $cmdTotales->bindParam(5, $marca, PDO::PARAM_STR);
            $cmdTotales->execute();
            $montoTotal = $cmdTotales->fetchColumn();
            array_push($array, $arraSuministro, $montoTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public static function ObtenerSuministroForMovimiento($idSuministro)
    {
        $consulta = "{CALL Sp_Get_Suministro_For_Movimiento(?)}";
        $suministro = null;
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, $idSuministro, PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $comando->execute();
            $suministro = $comando->fetchObject();
            return $suministro;
        } catch (PDOException $e) {
            return $suministro;
        }
    }

    public static function ListarImpuesto()
    {
        try {
            $array = array();
            $cmdImpuesto = Database::getInstance()->getDb()->prepare("SELECT IdImpuesto,Nombre FROM ImpuestoTB");
            $cmdImpuesto->execute();
            while ($row = $cmdImpuesto->fetch()) {
                array_push($array, array(
                    "IdImpuesto" => $row["IdImpuesto"],
                    "Nombre" => $row["Nombre"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function CrudSuministro($suministro)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT Clave FROM SuministroTB WHERE Clave = ?");
            $cmdValidate->bindParam(1, $suministro["Clave"], PDO::PARAM_STR);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "duplicate";
            } else {

                $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT NombreMarca FROM SuministroTB WHERE NombreMarca = ?");
                $cmdValidate->bindParam(1, $suministro["NombreMarca"], PDO::PARAM_STR);
                $cmdValidate->execute();
                if ($cmdValidate->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "duplicatename";
                } else {

                    $codigoSuministro = Database::getInstance()->getDb()->prepare("SELECT dbo.Fc_Suministro_Codigo_Alfanumerico();");
                    $codigoSuministro->execute();
                    $idSuministro = $codigoSuministro->fetchColumn();

                    $image = $suministro['Imagen'] == null ? null : base64_decode($suministro['Imagen']);

                    $cmdSuministro = Database::getInstance()->getDb()->prepare("INSERT INTO SuministroTB(
                    IdSuministro,
                    Origen,
                    Clave,
                    ClaveAlterna,
                    NombreMarca,
                    NombreGenerico,

                    Categoria,
                    Marca,
                    Presentacion,
                    UnidadCompra,
                    UnidadVenta,

                    Estado,
                    StockMinimo,
                    StockMaximo,
                    Cantidad,

                    Impuesto,
                    TipoPrecio,
                    PrecioCompra,
                    PrecioVentaGeneral,
                    Lote,
                    Inventario,
                    ValorInventario,
                    Imagen,
                    ClaveSat,
                    NuevaImagen)
                    VALUES(
                        ?,--ID SUMINISTROS
                        1,--ORIGREN
                        ?,--CLAVE
                        ?,--CLAVE ALTERNA
                        UPPER(?),--NOMBRE MARCA
                        UPPER(?),--NOMBRE GENERICO
                        ?,--CATEGORIA
                        ?,--MARCA
                        ?,--PRESENTACION
                        ?,--UNIDAD COMPRA
                        ?,--UNIDAD VENTA
                        ?,--ESTADO
                        ?,--STOCKMINIMO
                        ?,--STOCKMAXIMO
                        ?,--CANTIDAD
                        ?,--IMPUESTO
                        ?,--TIPO PRECIO
                        ?,--PRECIO COMPRA
                        ?,--PRECIO VENTA GENERAL
                        ?,--LOTE
                        1,--INVENTARIO
                        ?,--VALOR INVENTARIO
                        '',
                        ?,--CLAVE
                        ?--NUEVA IMAGEN
                        )");

                    $cmdSuministro->bindParam(1, $idSuministro, PDO::PARAM_STR);
                    $cmdSuministro->bindParam(2, $suministro["Clave"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(3, $suministro["ClaveAlterna"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(4, $suministro["NombreMarca"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(5, $suministro["NombreGenerico"], PDO::PARAM_STR);

                    $cmdSuministro->bindParam(6, $suministro["Categoria"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(7, $suministro["Marca"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(8, $suministro["Presentacion"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(9, $suministro["UnidadCompra"], PDO::PARAM_INT);
                    $cmdSuministro->bindParam(10, $suministro["UnidadVenta"], PDO::PARAM_INT);

                    $cmdSuministro->bindParam(11, $suministro["Estado"], PDO::PARAM_INT);
                    $cmdSuministro->bindParam(12, $suministro["StockMinimo"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(13, $suministro["StockMaximo"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(14, $suministro["Cantidad"], PDO::PARAM_STR);

                    $cmdSuministro->bindParam(15, $suministro["Impuesto"], PDO::PARAM_INT);
                    $cmdSuministro->bindParam(16, $suministro["TipoPrecio"], PDO::PARAM_BOOL);
                    $cmdSuministro->bindParam(17, $suministro["PrecioCompra"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(18, $suministro["PrecioVentaGeneral"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(19, $suministro["Lote"], PDO::PARAM_BOOL);
                    $cmdSuministro->bindParam(20, $suministro["ValorInventario"], PDO::PARAM_BOOL);

                    $cmdSuministro->bindParam(21, $suministro["ClaveUnica"], PDO::PARAM_STR);
                    $cmdSuministro->bindParam(22, $image,  PDO::PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
                    $cmdSuministro->execute();

                    $cmdPrecios = Database::getInstance()->getDb()->prepare("INSERT INTO PreciosTB(IdArticulo, IdSuministro, Nombre, Valor, Factor, Estado) VALUES(?,?,?,?,?,?)");
                    foreach ($suministro["ListaPrecios"] as $value) {
                        $cmdPrecios->execute(array(
                            "",
                            $idSuministro,
                            $value["nombre"],
                            $value["valor"],
                            ($value["factor"] <= 0 ? 1 : $value["factor"]),
                            true
                        ));
                    }

                    Database::getInstance()->getDb()->commit();
                    return "registrado";
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function ObtenerDetalleId($opcion, $idMantenimiento, $nombre)
    {
        try {
            $array = array();
            $cmdDetalle = Database::getInstance()->getDb()->prepare("{CALL Sp_Get_Detalle_IdNombre(?,?,?)}");
            $cmdDetalle->bindParam(1, $opcion, PDO::PARAM_INT);
            $cmdDetalle->bindParam(2, $idMantenimiento, PDO::PARAM_STR);
            $cmdDetalle->bindParam(3, $nombre, PDO::PARAM_STR);
            $cmdDetalle->execute();
            while ($row = $cmdDetalle->fetch()) {
                array_push($array, array(
                    "IdDetalle" => $row["IdDetalle"],
                    "Nombre" => $row["Nombre"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
