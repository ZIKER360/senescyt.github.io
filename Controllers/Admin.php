<?php
class Admin extends Controller
{
    private $id_usuario, $usuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_usuario = $_SESSION['id'];
        $this->usuario = $_SESSION['usuario'];
        //validar sesion
        if (empty($_SESSION['id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        // permanently delete files
        $fecha = date('Y-m-d H:i:s');
        $eliminar = $this->model->getConsulta();
        $ruta = 'assets/archivos/';
        for ($i=0; $i < count($eliminar); $i++) { 
            if ($eliminar[$i]['elimina'] < $fecha) {
                $accion = $this->model->eliminarRegistro($eliminar[$i]['id']);
                if ($accion == 1) {
                    if (file_exists($ruta . $eliminar[$i]['id_carpeta'] . '/' . $eliminar[$i]['nombre'])) {
                        unlink($ruta . $eliminar[$i]['id_carpeta'] . '/' . $eliminar[$i]['nombre']);
                }
            }
            }
            
        }

    }
    public function index()
    {   
        $data['title'] = 'Panel de Administración';
        $data['script'] = 'files.js';
        $data['active'] = 'recent';
        $data['menu'] = 'admin';
        $folders = $this->model->getCarpetas($this->id_usuario);
        $data['archivos'] = $this->model->getArchivosRecientes($this->id_usuario);
        for ($i=0; $i < count($folders); $i++) { 
            $folders[$i]['color'] = substr(md5($folders[$i]['id']), 0, 6);
            $folders[$i]['fecha'] = time_ago(strtotime($folders[$i]['fecha_create']));
        }
        $data['folders'] = $folders;
        $data['shares'] = $this->model->verificarEstado($this->usuario);
        $this->views->getView('admin', 'home', $data);
    }

    public function crearcarpeta()
    {
        $nombre = $_POST['nombre'];
        if (empty($nombre)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'El nombre es requerido');
        } else {
            //Comprobar si el nombre existe
            $VerificarNom = $this->model->getCheck('nombre', $nombre, $this->id_usuario, 0);
            if (empty($VerificarNom)) {
                $data = $this->model->crearcarpeta($nombre, $this->id_usuario);
                if ($data > 0) {
                    $res = array('tipo' => 'success', 'mensaje' => 'Carpeta Creada');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'Error al crear Carpeta');
                }
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'La carpeta ya existe');
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function subirarchivo()
    {   
        $id_folder = (empty($_POST['id_folder'])) ? 1 : $_POST['id_folder'] ;
        $archivo = $_FILES['file'];
        $name = $archivo['name'];
        $tmp = $archivo['tmp_name'];
        $tipo = $archivo['type'];
        $data = $this->model->subirArchivo($name, $tipo, $id_folder, $this->id_usuario);
        if ($data > 0) {
            $destino = 'Assets/archivos';
            if (!file_exists($destino)) {
                mkdir($destino);
            }
            $folder = $destino . '/' . $id_folder;
            if (!file_exists($folder)) {
                mkdir($folder);
            }
            move_uploaded_file($tmp, $folder . '/' . $name);
            $res = array('tipo' => 'success', 'mensaje' => 'Archivo Subido');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al subir Archivo');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function view($id_folder)
    {
        $data['title'] = 'Listado de Archivos';
        $data['active'] = 'detail';
        $data['archivos'] = $this->model->getArchivos($id_folder, $this->id_usuario);
        $data['menu'] = 'admin';
        $data['shares'] = $this->model->verificarEstado($this->usuario);
        $this->views->getView('admin', 'files', $data);
    }  

    public function seedetail($id_folder){
        $data['title'] = 'Archivos Compartidos';
        $data['id_folder'] = $id_folder;
        $data['script'] = 'details.js';
        $data['folder'] = $this->model->getCarpeta($id_folder);  
        if (empty($data['folder'])) {
            echo 'pagina fuera de servicio :(';
            exit;
        }
        $data['menu'] = 'admin';
        $data['shares'] = $this->model->verificarEstado($this->usuario);
        $this->views->getView('admin', 'detail', $data);
    }

    public function listdetail($id_folder)
    {
        $data = $this->model->getDetails($id_folder);
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = ' <span class="badge bg-warning">Se elimina el '. $data[$i]['elimina'] .'</span>';
                $data[$i]['acciones'] = '';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-success">Compartido</span>';
                $data[$i]['acciones'] = '<button class="btn btn-danger btn-sm" onclick="eliminarDetails('.$data[$i]['id'] .')">Eliminar</button>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}