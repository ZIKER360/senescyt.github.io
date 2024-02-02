<?php
class AdminModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    function getCarpetas($id_usuario)
    {
        $sql = "SELECT * FROM carpetas WHERE id_usuario = $id_usuario AND estado = 1 AND id != 1 ORDER BY id DESC LIMIT 6";
        return $this->selectAll($sql);
    }

    function getCheck($item, $nombre, $id_usuario, $id)
    {
        if ($id > 0) {
            $sql = "SELECT id FROM carpetas WHERE $item = '$nombre' AND id_usuario = $id_usuario AND id != $id AND estado = 1";
        } else {
            $sql = "SELECT id FROM carpetas WHERE $item = '$nombre' AND id_usuario = $id_usuario AND estado = 1";
        }
        return $this->select($sql);
    }

    public function crearcarpeta($nombre, $id_usuario)
    {
        $sql = "INSERT INTO carpetas (nombre, id_usuario) VALUES (?,?)";
        $data = array($nombre, $id_usuario);
        return $this->insert($sql, $data);
    }

    public function delete($id)
    {
        $sql = "UPDATE carpetas SET estado = ? WHERE id = ?";
        $data = array(0, $id);
        return $this->save($sql, $data);
    }

    public function getUser($id)
    {
        $sql = "SELECT id, nombre, apellido, usuario, celular, password, rol, perfil, fecha FROM usuarios WHERE id = $id";
        return $this->select($sql);
    }

    public function modify($nombre, $apellido, $usuario, $celular, $rol, $id)
    {
        $sql = "UPDATE usuarios SET nombre=?, apellido=?, usuario=?, celular=?, rol=? WHERE id=?";
        $data = array($nombre, $apellido, $usuario, $celular, $rol, $id);
        return $this->save($sql, $data);
    }

    //upload file
    public function subirArchivo($name, $tipo, $id_carpeta, $id_usuario)
    {
        $sql = "INSERT INTO archivos (nombre, tipo, id_carpeta, id_usuario) VALUES (?,?,?,?)";
        $data = array($name, $tipo, $id_carpeta, $id_usuario);
        return $this->insert($sql, $data);
    }

    function getArchivosRecientes($id_usuario)
    {
        $sql = "SELECT * FROM archivos WHERE id_usuario = $id_usuario AND estado = 1 ORDER BY id DESC LIMIT 6";
        return $this->selectAll($sql);
    }

    function getArchivos($id_folder, $id_usuario)
    {
        $sql = "SELECT a.* FROM archivos a INNER JOIN carpetas c ON a.id_carpeta = c.id WHERE a.id_carpeta = $id_folder AND c.id_usuario = $id_usuario ORDER BY a.id DESC";
        return $this->selectAll($sql);
    }

    public function getDetails($id_carpeta)
    {
        $sql = "SELECT d.id, d.usuario, d.estado, d.elimina, a.nombre FROM detalle_archivos d INNER JOIN archivos a ON d.id_archivo = a.id INNER JOIN carpetas c ON a.id_carpeta = c.id WHERE a.id_carpeta = $id_carpeta";
        return $this->selectAll($sql);
    }

    public function getCarpeta($id)
    {
        $sql = "SELECT * FROM carpetas WHERE id = $id";
        return $this->select($sql);
    }

    //view "total" of shared files
    public function verificarEstado($usuario)
    {
        $sql = "SELECT COUNT(id) AS total FROM detalle_archivos WHERE usuario = '$usuario' AND estado = 1";
        return $this->select($sql);
    }

    // permanently delete files
    public function getConsulta()
    {
        $sql = "SELECT * FROM archivos WHERE estado = 0";
        return $this->selectAll($sql);   
    }

    public function eliminarRegistro($id_archivo)
    {
        $sql = "DELETE FROM archivos WHERE id = ?";
        $datos = array($id_archivo);
        return $this->save($sql, $datos);
    }
}