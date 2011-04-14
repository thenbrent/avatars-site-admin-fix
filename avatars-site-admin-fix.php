<?php
/*
Plugin Name: Avatars Site Admin Fix
Description: Allow site admins to change avatars of users on their site with the IncSub Avatars plugin. 
Author: _FindingSimple
Author URI: http://findingsimple.com/
Version: 1.0
Network: true
*/

/**
 * When the current user is not a super admin, expose the Avatars class's administration
 * menus to be standard administrators via the site options pages.
 **/
function gsa_change_avatar_url(){
	global $ms_avatar;

	if( is_object( $ms_avatar ) && !is_super_admin() ){
		$ms_avatar->network_top_menu = 'options-general.php';
		$ms_avatar->network_top_menu_slug = 'options-general.php';
	}
}
add_action( 'init', 'gsa_change_avatar_url' );

/**
 * Don't include the Edit Avatar admin page in the menu.
 **/
function gsa_remove_avatar_url(){
	global $ms_avatar, $submenu;

	if( is_object( $ms_avatar ) && !is_super_admin() ){
		add_options_page( __( 'Edit User Avatar', 'avatars' ), __( 'Edit User Avatar', 'avatars' ), 'edit_users', 'edit-user-avatar', array( &$ms_avatar, 'page_site_admin_edit_user_avatar' ) );
		$key = $ms_avatar->array_find_r( 'edit-user-avatar', $submenu );
		unset( $submenu['options-general.php'][$key] );
	}
}
add_action( 'admin_menu', 'gsa_remove_avatar_url' );
