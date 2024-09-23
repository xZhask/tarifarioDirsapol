<?php
require_once 'conexion.php';

class ClsProcedimiento
{
    function CargarTarifario($nvl)
    {
        $sql = 'SELECT p.cpms,p.descripcion_cpms,t.precio,t.nivel FROM tarifario t INNER JOIN procedimiento p ON p.id_cpms=t.id_cpms WHERE t.nivel=:nivel';
        global $cnx;
        $parametros = [
            ':nivel' => $nvl
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
