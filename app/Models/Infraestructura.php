<?php namespace App\Models;
class Infraestructura
{
    public function qry_aulas_listar($aula = 'null')
    {
        $sql = "EXEC [Academico].[spu_tbAulaClases_Recuperar] $aula";
        return query_database($sql);
    }

    public function qry_aulas_salvar($aula, $capacidad, $pabellon, $descripcion, $estado)
    {
        $sql = "EXEC [Academico].[spu_tbAulaClases_Guardar] '$aula', '$capacidad', '$pabellon', '$descripcion', '$estado'";
        query_database($sql);
    }
}
