<?php namespace App\Controllers;
use App\Models\General;

class GeneralController extends BaseController{
    public function Departamentos_listar()
    {
        $mod = new General();
        $data = $mod->qry_departamentos_listar();
        header('Content-Type: application/json');
        return json_encode($data);
    }
    public function Provincia_listar()
    {
        $mod = new General();
        $data = $mod->qry_provincia_listar($_POST['departamento']);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function Distrito_listar()
    {
        $mod = new General();
        $data = $mod->qry_distrito_listar($_POST['departamento'],$_POST['provincia']);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function Pais_listar()
    {
        $data = (new General())->qry_pais_listar();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function Colegio_listar()
    {
        $data = (new General())->qry_colegio_listar($_POST['departamento'],$_POST['provincia'],$_POST['distrito']);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}