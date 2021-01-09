<?php namespace App\Models;
class M_App
{
	public static function qry_images_recover($account)
    {
    	$sql = "SELECT i.id_image, i.[description], i.accessname, i.extension,
		i.height, i.width, i.uploaded_date, i.name, u.nickname, u.account, category_main,
		SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', u.[user])), 3, 32) user_avatar,
		ISNULL((SELECT heart FROM app.tb_artwork_favorites f WHERE f.id_artwork = i.id_image), 0) heart
		FROM app.tb_images i, [users].tb_users u
		WHERE i.autor = u.id_user AND u.account = ? AND i.[state] = 'A' ORDER BY i.uploaded_date DESC;";

		return query_database($sql, [$account]);
    }


	public static function qry_images_new_list()
    {
    	$sql = "SELECT TOP 16 i.id_image, i.[description], i.accessname, i.extension, i.height, i.width, i.uploaded_date, i.name,
		u.nickname, u.account, category_main, SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', u.[user])), 3, 32) user_avatar,
		ISNULL((SELECT heart FROM app.tb_artwork_favorites f WHERE f.id_artwork = i.id_image), 0) heart
		FROM app.tb_images i, [users].tb_users u
		WHERE i.autor = u.id_user AND i.[state] = 'A' ORDER BY i.uploaded_date DESC;";

		return query_database($sql);
    }
    public static function qry_images_list()
    {
    	$sql = "SELECT TOP 30 i.id_image, i.[description], i.accessname, i.extension, i.height, i.width, i.uploaded_date, i.name,
		u.nickname, u.account, category_main, SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', u.[user])), 3, 32) user_avatar,
		ISNULL((SELECT heart FROM app.tb_artwork_favorites f WHERE f.id_artwork = i.id_image), 0) heart
		FROM app.tb_images i, [users].tb_users u
		WHERE i.autor = u.id_user AND i.[state] = 'A' ORDER BY NEWID();";

		return query_database($sql);
    }
	public static function qry_like_artwork_save($artwork, $account)
	{
		$sql = "EXEC app.sp_like_artwork_save @artwork = ?, @account = ?";
		return query_database($sql, [$artwork, $account]);
	}
}

 ?>
