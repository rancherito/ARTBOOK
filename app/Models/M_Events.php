<?php namespace App\Models;

class M_Events
{

	public static function qry_challenge_image_list($event_tag, $user)
	{
		$sql = "events.sp_challenge_images_list @event_tag = ?, @user = ?";
		return query_database($sql, [$event_tag, $user]);
	}
	public static function qry_events($type = '%', $tag = '%')
	{

		$sql = "SELECT name, event_start, event_end, [description], creation_date, type_event, event_tag, (SELECT name FROM events.tb_type_event t WHERE t.id_type = e.type_event) type_event_name FROM events.tb_events e WHERE type_event LIKE ? AND  event_tag LIKE ? ORDER BY event_end DESC, id_event DESC;";
		return query_database($sql, [$type, $tag]);

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
	public static function qry_versus_register( $id_versus, $event_tag, $promoter_user, $name, $description,$state_inscription)
	{
		$sql = "
		EXEC events.sp_versus_save
		@id_versus = ?,
		@event_tag = ?,
		@promoter_user = ?,
		@name = ?,
		@description = ?,
		@state_inscription = ?;";
		return query_database($sql, [$id_versus, $event_tag, $promoter_user, $name, $description, $state_inscription]);
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
	public static function qry_versus_current($tag = '%')
	{
		$sql = "
		SELECT name, event_start,event_end,[description],event_tag, DATEADD(DD,-1,event_end) voting
		FROM events.tb_events
		WHERE type_event = 2 AND GETDATE() BETWEEN event_start AND DATEADD(DD,-1,event_end) AND event_tag LIKE ?;
		";
		return query_database($sql,[$tag]);
	}
	public static function qry_events_current()
	{
		$sql = "
			SELECT name, event_start,event_end,[description],event_tag, DATEADD(DD,-1,event_end) voting, id_event , type_event,
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
		$sql = "SELECT event_tag, name, DATEADD(DAY, -1, event_end) voting,event_start,event_end,[description], creation_date, IIF(event_end < GETDATE(),'E',IIF(DATEADD(DAY, -1, event_end) < GETDATE(),'S','N')) event_voting_state, IIF(event_end < GETDATE(),'END VOTING',IIF(DATEADD(DAY, -1, event_end) < GETDATE(),'START VOTING','NO VOTING STARTER')) event_voting_state_details FROM events.tb_events WHERE type_event = 2 AND event_tag = ?;";
		return query_database($sql, [$tag]);
	}
	public static function qry_vs_artwork_choise($nickname_or_ip,  $artwork, $versus)
	{
		$sql = "EXEC [events].[sp_versus_choise_artwork] @nickname_or_ip  = ?, @artwork = ?, @versus  = ?;";
		return query_database($sql, [$nickname_or_ip,  $artwork, $versus]);
	}
	public static function qry_vs_participients($vs)
	{
		$sql = "SELECT u.account, u.nickname,IIF(i.id_image IS NULL, 0,1) is_artwork_uploaded  FROM events.tb_versus_inscription i, users.tb_users u WHERE id_versus = ? AND u.id_user = i.id_user";
		return query_database($sql, [$vs]);
	}
	public static function qry_vs_artworks_candidates($id_versus, $user)
	{
		$sql = "EXEC events.sp_versus_candidates_artworks @id_versus = ?, @user = ?;";
		return query_database($sql, [$id_versus, $user]);
	}
	public static function qry_vs_results($tag)
	{
		$sql = "EXEC events.[sp_versus_results] @evet_tag = ?;";
		return query_database($sql, [$tag]);
	}
	public static function qry_event_vs_participients($tag)
	{
		$sql = "EXEC events.[sp_versus_participients] @tag = ?;";
		return query_database($sql, [$tag]);
	}
}
