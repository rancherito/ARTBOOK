<?php namespace App\Models;
class M_App
{
	public static function qry_images_recover($account, $current_account = '$$')
    {
    	$sql = "SELECT i.id_image, i.[description], i.accessname, i.extension,
		i.height, i.width, i.uploaded_date, i.name, u.nickname, u.account, category_main,
		SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', u.[user])), 3, 32) user_avatar,
		ISNULL((SELECT heart FROM app.tb_artwork_favorites f, users.tb_users uu  WHERE uu.account = ? AND f.id_artwork = i.id_image AND uu.id_user = f.id_user), 0) heart
		FROM app.tb_images i, [users].tb_users u
		WHERE i.autor = u.id_user AND u.account = ? AND i.[state] = 'A' ORDER BY i.uploaded_date DESC;";

		return query_database($sql, [$current_account, $account]);
    }

	public static function qry_artwork_recover($artwork, $current_account = '')
    {
    	$sql = "SELECT i.[description], i.accessname, i.extension,
		(SELECT COUNT(heart) FROM app.tb_artwork_favorites f WHERE f.id_artwork = i.id_image AND heart = 1) heart_count,
		ISNULL((SELECT heart FROM app.tb_artwork_favorites f, users.tb_users uu  WHERE uu.account = ? AND f.id_artwork = i.id_image AND uu.id_user = f.id_user), 0) heart,
		i.height, i.width, i.uploaded_date, i.name, u.nickname, u.account, SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', u.[user])), 3, 32) user_avatar
		FROM app.tb_images i, [users].tb_users u
		WHERE i.autor = u.id_user AND i.accessname = ? AND i.[state] = 'A';";

		return query_database($sql, [$current_account, $artwork]);
    }

	public static function qry_images_new_list($current_account = '$$')
    {
    	$sql = "EXEC app.sp_artwoks_list @account = ?, @type = 'NEW'";

		return query_database($sql, [$current_account]);
    }
    public static function qry_images_list($current_account = '$$')
    {
    	$sql = "EXEC app.sp_artwoks_list @account = ?, @type = 'TOP'";

		return query_database($sql,[$current_account]);
    }
	public static function qry_like_artwork_save($artwork, $account)
	{
		$sql = "EXEC app.sp_like_artwork_save @artwork = ?, @account = ?";
		return query_database($sql, [$artwork, $account]);
	}
	public static function qry_most_liked_artwork($top = 1)
	{
		$sql = "EXEC app.most_liked_artwork @top = ?";
		return query_database($sql, [$top]);
	}
}

 ?>
