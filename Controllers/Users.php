<?php
class Users extends Controller
{
    private $id_usuario, $usuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_usuario = $_SESSION['id'];
        $this->usuario = $_SESSION['usuario'];
        //validar session
        if (empty($_SESSION['id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'Gestión de Usuarios';
        $data['script'] = 'users.js';
        $data['menu'] = 'users';
        $this->usuario = $_SESSION['usuario'];
        $data['shares'] = $this->model->verificarEstado($this->usuario);
        $this->views->getView('users', 'index', $data);
    }

    function list()
    {
        $data = $this->model->getUsers();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['id'] == 1) {
                $data[$i]['shares'] = 'Admin';
            } else {
                $data[$i]['shares'] = '<div>
                    <a href="#" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">
                        <i class="material-icons">edit</i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">
                        <i class="material-icons">delete</i>
                    </a>
                </div>';
            }
            $data[$i]['nombres'] = $data[$i]['nombre'] . ' ' . $data[$i]['apellido'];
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function guardar()
    {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = $_POST['usuario'];
        $celular = $_POST['celular'];
        $password = $_POST['password'];
        $rol = $_POST['rol'];
        $id_user = $_POST['id_user'];
        if (
            empty($nombre) || empty($apellido)
            || empty($usuario) || empty($celular)
            || empty($password) || empty($rol)
        ) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
        } else {
            if ($id_user == '') {
                //Check for existing data
                //Check if the user exists
                $chekUser = $this->model->getCheck('usuario', $usuario, 0);

                if (empty($chekUser)) {
                    //Comprobar si el número de móvil existe
                    $chekCell = $this->model->getCheck('celular', $celular, 0);
                    if (empty($chekCell)) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $data = $this->model->register($nombre, $apellido, $usuario, $celular, $hash, $rol);
                        if ($data > 0) {
                            $res = array('tipo' => 'success', 'mensaje' => 'El usuario ha sido registrado');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar al Usuario');
                        }
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El número de celular ya existe');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El usuario ya existe');
                }
            } else {
                //Check for existing data
                //Check if the user exists
                $chekUser = $this->model->getCheck('usuario', $usuario, $id_user);

                if (empty($chekUser)) {
                    //Comprobar si el número de móvil existe
                    $chekCell = $this->model->getCheck('celular', $celular, $id_user);
                    if (empty($chekCell)) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $data = $this->model->modify($nombre, $apellido, $usuario, $celular, $rol, $id_user);
                        if ($data == 1) {
                            $res = array('tipo' => 'success', 'mensaje' => 'El usuario ha sido modificado');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar al Usuario');
                        }
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El número de celular ya existe');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El usuario ya existe');
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id)
    {
        $data = $this->model->delete($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'El usuario ha sido eliminado correctamente');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar al usuario');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit($id)
    {
        $data = $this->model->getUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function profile()
    {
        $data['title'] = 'Perfil del usuario';
        $data['script'] = 'profile.js';
        $data['menu'] = 'users';
        $data['usuario'] = $this->model->getUser($this->id_usuario);
        $data['shares'] = $this->model->verificarEstado($this->usuario);
        $this->views->getView('users', 'perfil', $data);
    }

    public function cambiarPass()
    {
        $actual = $_POST['clave_actual'];
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['clave_confirmar'];
        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
        } else {
            if ($nueva != $confirmar) {
                $res = array('tipo' => 'warning', 'mensaje' => 'Las contraseñas no coinciden');
            } else {
                $consulta = $this->model->getUser($this->id_usuario);
                if (password_verify($actual, $consulta['password'])) {
                    $hash = password_hash($nueva, PASSWORD_DEFAULT);
                    $data = $this->model->cambiarPass($hash, $this->id_usuario);
                    if ($data == 1) {
                        $res = array('tipo' => 'success', 'mensaje' => 'La contraseña ha sido modificado');
                    } else {
                        $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar la contraseña');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'La contraseña actual es incorrecta');
                }
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
    }

    public function exit()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }

    public function cambiarProfile()
    {
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $celular = $_POST['celular'];
        if (empty($usuario) || empty($nombre) || empty($apellido) || empty($celular)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
        } else {
            $user = $this->model->getUser($this->id_usuario);
            $data = $this->model->modify($nombre, $apellido, $usuario, $celular, $user['rol'], $this->id_usuario);
            if ($data == 1) {
                $res = array('tipo' => 'success', 'mensaje' => 'Los Datos han sido modificados');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar los Datos');
            }

            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
}
