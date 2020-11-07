<?php namespace App\Models;


class General
{
    public function qry_departamentos_listar()
    {
        $sql = "EXEC [General].[spu_tbDepartamento_listar_por]";
        return query_database($sql);
    }
    public function qry_provincia_listar($departamento){
        $sql = "EXEC [General].[spu_tbProvincia_Listar] '$departamento'";
        return query_database($sql);
    }
    public function qry_distrito_listar($departamento,$provincia){
        $sql = "EXEC [General].[spu_tbDistrito_Listar] '$departamento', '$provincia'";
        return query_database($sql);
    }
    public function qry_pais_listar(){
        $sql = "EXEC [General].[spu_tbPais_listar_por]";
        return query_database($sql);
    }
    public function qry_colegio_listar($departamento,$provincia,$distrito){
        $sql = "EXEC [Academico].[spu_tbColegio_Listar_por] null, '$departamento','$provincia','$distrito'";
        return query_database($sql);
    }
    //
    
}