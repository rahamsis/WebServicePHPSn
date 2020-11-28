<?php

require '../../database/DataBaseConexion.php';

class VentasADO {

    function construct() {
        
    }

    public static function ListVentas($opcion, $value, $fechaInicial, $fechaFinal, $comprobante, $estado, $usuario, $posicionPagina, $filasPorPagina, $ruc) {
        $array = array();
        try {
            $comandoVenta = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Ventas(?,?,?,?,?,?,?,?,?)}");
            $comandoVenta->bindParam(1, $opcion, PDO::PARAM_INT);
            $comandoVenta->bindParam(2, $value, PDO::PARAM_STR);
            $comandoVenta->bindParam(3, $fechaInicial, PDO::PARAM_STR);
            $comandoVenta->bindParam(4, $fechaFinal, PDO::PARAM_STR);
            $comandoVenta->bindParam(5, $comprobante, PDO::PARAM_INT);
            $comandoVenta->bindParam(6, $estado, PDO::PARAM_INT);
            $comandoVenta->bindParam(7, $usuario, PDO::PARAM_STR);
            $comandoVenta->bindParam(8, $posicionPagina, PDO::PARAM_INT);
            $comandoVenta->bindParam(9, $filasPorPagina, PDO::PARAM_INT);
            $comandoVenta->execute();
            $arrayVenta = array();
            $count = 0;
            while ($row = $comandoVenta->fetch()) {
                $count++;
                array_push($arrayVenta, array(
                    "id" => $count + $posicionPagina,
                    "IdVenta" => $row["IdVenta"],
                    "FechaVenta" => $row["FechaVenta"],
                    "HoraVenta" => $row["HoraVenta"],
                    "ApellidosVendedor" => $row["ApellidosVendedor"],
                    "NombresVendedor" => $row["NombresVendedor"],
                    "DocumentoCliente" => $row["DocumentoCliente"],
                    "Cliente" => $row["Cliente"],
                    "Comprobante" => $row["Comprobante"],
                    "TipoComprobante" => $row['TipoComprobante'],
                    "Serie" => $row["Serie"],
                    "Numeracion" => $row["Numeracion"],
                    "Tipo" => $row["Tipo"],
                    "Estado" => $row["Estado"],
                    "Simbolo" => $row["Simbolo"],
                    "NombreMoneda" => $row["NombreMoneda"],
                    "TipoMoneda" => $row["TipoMoneda"],
                    "Total" => $row["Total"],
                    "Observaciones" => $row["Observaciones"],
                    "Xmlsunat" => $row["Xmlsunat"],
                    "Xmldescripcion" => VentasADO::limitar_cadena($row["Xmldescripcion"], 60, "...")
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Ventas_Count(?,?,?,?,?,?,?)}");
            $comandoTotal->bindParam(1, $opcion, PDO::PARAM_INT);
            $comandoTotal->bindParam(2, $value, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $fechaInicial, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->bindParam(5, $comprobante, PDO::PARAM_INT);
            $comandoTotal->bindParam(6, $estado, PDO::PARAM_INT);
            $comandoTotal->bindParam(7, $usuario, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal = $comandoTotal->fetchColumn();

            $comandoSuma = Database::getInstance()->getDb()->prepare("SELECT ISNULL(SUM(Total),0) FROM VentaTB WHERE CAST(FechaVenta AS DATE) BETWEEN ? AND ? AND Estado <> 3 ");
            $comandoSuma->bindParam(1, $fechaInicial, PDO::PARAM_STR);
            $comandoSuma->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $comandoSuma->execute();
            $resultSuma = $comandoSuma->fetchColumn();

            array_push($array, $arrayVenta, $resultTotal, $resultSuma);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    private static function limitar_cadena($cadena, $limite, $sufijo) {
        if (strlen($cadena) > $limite) {
            return substr($cadena, 0, $limite) . $sufijo;
        }
        return $cadena;
    }

    public static function ListVentaDetalle($idventa) {
        try {
            $array = array();
            $venta = null;
            $ventadetalle = array();
            
            $comandoVenta = Database::getInstance()->getDb()->prepare("{CALL Sp_Obtener_Venta_ById(?)}");
            $comandoVenta->bindParam(1, $idventa, PDO::PARAM_STR);
            $comandoVenta->execute();
            $venta = $comandoVenta->fetchObject(); 
            
            $comandoVentaDetalle = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Ventas_Detalle_By_Id(?)}");
            $comandoVentaDetalle->bindParam(1, $idventa, PDO::PARAM_STR);
            $comandoVentaDetalle->execute();
            $count = 0;
            while ($row = $comandoVentaDetalle->fetch()) {
                $count++;
                array_push($ventadetalle, array(
                    "id" => $count,
                    "IdSuministro" => $row["IdSuministro"],
                    "Clave" => $row["Clave"],
                    "NombreMarca" => $row["NombreMarca"],
                    "Inventario" => $row["Inventario"],
                    "ValorInventario" => $row["ValorInventario"],
                    "ClaveSat" => $row["ClaveSat"],
                    "CodigoUnidad" => $row["CodigoUnidad"],
                    "UnidadCompra" => $row["UnidadCompra"],
                    "Cantidad" => $row["Cantidad"],
                    "CantidadGranel" => $row["CantidadGranel"],
                    "CostoVenta" => $row["CostoVenta"],
                    "PrecioVenta" => $row["PrecioVenta"],
                    "Descuento" => $row["Descuento"],
                    "DescuentoCalculado" => $row["DescuentoCalculado"],
                    "IdImpuesto" => $row["IdImpuesto"],
                    "NombreImpuesto" => $row["NombreImpuesto"],
                    "ValorImpuesto" => $row["ValorImpuesto"],
                    "Codigo" => $row["Codigo"],
                    "Numeracion" => $row["Numeracion"],
                    "NombreImpuesto" => $row["NombreImpuesto"],
                    "Letra" => $row["Letra"],
                    "Categoria" => $row["Categoria"],
                    "Importe" => $row["Importe"]
                ));
            }
            array_push($array, $venta, $ventadetalle);
            return $array;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function LoadDashboard($fecha) {

        $array = array();

        $queryNumeroVentas = "select count(*) from VentaTB where FechaVenta = ? and Estado = 1";
        $queryTotalVentas = "select sum(Total) from VentaTB where FechaVenta = ? and Estado = 1";
        $queryNumeroVentasAnuladas = "select COUNT(*) from VentaTB where FechaVenta = ? AND Estado = 3";
        $queryTotalVentasAnuladas = "select sum(Total) from VentaTB where FechaVenta = ? And Estado = 3";
        $queryNumeroCompras = "select count (*) from CompraTB where FechaCompra = ?";
        $queryTotalCompras = "select sum(Total) from CompraTB where FechaCompra = ? AND EstadoCompra = 1";

        //prodcutos mas vendidos
        $queryProductosMasVendidos = "select Top 10 dt.IdArticulo, s.NombreMarca, s.NuevaImagen as NuevaImagen,dt.PrecioVenta, SUM(dt.Cantidad) as Cantidad
        from DetalleVentaTB as dt 
        inner join SuministroTB as s on dt.IdArticulo=s.IdSuministro 
        inner join VentaTB as v on v.IdVenta=dt.IdVenta
        where MONTH(v.FechaVenta) = MONTH(GETDATE()) AND YEAR(v.FechaVenta) = YEAR(getdate())
        group by dt.IdArticulo, s.NombreMarca, NuevaImagen,dt.PrecioVenta  order by Cantidad DESC";

        //diagrama de linea
        $queryDiagramaLinea = "select vt.FechaVenta, ct.FechaCompra, sum(vt.Total) as TotalVenta, sum(ct.Total) as TotalCompra from VentaTB as vt 
        left join CompraTb as ct on vt.FechaVenta=ct.FechaCompra
        where vt.FechaVenta between dateadd(week, datediff(day, 0, getdate())/7, 0) and dateadd(week, datediff(day, 0, getdate())/7, 6)
        group by vt.FechaVenta, ct.FechaCompra";

        //productos por agotarse
        $queryProductosAgotados = "select NombreMarca, PrecioVentaGeneral, Cantidad from SuministroTB where Cantidad <= 0 order by Cantidad asc";

        //productos por agotarse
        $queryProductosPorAgotarse = "select top 10 NombreMarca, PrecioVentaGeneral, Cantidad from SuministroTB
        where Cantidad > 0 and Cantidad < StockMinimo order by cantidad asc";

        try {
            $comandoNumeroVentas = Database::getInstance()->getDb()->prepare($queryNumeroVentas);
            $comandoNumeroVentas->bindParam(1, $fecha, PDO::PARAM_STR);
            $comandoNumeroVentas->execute();

            $comandoTotalVentas = Database::getInstance()->getDb()->prepare($queryTotalVentas);
            $comandoTotalVentas->bindParam(1, $fecha, PDO::PARAM_STR);
            $comandoTotalVentas->execute();

            $comandoNumeroVentasAnuladas = Database::getInstance()->getDb()->prepare($queryNumeroVentasAnuladas);
            $comandoNumeroVentasAnuladas->bindParam(1, $fecha, PDO::PARAM_STR);
            $comandoNumeroVentasAnuladas->execute();

            $comandoTotalVentasAnuladas = Database::getInstance()->getDb()->prepare($queryTotalVentasAnuladas);
            $comandoTotalVentasAnuladas->bindParam(1, $fecha, PDO::PARAM_STR);
            $comandoTotalVentasAnuladas->execute();

            $comandoNumeroCompras = Database::getInstance()->getDb()->prepare($queryNumeroCompras);
            $comandoNumeroCompras->bindParam(1, $fecha, PDO::PARAM_STR);
            $comandoNumeroCompras->execute();

            $comandoTotalCompras = Database::getInstance()->getDb()->prepare($queryTotalCompras);
            $comandoTotalCompras->bindParam(1, $fecha, PDO::PARAM_STR);
            $comandoTotalCompras->execute();

            $comandoProductosMasVendidos = Database::getInstance()->getDb()->prepare($queryProductosMasVendidos);
            $comandoProductosMasVendidos->execute();

            $arrayProductosMasVendidos = array();
            while ($rows = $comandoProductosMasVendidos->fetch()) {
                array_push($arrayProductosMasVendidos, array(
                    "IdArticulo" => $rows["IdArticulo"],
                    "NombreMarca" => $rows["NombreMarca"],
                    "Cantidad" => $rows["Cantidad"],
                    "PrecioVenta" => $rows["PrecioVenta"],
                    "Imagen" => ($rows["NuevaImagen"] != null ? base64_encode($rows["NuevaImagen"]) : '')
                ));
            }

            $comandoDiagramaLinea = Database::getInstance()->getDb()->prepare($queryDiagramaLinea);
            $comandoDiagramaLinea->execute();

            $arrayDiagramaLinea = array();
            while ($rows = $comandoDiagramaLinea->fetch()) {
                array_push($arrayDiagramaLinea, array(
                    "FechaIngreso" => $rows["FechaVenta"],
                    "Valor1" => $rows["TotalVenta"],
                    "Valor2" => $rows["TotalCompra"],
                ));
            }

            $comandoProductosAgotados = Database::getInstance()->getDb()->prepare($queryProductosAgotados);
            $comandoProductosAgotados->execute();

            $arrayProductosAgotados = array();
            while ($rows = $comandoProductosAgotados->fetch()) {
                array_push($arrayProductosAgotados, array(
                    "NombreProducto" => $rows["NombreMarca"],
                    "Pecio" => $rows["PrecioVentaGeneral"],
                    "Cantidad" => $rows["Cantidad"],
                ));
            }

            $comandoProductosPorAgotarse = Database::getInstance()->getDb()->prepare($queryProductosPorAgotarse);
            $comandoProductosPorAgotarse->execute();

            $arrayProductosPorAgotarse = array();
            while ($rows = $comandoProductosPorAgotarse->fetch()) {
                array_push($arrayProductosPorAgotarse, array(
                    "NombreProducto" => $rows["NombreMarca"],
                    "Pecio" => $rows["PrecioVentaGeneral"],
                    "Cantidad" => $rows["Cantidad"],
                ));
            }
            //las variables que creo aquí no afectan en nada a la vista solo son refenrenciales para la vista
            //
            array_push($array, array(
                "numeroVentas" => $comandoNumeroVentas->fetchColumn(),
                "TotalVentas" => $comandoTotalVentas->fetchColumn(),
                "NumeroVentasAnuladas" => $comandoNumeroVentasAnuladas->fetchColumn(),
                "TotalVentasAnuladas" => $comandoTotalVentasAnuladas->fetchColumn(),
                "NumeroCompras" => $comandoNumeroCompras->fetchColumn(),
                "TotalCompras" => $comandoTotalCompras->fetchColumn(),
                "ProductosMasVendidos" => $arrayProductosMasVendidos,
                "DiagramaLinea" => $arrayDiagramaLinea,
                "ProductosAgotados" => $arrayProductosAgotados,
                "ProductosPorAgotarse" => $arrayProductosPorAgotarse
            ));

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }       
    }

    public static function ListarDiagramaLinea($fecha) {

        $array = array();

        try {
            $queryDiagramaLinea = "select vt.FechaVenta, ct.FechaCompra, sum(vt.Total) as TotalVenta, sum(ct.Total) as TotalCompra from VentaTB as vt 
            left join CompraTb as ct on vt.FechaVenta=ct.FechaCompra
            where vt.FechaVenta between dateadd(week, datediff(day, 0, getdate())/7, 0) and dateadd(week, datediff(day, 0, getdate())/7, 6)
            group by vt.FechaVenta, ct.FechaCompra";
            $queryDiagramaLineaMes = "select vt.FechaVenta, ct.FechaCompra, sum(vt.Total) as TotalVenta, sum(ct.Total) as TotalCompra from VentaTB as vt 
            left join CompraTb as ct on vt.FechaVenta=ct.FechaCompra
            where MONTH(vt.FechaVenta) = MONTH(GETDATE()) AND YEAR(vt.FechaVenta) = YEAR(getdate())
            group by vt.FechaVenta, ct.FechaCompra";

            $comandoDiagramaLinea = Database::getInstance()->getDb()->prepare($queryDiagramaLinea);
            $comandoDiagramaLinea->execute();

            $arrayDiagramaLinea = array();
            while ($rows = $comandoDiagramaLinea->fetch()) {
                array_push($arrayDiagramaLinea, array(
                    "FechaIngreso" => $rows["FechaVenta"],
                    "Valor1" => $rows["TotalVenta"],
                    "Valor2" => $rows["TotalCompra"],
                ));
            }

            $comandoDiagramaLineaMes = Database::getInstance()->getDb()->prepare($queryDiagramaLineaMes);
            $comandoDiagramaLineaMes->execute();

            $arrayDiagramaLineaMes = array();
            while ($rows = $comandoDiagramaLineaMes->fetch()) {
                array_push($arrayDiagramaLineaMes, array(
                    "FechaIngreso" => $rows["FechaVenta"],
                    "Valor1" => $rows["TotalVenta"],
                    "Valor2" => $rows["TotalCompra"],
                ));
            }

            array_push($array, array(
                "DiagramaLinea" => $arrayDiagramaLinea,
                "DiagramaLineaMes" => $arrayDiagramaLineaMes
            ));
        } catch (Exception $ex) {
            array_push($array, array(
                "DiagramaLinea" => 0,
                "DiagramaLineaMes" => 0
            ));
        }

        return $array;
    }

    public static function ListarDetalleVentPorId($idVenta) {
        $lista = array();
        $resultVenta = null;
        $detalleventa = array();
        $totalsinimpuesto = 0;
        $numeroitems = 0;
        $impuesto = 0;
        $resultEmpresa = null;
        $resultCliente = null;

        try {
            $cmdVenta = Database::getInstance()->getDb()->prepare("SELECT 
                dbo.Fc_Obtener_Nombre_Moneda(v.Moneda) as NombreMoneda,
		dbo.Fc_Obtener_Abreviatura_Moneda(v.Moneda) as TipoMoneda,
                td.CodigoAlterno as TipoComprobante,
                v.Serie,v.Numeracion,v.FechaVenta,v.HoraVenta
                FROM VentaTB as v inner join TipoDocumentoTB as td 
                on v.Comprobante = td.IdTipoDocumento
                WHERE v.IdVenta = ?");
            $cmdVenta->bindParam(1, $idVenta, PDO::PARAM_STR);
            $cmdVenta->execute();
            $resultVenta = $cmdVenta->fetchObject();

            $cmdDetail = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Ventas_Detalle_By_Id(?)}");
            $cmdDetail->bindParam(1, $idVenta, PDO::PARAM_STR);
            $cmdDetail->execute();
            $count = 0;

            while ($rowdetailt = $cmdDetail->fetch()) {
                $count++;
                $numeroitems++;
                array_push($detalleventa, array(
                    "Id" => $count,
                    "Clave" => $rowdetailt["Clave"],
                    "NombreMarca" => $rowdetailt["NombreMarca"],
                    "ClaveSat" => $rowdetailt["ClaveSat"],
                    "CodigoUnidad" => $rowdetailt["CodigoUnidad"],
                    "Cantidad" => $rowdetailt["Cantidad"],
                    "PrecioVenta" => $rowdetailt["PrecioVenta"],
                    "Descuento" => $rowdetailt["Descuento"],
                    "ValorImpuesto" => $rowdetailt["ValorImpuesto"],
                    "Codigo" => $rowdetailt["Codigo"],
                    "Numeracion" => $rowdetailt["Numeracion"],
                    "NombreImpuesto" => $rowdetailt["NombreImpuesto"],
                    "Letra" => $rowdetailt["Letra"],
                    "Categoria" => $rowdetailt["Categoria"]
                ));
            }

            foreach ($detalleventa as $key => $value) {
                $totalsinimpuesto += $value['Cantidad'] * $value['PrecioVenta'];
                $impuesto += $value['Cantidad'] * ($value['PrecioVenta'] * ($value['ValorImpuesto'] / 100.00));
            }

            $cmdEmpresa = Database::getInstance()->getDb()->prepare("SELECT TOP 1 
            d.IdAuxiliar,e.NumeroDocumento,e.RazonSocial,e.NombreComercial,e.Domicilio,
            dbo.Fc_Obtener_Ubigeo(Ubigeo) as CodigoUbigeo,
            dbo.Fc_Obtener_Departamento(Ubigeo) as Departamento,
            dbo.Fc_Obtener_Provincia(Ubigeo) as Provincia,
            dbo.Fc_Obtener_Distrito(Ubigeo) as Distrito,
            e.UsuarioSol,e.ClaveSol 
            FROM EmpresaTB AS e INNER JOIN DetalleTB AS d ON e.TipoDocumento = d.IdDetalle AND d.IdMantenimiento = '0003'");
            $cmdEmpresa->execute();
            $resultEmpresa = $cmdEmpresa->fetchObject();

            $cmdCliente = Database::getInstance()->getDb()->prepare("SELECT d.IdAuxiliar,c.NumeroDocumento,c.Informacion
            FROM ClienteTB AS c INNER JOIN VentaTB AS v ON c.IdCliente = v.Cliente
            INNER JOIN DetalleTB as d on c.TipoDocumento = d.IdDetalle and d.IdMantenimiento = '0003'
            WHERE v.IdVenta = ? ");
            $cmdCliente->bindParam(1, $idVenta, PDO::PARAM_STR);
            $cmdCliente->execute();
            $resultCliente = $cmdCliente->fetchObject();
        } catch (Exception $ex) {
            
        }

        array_push($lista, array(
            "totalsinimpuesto" => $totalsinimpuesto,
            "totalimpuesto" => $impuesto,
            "totalconimpuesto" => $totalsinimpuesto + $impuesto,
            "numeroitems" => $numeroitems,
            "detalle" => $detalleventa
                ), $resultEmpresa, $resultCliente, $resultVenta);

        return $lista;
    }

    public static function CambiarEstadoSunatVenta($idVenta, $codigo, $descripcion) {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE VentaTB SET 
            Xmlsunat = ? , Xmldescripcion = ? WHERE IdVenta = ?");
            $comando->bindParam(1, $codigo, PDO::PARAM_STR);
            $comando->bindParam(2, $descripcion, PDO::PARAM_STR);
            $comando->bindParam(3, $idVenta, PDO::PARAM_STR);
            $comando->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function GetReporteGenetalVentas($fechaInicial, $fechaFinal, $tipoDocumento, $cliente, $vendedor) {
        $array = [];
        try {
            $comando = Database::getInstance()->getDb()->prepare("{CALL Sp_Reporte_General_Ventas(?,?,?,?,?)}");
            $comando->bindParam(1, $fechaInicial, PDO::PARAM_STR);
            $comando->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $comando->bindParam(3, $tipoDocumento, PDO::PARAM_INT);
            $comando->bindParam(4, $cliente, PDO::PARAM_STR);
            $comando->bindParam(5, $vendedor, PDO::PARAM_STR);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "Id" => $count,
                    "Nombre" => $row["Nombre"],
                    "Serie" => $row["Serie"],
                    "Numeracion" => $row["Numeracion"],
                    "FechaVenta" => $row["FechaVenta"],
                    "TipoDocumento" => $row["TipoDocumento"],
                    "NumeroDocumento" => $row["NumeroDocumento"],
                    "Cliente" => $row["Cliente"],
                    "Tipo" => $row["Tipo"],
                    "EstadoName" => $row["EstadoName"],
                    "Simbolo" => $row["Simbolo"],
                    "Estado" => $row["Estado"],
                    "Total" => $row["Total"]
                ));
            }
        } catch (Exception $ex) {
            
        }
        return $array;
    }
    
     public static function CambiarEstadoSunatResumen($idVenta, $codigo, $descripcion, $hash)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE Ingreso SET 
            Xmlsunat = ? , Xmldescripcion = ?, CodigoHash = ? WHERE idIngreso = ?");
            $comando->bindParam(1, $codigo, PDO::PARAM_STR);
            $comando->bindParam(2, $descripcion, PDO::PARAM_STR);
            $comando->bindParam(3, $hash, PDO::PARAM_STR);
            $comando->bindParam(4, $idVenta, PDO::PARAM_STR);
            $comando->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

}
