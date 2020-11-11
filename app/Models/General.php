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

    public function qry_images_list()
    {
    	$sql = "SELECT i.*, u.nickname FROM app.tb_images i, user.tb_users u WHERE i.autor = u.id_user";
		return query_database($sql);
    }
	public function qry_simpleuser_list()
	{
		$sql = "SELECT id_user, nickname FROM user.tb_users;";
		return query_database($sql);
	}

}
