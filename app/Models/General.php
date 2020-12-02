<?php namespace App\Models;


class General
{
    public static function qry_images_salvar( $id_image, $accessname, $extension, $height, $width, $autor, $uploaded_user, $name, $description = '')
    {
        $sql = "EXEC app.sp_images_salvar
		@id_image = '$id_image',
		@accessname = '$accessname',
		@extension = '$extension',
		@height = '$height',
		@width = '$width' ,
		@autor = '$autor' ,
		@uploaded_user = '$uploaded_user',
		@name = '$name',
		@description = '$description';";
        return query_database($sql);
    }

	public static function exists_image($id)
	{
		$sql = "SELECT accessname+'.'+extension filename FROM app.tb_images WHERE id_image = ?";
		return query_database($sql,[$id]);
	}

    public static function qry_images_list()
    {
    	$sql = "SELECT i.id_image, i.[description], i.accessname, i.extension, i.height, i.width, i.uploaded_date, i.name, u.nickname, u.account FROM app.tb_images i, [users].tb_users u WHERE i.autor = u.id_user ORDER BY i.uploaded_date DESC;";
		return query_database($sql);
    }
	public static function qry_images_recover($account)
    {
    	$sql = "SELECT i.id_image, i.[description], i.accessname, i.extension, i.height, i.width, i.uploaded_date, i.name, u.nickname, u.account FROM app.tb_images i, [users].tb_users u WHERE i.autor = u.id_user AND u.account = ? ORDER BY i.uploaded_date DESC;";
		return query_database($sql, [$account]);
    }
	public static function qry_simpleuser_list()
	{
		$sql = "SELECT id_user, nickname FROM [users].tb_users;";
		return query_database($sql);
	}

	public function qry_feedpage()
	{
		$sql = "EXEC app.sp_feedpage;";
		return query_database($sql);
	}
	public static function qry_challenge_image_list($event_tag, $user)
	{
		$sql = "events.sp_challenge_images_list @event_tag = ?, @user = ?";
		return query_database($sql, [$event_tag, $user]);
	}
	public function qry_challenge_artwork_vote($nickname_or_ip, $artwork, $tag_event)
	{
		$sql = "
		EXEC events.sp_challenge_choise_artwork
			@nickname_or_ip = ?,
			@artwork = ?,
			@tag_event = ?;
		";
		return query_database($sql, [$nickname_or_ip, $artwork, $tag_event]);
	}
	public function qry_challenge_current()
	{
		$sql = "SELECT TOP 1 name,event_start,event_end,[description],event_tag FROM events.tb_challenge";
		return query_database($sql);
	}
}
