<?php namespace App\Models;


class General
{
    public function qry_images_salvar( $id_image, $accessname, $extension, $height, $width, $autor, $uploaded_user, $name)
    {
        $sql = "EXEC app.sp_images_salvar
		@id_image = '$id_image',
		@accessname = '$accessname',
		@extension = '$extension',
		@height = '$height',
		@width = '$width' ,
		@autor = '$autor' ,
		@uploaded_user = '$uploaded_user',
		@name = '$name'";
        return query_database($sql);
    }

	public function exists_image($id)
	{
		$sql = "SELECT accessname+'.'+extension filename FROM app.tb_images WHERE id_image = '$id'";
		return query_database($sql);
	}

    //

}
