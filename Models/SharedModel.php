<?php
class SharedModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSharedFiles($usuario)
    {
        $sql = "SELECT d.id, d.usuario, a.nombre AS archivo, u.nombre FROM detalle_archivos d INNER JOIN archivos a ON d.id_archivo = a.id INNER JOIN usuarios u ON d.id_usuario = u.id WHERE d.usuario = '$usuario'  AND d.estado != 0 ORDER BY d.id DESC";
        return $this->selectAll($sql);
    }

    public function getDetalle($id_detalle)
    {
        $sql = "SELECT d.id, d.fecha_add, d.usuario, a.nombre, a.tipo, a.id_carpeta, u.usuario AS compartido, u.nombre AS usuario, u.apellido FROM detalle_archivos d INNER JOIN archivos a ON d.id_archivo = a.id INNER JOIN carpetas c ON a.id_carpeta = c.id INNER JOIN usuarios u ON d.id_usuario = u.id WHERE d.id = $id_detalle";
        return $this->select($sql);
    }

    public function cambiarestado($estado, $id)
    {
        $sql = "UPDATE detalle_archivos SET estado = ? WHERE id = ?";
        return $this->save($sql, [$estado, $id]);
    }

    //view "total" of shared files
    public function verificarEstado($usuario)
    {
        $sql = "SELECT COUNT(id) AS total FROM detalle_archivos WHERE usuario = '$usuario' AND estado = 1";
        return $this->select($sql);
    }
}
