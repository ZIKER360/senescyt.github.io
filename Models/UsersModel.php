<?php
class UsersModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    function getUsers()
    {
        $sql = "SELECT id, nombre, apellido, usuario, celular, password, rol, perfil, fecha FROM usuarios WHERE estado = 1";
        return $this->selectAll($sql);
    }

    function getCheck($item, $nombre, $id)
    {
        if ($id > 0) {
            $sql = "SELECT id FROM usuarios WHERE $item = '$nombre' AND id != $id AND estado = 1";
        } else {
            $sql = "SELECT id FROM usuarios WHERE $item = '$nombre' AND estado = 1";
        }
        return $this->select($sql);
    }

    public function register($nombre, $apellido, $usuario, $celular, $password, $rol)
    {
        $sql = "INSERT INTO usuarios (nombre, apellido, usuario, celular, password, rol) VALUES (?,?,?,?,?,?)";
        $data = array($nombre, $apellido, $usuario, $celular, $password, $rol);
        return $this->insert($sql, $data);
    }

    public function delete($id)
    {
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
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

    //view "total" of shared files
    public function verificarEstado($usuario)
    {
        $sql = "SELECT COUNT(id) AS total FROM detalle_archivos WHERE usuario = '$usuario' AND estado = 1";
        return $this->select($sql);
    }

    public function cambiarPass($password, $id)
    {
        $sql = "UPDATE usuarios SET password=? WHERE id=?";
        $data = array($password, $id);
        return $this->save($sql, $data);
    }
}
