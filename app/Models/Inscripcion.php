<?php namespace App\Models;

class Inscripcion
{
    public function qry_inscritos_buscar($clave, $ciclo = '%',$estricto = '0'){

        $clave = str_replace(' ','%',$clave);
        $sql = "EXEC Inscripcion.spu_Inscripcion_buscar '$clave','$ciclo','$estricto'";

        return  query_database($sql);
    }
    public function requisitos_salvar($ciclo, $inscripcion, $copia_dni, $copia_constancia, $codigo_voucher){
        $sql = "EXEC [Inscripcion].[spu_tbRequisitos_Guardar] '$ciclo', '$inscripcion', '$copia_dni', '$copia_constancia', '$codigo_voucher'";
        query_database($sql);
    }
    public function qry_requisitos_recuperar($inscripcion, $ciclo){
        return query_database("EXEC Inscripcion.spu_tbRequisitos_Recuperar '$inscripcion', '$ciclo'");
    }

    public function qry_inscritosPostulante_listar($ciclo, $inscripcion){
        $sql = "EXEC inscripcion.spu_InscripcionPostulante_Recuperar '$ciclo', '$inscripcion'";
        return query_database($sql);
    }

    public function inscripcionPostulante_guardar( $dni, $apaterno, $amaterno, $nombres, $sexo, $fechanacimiento, $direccion, $anioegreso, $correo, $telefono, $celular, $colegio, $ubigeo, $pais, $estadocivil) {
        $sql = "EXEC [Inscripcion].[spu_tbPostulante_Guardar] '$dni', '$apaterno', '$amaterno', '$nombres', '$sexo', '$fechanacimiento', '$direccion', '$anioegreso', '$correo', '$telefono', '$celular', '$colegio', '$ubigeo', '$pais', '$estadocivil'";
        query_database($sql);
    }
	public function procesarMatricula($inscripcion, $ciclo) {
        $sql = "EXEC [Inscripcion].[spu_procesarMatricula] '$inscripcion', '$ciclo'";
        query_database($sql);
    }
	public function Inscripcion_listar($dnipostulante, $ciclo)
	{
		$sql = "
		EXEC [Inscripcion].[spu_tbInscripcion_listar_por]
		@dnipostulante = '$dnipostulante',
		@ciclo = '$ciclo'
		";
		return query_database($sql);
	}

}
