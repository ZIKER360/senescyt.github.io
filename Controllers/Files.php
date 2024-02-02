<?php
class Files extends Controller
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
        $data['title'] = 'Archivos';
        $data['active'] = 'todos';
        $data['script'] = 'files.js';
        $data['archivos'] = $this->model->getArchivos(1, $this->id_usuario);
        $folders = $this->model->getCarpetas($this->id_usuario);
        for ($i = 0; $i < count($folders); $i++) {
            $folders[$i]['color'] = substr(md5($folders[$i]['id']), 0, 6);
            $folders[$i]['fecha'] = time_ago(strtotime($folders[$i]['fecha_create']));
        }
        $data['folders'] = $folders;
        $data['menu'] = 'admin';
        $data['shares'] = $this->model->verificarEstado($this->usuario);
        $this->views->getView('files', 'index', $data);
    }

    public function getUsers()
    {
        $valor = $_GET['q'];
        $data = $this->model->getUsers($valor, $this->id_usuario);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['text'] = $data[$i]['nombre'] . ' ' . $data[$i]['apellido'] . ' - ' . $data[$i]['usuario'];
        }
        echo json_encode($data);
        die();
    }

    public function share()
    {
        $usuarios = $_POST['usuarios'];
        if (empty($_POST['files'])) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Debe seleccionar por lo menos un archivo');
        } else {
            $files = $_POST['files'];
            $res = 0;
            for ($i = 0; $i < count($files); $i++) {
                for ($j = 0; $j < count($usuarios); $j++) {
                    $dato = $this->model->getUser($usuarios[$j]);
                    $result = $this->model->getDetail($dato['usuario'], $files[$i]);
                    if (empty($result)) {
                        $res = $this->model->recordDetail($dato['usuario'], $files[$i], $this->id_usuario);
                    } else {
                        $res = 1;
                    }
                }
            }
            if ($res > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Archivos Compartidos');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al compartir');
            }
        }
        echo json_encode($res);
        die();
    }

    public function seeFiles($id_folder)
    {
        $data = $this->model->getFiles($id_folder);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Searchfolder($id)
    {
        $data = $this->model->getCarpeta($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $fecha = date('Y-m-d H:i:s');
        $nueva = date("Y-m-d H:i:s", strtotime($fecha . '+2 days'));
        $data = $this->model->eliminar(0, $nueva, $id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'El archivo ha sido eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar el archivo');
        }
        echo json_encode($res);
        die();
    }
    //delete the shared file
    public function eliminarCompartido($id)
    {
        $fecha = date('Y-m-d H:i:s');
        $nueva = date("Y-m-d H:i:s", strtotime($fecha . '+2 days'));
        $data = $this->model->eliminarCompartido($nueva, $id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'El archivo ha sido eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar el archivo');
        }

        echo json_encode($res);
        die();
    }

    public function busqueda($valor)
    {
        $data = $this->model->getBusqueda($valor, $this->id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function recicle($valor)
    {
        $data['title'] = 'Archivos Eliminado';
        $data['active'] = 'deleted';
        $data['script'] = 'deleted.js';
        $data['menu'] = 'admin';
        $data['shares'] = $this->model->verificarEstado($this->usuario);
        $this->views->getView('files', 'deleted', $data);
    }

    public function listarHistorial($valor)
    {
        $data = $this->model->getArchivos(0, $this->id_usuario);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<a href="#" class="btn btn-danger btn-sm" onclick="restaurar(' . $data[$i]['id'] . ')">
            Restaurar
        </a>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id)
    {
        $data = $this->model->eliminar(1, null, $id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'El archivo ha sido restaurado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al restaurar el archivo');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
