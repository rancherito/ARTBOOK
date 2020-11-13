<?php namespace App\Models;


class General
{
    public static function qry_images_salvar( $id_image, $accessname, $extension, $height, $width, $autor, $uploaded_user, $name)
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

	public static function exists_image($id)
	{
		$sql = "SELECT accessname+'.'+extension filename FROM app.tb_images WHERE id_image = '$id'";
		return query_database($sql);
	}

    public static function qry_images_list()
    {
    	$sql = "SELECT i.accessname, i.extension, i.height, i.width, i.uploaded_date, i.name, u.nickname, u.account FROM app.tb_images i, [users].tb_users u WHERE i.autor = u.id_user";
		return query_database($sql);
    }
	public static function qry_images_recover($account)
    {
    	$sql = "SELECT i.accessname, i.extension, i.height, i.width, i.uploaded_date, i.name, u.nickname, u.account FROM app.tb_images i, [users].tb_users u WHERE i.autor = u.id_user AND u.account = ?;";
		return query_database($sql, [$account]);
    }
	public static function qry_simpleuser_list()
	{
		$sql = "SELECT id_user, nickname FROM [users].tb_users;";
		return query_database($sql);
	}

	public static function qry_access($user,$pass)
	{
		$sql = "SELECT nickname, account, id_role FROM users.tb_users WHERE [user] = ? AND pass = ? AND account != 'Anonimus'";
		return query_database($sql,[$user, $pass]);
	}
	public static function qry_account_exists($account)
	{
		$sql = "SELECT account,nickname FROM users.tb_users WHERE account = ?;";
		return query_database($sql,[$account]);
	}

}
