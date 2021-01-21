<?php namespace App\Models;


class General
{
    public static function qry_images_salvar( $id_image, $accessname, $extension, $height, $width, $autor, $uploaded_user, $name, $description = '')
    {
        $sql = "EXEC app.sp_images_salvar
		@id_image = ?,
		@accessname = ?,
		@extension = ?,
		@height = ?,
		@width = ? ,
		@autor = ? ,
		@uploaded_user = ?,
		@name = ?,
		@description = ?;";
        return query_database($sql, [$id_image, $accessname, $extension, $height, $width, $autor, $uploaded_user, $name, $description]);
    }

	public static function exists_image($id)
	{
		$sql = "SELECT accessname+'.'+extension filename, uploaded_date, accessname artwork FROM app.tb_images WHERE id_image = ?";
		return query_database($sql,[$id]);
	}

	public static function qry_top9_artworks_list($account)
    {
    	$sql = "SELECT TOP 9 i.id_image, i.[description], i.accessname, i.extension,
		i.height, i.width, i.uploaded_date, i.name, u.nickname, u.account
		FROM app.tb_images i, [users].tb_users u
		WHERE i.autor = u.id_user AND u.account = ? AND i.[state] = 'A' ORDER BY NEWID();";

		return query_database($sql, [$account]);
    }

	public static function qry_simpleuser_list()
	{
		$sql = "SELECT id_user, nickname FROM [users].tb_users;";
		return query_database($sql);
	}

	public static function qry_feedpage()
	{
		$sql = "EXEC app.sp_feedpage;";
		return query_database($sql);
	}

}
