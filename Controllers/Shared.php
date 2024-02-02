<?php
class Shared extends Controller
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
        $data['title'] = 'Archivos compartidos';
        $data['script'] = 'shared.js';
        $data['menu'] = 'share';
        $data['archivos'] = $this->model->getSharedFiles($this->usuario);
        $data['shares'] = $this->model->verificarEstado($this->usuario);
        $this->views->getView('admin', 'shared', $data);
    }

    public function verDetalle($id_detalle)
    {
        $data = $this->model->getDetalle($id_detalle);
        if (!empty($data)) {
            $this->model->cambiarestado(2, $id_detalle);
        }
        $data['fecha'] = time_ago(strtotime($data['fecha_add']));
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    function eliminar($id)
    {
        $data = $this->model->cambiarestado(0, $id);
        if ($data == 1) {
            $res = array('mensaje' => 'Archivo Eliminado', 'tipo' => "success");
        } else {
            $res = array('mensaje' => 'Error al eliminar el Archivo', 'tipo' => "error");
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}