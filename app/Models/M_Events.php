<?php namespace App\Models;

class M_Events
{

	public static function qry_challenge_image_list($event_tag, $user)
	{
		$sql = "events.sp_challenge_images_list @event_tag = ?, @user = ?";
		return query_database($sql, [$event_tag, $user]);
	}
	public static function qry_challenge_artwork_vote($nickname_or_ip, $artwork, $tag_event)
	{
		$sql = "
		EXEC events.sp_challenge_choise_artwork
			@nickname_or_ip = ?,
			@artwork = ?,
			@tag_event = ?;
		";
		return query_database($sql, [$nickname_or_ip, $artwork, $tag_event]);
	}
	public static function qry_challenge_current()
	{
		$sql = "SELECT TOP 1 name,event_start,event_end,[description],event_tag FROM events.tb_events";
		return query_database($sql);
	}
	public static function qry_versus_register( $id_versus, $event_tag, $promoter_user, $name, $description)
	{
		$sql = "
		EXEC events.sp_versus_save
		@id_versus = ?,
		@event_tag = ?,
		@promoter_user = ?,
		@name = ?,
		@description = ?;";
		return query_database($sql, [$id_versus, $event_tag, $promoter_user, $name, $description]);
	}

	public static function qry_versus_apply($user, $id_versus, $image_accessname)
	{
		$sql = "
		EXEC events.sp_versus_apply
		@user = ?,
		@id_versus = ?,
		@image_accessname = ?;
		";
		return query_database($sql, [$user, $id_versus, $image_accessname]);
	}
	public static function qry_versus_current()
	{
		$sql = "
		SELECT name, event_start,event_end,[description],event_tag, DATEADD(DD,-1,event_end) voting
		FROM events.tb_events
		WHERE type_event = 2 AND GETDATE() BETWEEN event_start AND DATEADD(DD,-1,event_end);
		";
		return query_database($sql);
	}
	public static function qry_events_current()
	{
		$sql = "
			SELECT name, event_start,event_end,[description],event_tag, DATEADD(DD,-1,event_end) voting, id_event ,
			IIF(GETDATE() BETWEEN event_start AND DATEADD(DD,-1,event_end), 0, 1) is_voting
			FROM events.tb_events
			WHERE GETDATE() BETWEEN event_start AND event_end;
		";
		return query_database($sql);
	}
	public  static function qry_versus_list($tag_event)
	{
		$sql = "EXEC events.sp_versus_list @event_tag = ?;";
		return query_database($sql, [$tag_event]);
	}
	public static function qry_events_apply_list($user)
	{
		$sql = "events.sp_events_apply_list @user = ?";
		return query_database($sql, [$user]);
	}
	public static function qry_vs_artworks($tag, $user)
	{
		$sql = "EXEC events.[sp_versus_artworks_list] @event_tag = ?, @user = ?;";
		return query_database($sql, [$tag, $user]);
	}
	public static function qry_versus_recover($tag)
	{
		$sql = "SELECT name,event_start,event_end,[description], creation_date FROM events.tb_events WHERE type_event = 2 AND event_tag = ?;";
		return query_database($sql, [$tag]);
	}
	public static function qry_vs_artwork_choise($nickname_or_ip,  $artwork, $versus)
	{
		$sql = "EXEC [events].[sp_versus_choise_artwork] @nickname_or_ip  = ?, @artwork = ?, @versus  = ?;";
		return query_database($sql, [$nickname_or_ip,  $artwork, $versus]);
	}
	public static function qry_vs_participients($vs)
	{
		$sql = "SELECT u.account, u.nickname FROM events.tb_versus_inscription i, users.tb_users u WHERE id_versus = ? AND u.id_user = i.id_user";
		return query_database($sql, [$vs]);
	}
	public static function qry_vs_artworks_candidates($id_versus, $user)
	{
		$sql = "EXEC events.sp_versus_candidates_artworks @id_versus = ?, @user = ?;";
		return query_database($sql, [$id_versus, $user]);
	}
}
