<?php
class MainModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($user)
    {
        return $this->select("SELECT * FROM usuarios WHERE usuario = '$user' AND estado = 1");
    }
}

?>