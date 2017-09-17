<?php
//add_action( 'admin_init', 'wpse_136058_debug_admin_menu' );
function wpse_136058_debug_admin_menu() {

	echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
}
if (is_user_logged_in()){
	$userID    = get_current_user_id();
	$user_meta = get_userdata( $userID );
	$user_role = $user_meta->roles;

	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}

	function vifonic_no_admin_access() {
		global $pagenow;
		$redirect = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url( '/' );
		if (current_user_can( 'subscriber' )) {
			if ( $pagenow == 'profile.php' || $pagenow == 'index.php' ) {
				exit( wp_redirect( $redirect ) );
			}
		}
	}
	add_action( 'admin_init', 'vifonic_no_admin_access', 100 );

	if ( is_admin() ) {

		if ( $userID != '1' ) {
			// Disable wp core Update
			define( 'WP_AUTO_UPDATE_CORE', false );
			// Disable Theme/Plugin Update
			add_filter( 'auto_update_plugin', '__return_false' );
			add_filter( 'auto_update_theme', '__return_false' );

			// Disable Theme/Plugin Editor
			define( 'DISALLOW_FILE_MODS', true );
			define( 'DISALLOW_FILE_EDIT', true );

			add_action( 'admin_menu', 'vifonic_remove_menus' );

			// Remove
			add_action( 'admin_menu', 'vifonic_remove_unnecessary_wordpress_menus', 999 );
		}

		function vifonic_remove_menus() {

			remove_menu_page( 'index.php' );
			remove_menu_page( 'jetpack' );
			// remove_menu_page( 'edit.php' );
			remove_menu_page( 'upload.php' );
			// remove_menu_page( 'edit.php?post_type=page' );
			remove_menu_page( 'edit-comments.php' );
			remove_menu_page( 'customize.php' );
			remove_menu_page( 'plugins.php' );
			// remove_menu_page( 'users.php' );
			remove_menu_page( 'tools.php' );
			remove_menu_page( 'options-general.php' );
			remove_menu_page( 'vc-general' );
			remove_menu_page( 'about-ultimate' );
			remove_menu_page( 'ninja-forms' );
			remove_menu_page( 'loco-translate' );
			remove_menu_page( 'wppusher' );
			remove_menu_page( 'wp-fast-cache' );
			remove_menu_page( 'itsec' );
			remove_menu_page( 'about-ultimate' );
			remove_menu_page('edit.php?post_type=acf');
			remove_menu_page('edit.php?post_type=acf-field-group');

		}

		function vifonic_remove_unnecessary_wordpress_menus() {
			global $submenu;
			unset( $submenu['themes.php'][6] );
			unset( $submenu['themes.php'][20] );
			unset( $submenu['themes.php'][22] );
		}
	}
}


