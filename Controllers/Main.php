<?php
class Main extends Controller
{
    public function __construct() {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Iniciar Sesion';
        $this->views->getView('main', 'index', $data);
    }

    // LOGIN
    public function validate() 
    {
        $user = $_POST['User'];
        $password = $_POST['Password'];
        $data = $this->model->getUser($user);
        if (!empty($data)) {
            if (password_verify($password, $data['password'])) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $res = array('tipo' => 'success', 'mensaje' => 'Bienvenido al Sistema de Gestión de Archivos');
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'La contraseña es incorrecta');
            }   
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'El usuario no Existe');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
