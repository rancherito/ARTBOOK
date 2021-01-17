<?php namespace App\Models;
class User
{
	public static function account_edit($account, $pass_verify, $pass_new, $is_newpass)
	{
		$sql = "
		EXEC app.sp_account_edit
		@user = ?,
		@pass_verify = ?,
		@pass_new = ?,
		@is_newpass = ?
		";
		return query_database($sql,[$account, $pass_verify, $pass_new, $is_newpass]);
	}
	public static function account_create($user, $email, $pass)
	{
		$sql = "EXEC app.sp_user_create @user = ?, @email = ?, @pass = ?;";
		return query_database($sql,[$user, $email, $pass]);
	}
	public static function accountfb_create($fb_id, $nickname, $account)
	{
		$sql = "EXEC users.sp_userfb_create @fb_id = ?, @nickname = ?, @account = ?";
		return query_database($sql,[$fb_id, $nickname, $account]);
	}

	public static function accountgoogle_create($id, $nickname, $account, $email)
	{
		$sql = "users.[sp_usergoogle_create] @google_id = ?, @nickname = ?, @account = ?, @email = ?;";
		return query_database($sql,[$id, $nickname, $account, $email]);
	}
	public static function account_validate($account)
	{
		$sql = "SELECT id_user, account, validate,pass FROM users.tb_users WHERE account = ?;";
		return query_database($sql,[$account]);
	}
	public static function qry_access($user,$pass)
	{
		$sql = "SELECT nickname, account, id_role, id_user, validate, recreatepass,[user] FROM users.tb_users WHERE [user] = ? AND pass = ? AND account != 'Anonimus'";
		return query_database($sql,[$user, $pass]);
	}
	public static function qry_account_exists($account)
	{
		$sql = "SELECT account,nickname,validate,recreatepass,email,[user] FROM users.tb_users WHERE account = ?;";
		return query_database($sql,[$account]);
	}
	public static function account_activate($id_user)
	{
		$sql = "UPDATE users.tb_users SET validate = 1 WHERE id_user = ?;";
		return query_database($sql,[$id_user]);
	}
	public static function ipuser_save($ip)
	{
		$sql = "EXEC users.sp_ipuser_save @ipuser = ?;";
		return query_database($sql,[$ip]);
	}
	public static function qry_users_list()
	{
		$sql = "SELECT nickname, account, pass, [user], [state] FROM users.tb_users";
		return query_database($sql);
	}
	public static function qry_socialnetwork_save($type_socialnetwork, $url, $account)
	{
		$sql = "EXEC users.sp_socialnetwork_save @type_socialnetwork = ?, @url = ?, @account= ?";
		return query_database($sql, [$type_socialnetwork, $url, $account]);
	}
	public static function qry_socialnetwork_list($account)
	{
		$sql = "SELECT * FROM users.tb_socialnetwork WHERE id_user = (SELECT id_user FROM users.tb_users WHERE account = ?)";
		return query_database($sql, [$account]);
	}
	public static function qry_nickname_save($nickname, $account)
	{
		$sql = "EXEC users.[sp_nickname_save] @nickname = ?, @account = ?";
		return query_database($sql, [$nickname, $account]);
	}
}
