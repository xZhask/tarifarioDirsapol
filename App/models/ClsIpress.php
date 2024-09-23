<?php
require_once 'conexion.php';

class ClsIpress
{
    function ListarIpress()
    {
        $sql = 'SELECT id_ipress as idIpress,nombreIpress,nivelIpress as nivel FROM ipress';
        global $cnx;
        return $cnx->query($sql);
    }
}
