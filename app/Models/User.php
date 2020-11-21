<?php namespace App\Models;


class User
{
	public static function account_create($user, $email, $pass)
	{
		$sql = "EXEC app.sp_user_create @user = ?, @email = ?, @pass = ?";
		return query_database($sql,[$user, $email, $pass]);
	}

	public static function qry_access($user,$pass)
	{
		$sql = "SELECT nickname, account, id_role, id_user, validate, recreatepass FROM users.tb_users WHERE [user] = ? AND pass = ? AND account != 'Anonimus'";
		return query_database($sql,[$user, $pass]);
	}
	public static function qry_account_exists($account)
	{
		$sql = "SELECT account,nickname,validate,recreatepass,email FROM users.tb_users WHERE account = ?;";
		return query_database($sql,[$account]);
	}
}
