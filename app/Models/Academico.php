<?php namespace App\Models;

use CodeIgniter\Model;

class Academico
{
    public function qry_ciclos_listar() {
        return query_database("EXEC [Academico].[spu_tbCiclo_Listar_por]");
    }
    public function qry_ciclo_actual(){
        $lista = $this->qry_ciclos_listar();
        return $lista[0];
    }
	public function qry_alumnos_buscar( $clave, $ciclo, $estricto = 0 ) {
		$sql = "EXEC [Academico].[spu_alumno_buscar] '$clave', '$ciclo', $estricto";
        return query_database($sql);
    }
	public function qry_informacionCarnet_recuperar( $ciclo, $alumno ) {
		$sql = "EXEC [Academico].[spu_AlumnoCarnet_recuperar] '$ciclo', '$alumno'";
        return query_database($sql);
    }
	public function qry_aulaClasesAlumno_recuperar( $ciclo ) {
		$sql = "EXEC [Academico].[spu_tbAulaClasesAlumno_Recuperar]  '$ciclo'";
        return query_database($sql);
    }
	public function qry_MatriculaAula_salvar( $ciclo, $alumno, $turno, $aula ) {
		$sql = "EXEC Matricula.spu_tbMatriculaAula_guardar '$ciclo', '$alumno', '$turno', '$aula'";
        query_database($sql);
    }
	//
}
