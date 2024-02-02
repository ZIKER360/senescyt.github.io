<?php
class FilesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    function getArchivos($estado, $id_usuario)
    {
        $sql = "SELECT a.* FROM archivos a INNER JOIN carpetas c ON a.id_carpeta = c.id WHERE c.id_usuario = $id_usuario AND a.estado = $estado ORDER BY a.id DESC LIMIT 6";
        return $this->selectAll($sql);
    }

    public function getCarpetas($id_usuario)
    {
        $sql = "SELECT * FROM carpetas WHERE id_usuario = $id_usuario AND estado = 1 ORDER BY id DESC";
        return $this->selectAll($sql);
    }

    public function getUsers($valor, $id_usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario LIKE '%" . $valor . "%' AND id != $id_usuario AND estado = 1 LIMIT 10";
        return $this->selectAll($sql);
    }

    public function getUser($id_usuario)
    {
        $sql = "SELECT usuario FROM usuarios WHERE id = $id_usuario";
        return $this->select($sql);
    }

    public function recordDetail($usuario, $id_file, $id_usuario)
    {
        $sql = "INSERT INTO detalle_archivos (usuario, id_archivo, id_usuario) VALUES (?,?,?)";
        $array = [$usuario, $id_file, $id_usuario];
        return $this->insert($sql, $array);
    }

    public function getDetail($usuario, $id_file)
    {
        $sql = "SELECT id FROM detalle_archivos WHERE usuario = '$usuario' AND id_archivo = $id_file ";
        return $this->select($sql);
    }

    public function getFiles($id_folder)
    {
        $sql = "SELECT * FROM archivos WHERE id_carpeta = $id_folder";
        return $this->selectAll($sql);
    }

    public function eliminarCompartido($fecha, $id)
    {
        $sql = "UPDATE detalle_archivos SET estado = ?, elimina = ? WHERE id = ?";
        $array = [0, $fecha, $id];
        return $this->save($sql, $array);
    }

    public function getCarpeta($id_file)
    {
        $sql = "SELECT id, id_carpeta FROM archivos WHERE id = $id_file";
        return $this->select($sql);
    }

    public function eliminar($estado, $fecha, $id)
    {
        $sql = "UPDATE archivos SET estado = ?, elimina = ? WHERE id = ?";
        $array = [$estado, $fecha, $id];
        return $this->save($sql, $array);
    }

    //view "total" of shared files
    public function verificarEstado($usuario)
    {
        $sql = "SELECT COUNT(id) AS total FROM detalle_archivos WHERE usuario = '$usuario' AND estado = 1";
        return $this->select($sql);
    }

    public function getBusqueda($valor, $id_usuario)
    {
        $sql = "SELECT * FROM archivos WHERE nombre LIKE '%". $valor ."%' AND id_usuario = $id_usuario AND estado = 1 LIMIT 10";
        return $this->selectAll($sql);
    }
}
