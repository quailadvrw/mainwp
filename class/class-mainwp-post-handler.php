<?php
/**
 * Post Handler.
 *
 * @package MainWP/Dashboard
 */

namespace MainWP\Dashboard;

/**
 * MainWP Post Handler
 */
class MainWP_Post_Handler extends MainWP_Post_Base_Handler {

	/**
	 * Private static variable to hold the single instance of the class.
	 *
	 * @static
	 *
	 * @var mixed Default null
	 */
	private static $instance = null;

	/**
	 * Method instance()
	 *
	 * Create a public static instance.
	 *
	 * @static
	 * @return MainWP_Post_Handler
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initiate all actions.
	 */
	public function init() {
		// Page: ManageSites.
		$this->add_action( 'mainwp_notes_save', array( &$this, 'mainwp_notes_save' ) );

		// Page: BulkAddUser.
		$this->add_action( 'mainwp_bulkadduser', array( &$this, 'mainwp_bulkadduser' ) );
		$this->add_action( 'mainwp_importuser', array( &$this, 'mainwp_importuser' ) );

		// Widget: RightNow.
		$this->add_action( 'mainwp_syncerrors_dismiss', array( &$this, 'mainwp_syncerrors_dismiss' ) );

		if ( mainwp_current_user_have_right( 'dashboard', 'manage_security_issues' ) ) {
			// Page: SecurityIssues.
			$this->add_action( 'mainwp_security_issues_request', array( &$this, 'mainwp_security_issues_request' ) );
			$this->add_action( 'mainwp_security_issues_fix', array( &$this, 'mainwp_security_issues_fix' ) );
			$this->add_action( 'mainwp_security_issues_unfix', array( &$this, 'mainwp_security_issues_unfix' ) );
		}

		$this->add_action( 'mainwp_notice_status_update', array( &$this, 'mainwp_notice_status_update' ) );
		$this->add_action( 'mainwp_dismiss_twit', array( &$this, 'mainwp_dismiss_twit' ) );
		$this->add_action( 'mainwp_dismiss_activate_notice', array( &$this, 'dismiss_activate_notice' ) );
		$this->add_action( 'mainwp_status_saving', array( &$this, 'mainwp_status_saving' ) );
		$this->add_action( 'mainwp_leftmenu_filter_group', array( &$this, 'mainwp_leftmenu_filter_group' ) );
		$this->add_action( 'mainwp_widgets_order', array( &$this, 'ajax_widgets_order' ) );
		$this->add_action( 'mainwp_save_settings', array( &$this, 'ajax_mainwp_save_settings' ) );

		$this->add_action( 'mainwp_twitter_dashboard_action', array( &$this, 'mainwp_twitter_dashboard_action' ) );

		// Page: Recent Posts.
		if ( mainwp_current_user_have_right( 'dashboard', 'manage_posts' ) ) {
			$this->add_action( 'mainwp_post_unpublish', array( &$this, 'mainwp_post_unpublish' ) );
			$this->add_action( 'mainwp_post_publish', array( &$this, 'mainwp_post_publish' ) );
			$this->add_action( 'mainwp_post_trash', array( &$this, 'mainwp_post_trash' ) );
			$this->add_action( 'mainwp_post_delete', array( &$this, 'mainwp_post_delete' ) );
			$this->add_action( 'mainwp_post_restore', array( &$this, 'mainwp_post_restore' ) );
			$this->add_action( 'mainwp_post_approve', array( &$this, 'mainwp_post_approve' ) );
		}
		$this->add_action( 'mainwp_post_addmeta', array( MainWP_Post_Page_Handler::get_class_name(), 'ajax_add_meta' ) );
		// Page: Pages.
		if ( mainwp_current_user_have_right( 'dashboard', 'manage_pages' ) ) {
			$this->add_action( 'mainwp_page_unpublish', array( &$this, 'mainwp_page_unpublish' ) );
			$this->add_action( 'mainwp_page_publish', array( &$this, 'mainwp_page_publish' ) );
			$this->add_action( 'mainwp_page_trash', array( &$this, 'mainwp_page_trash' ) );
			$this->add_action( 'mainwp_page_delete', array( &$this, 'mainwp_page_delete' ) );
			$this->add_action( 'mainwp_page_restore', array( &$this, 'mainwp_page_restore' ) );
		}
		// Page: Users.
		$this->add_action( 'mainwp_user_delete', array( &$this, 'mainwp_user_delete' ) );
		$this->add_action( 'mainwp_user_edit', array( &$this, 'mainwp_user_edit' ) );
		$this->add_action( 'mainwp_user_update_password', array( &$this, 'mainwp_user_update_password' ) );
		$this->add_action( 'mainwp_user_update_user', array( &$this, 'mainwp_user_update_user' ) );

		// Page: Posts.
		$this->add_action( 'mainwp_posts_search', array( &$this, 'mainwp_posts_search' ) );
		$this->add_action( 'mainwp_get_categories', array( &$this, 'mainwp_get_categories' ) );
		$this->add_action( 'mainwp_post_get_edit', array( &$this, 'mainwp_post_get_edit' ) );

		// Page: Pages.
		$this->add_action( 'mainwp_pages_search', array( &$this, 'mainwp_pages_search' ) );
		// Page: User.
		$this->add_action( 'mainwp_users_search', array( &$this, 'mainwp_users_search' ) );

		$this->add_action( 'mainwp_events_notice_hide', array( &$this, 'mainwp_events_notice_hide' ) );
		$this->add_action( 'mainwp_showhide_sections', array( &$this, 'mainwp_showhide_sections' ) );
		$this->add_action( 'mainwp_saving_status', array( &$this, 'mainwp_saving_status' ) );
		$this->add_action( 'mainwp_autoupdate_and_trust_child', array( &$this, 'mainwp_autoupdate_and_trust_child' ) );
		$this->add_action( 'mainwp_installation_warning_hide', array( &$this, 'mainwp_installation_warning_hide' ) );
		$this->add_action( 'mainwp_force_destroy_sessions', array( &$this, 'mainwp_force_destroy_sessions' ) );
		$this->add_action( 'mainwp_recheck_http', array( &$this, 'mainwp_recheck_http' ) );
		$this->add_action( 'mainwp_ignore_http_response', array( &$this, 'mainwp_ignore_http_response' ) );
		$this->add_action( 'mainwp_disconnect_site', array( &$this, 'ajax_disconnect_site' ) );
		$this->add_action( 'mainwp_manage_display_rows', array( &$this, 'ajax_display_rows' ) );

		$this->add_action( 'mainwp_get_community_topics', array( &$this, 'ajax_get_community_topics' ) );

		$this->add_security_nonce( 'mainwp-common-nonce' );
	}

	/**
	 * Method mainwp_installation_warning_hide()
	 *
	 * Hide the installation warning.
	 */
	public function mainwp_installation_warning_hide() {
		$this->secure_request( 'mainwp_installation_warning_hide' );

		update_option( 'mainwp_installation_warning_hide_the_notice', 'yes' );
		die( 'ok' );
	}

	/**
	 * Method mainwp_users_search()
	 *
	 * Search Post handler,
	 * Page: User.
	 */
	public function mainwp_users_search() {
		$this->secure_request( 'mainwp_users_search' );
		MainWP_Cache::init_session();
		MainWP_User::render_table( false, $_POST['role'], ( isset( $_POST['groups'] ) ? $_POST['groups'] : '' ), ( isset( $_POST['sites'] ) ? $_POST['sites'] : '' ), $_POST['search'] );
		die();
	}

	/**
	 * Method mainwp_posts_search()
	 *
	 * Search Post handler,
	 * Page: Posts.
	 */
	public function mainwp_posts_search() {
		$this->secure_request( 'mainwp_posts_search' );
		$post_type = ( isset( $_POST['post_type'] ) && 0 < strlen( trim( $_POST['post_type'] ) ) ? $_POST['post_type'] : 'post' );
		if ( isset( $_POST['maximum'] ) ) {
			MainWP_Utility::update_option( 'mainwp_maximumPosts', MainWP_Utility::ctype_digit( $_POST['maximum'] ) ? intval( $_POST['maximum'] ) : 50 );
		}
		MainWP_Cache::init_session();
		MainWP_Post::render_table( false, $_POST['keyword'], $_POST['dtsstart'], $_POST['dtsstop'], $_POST['status'], ( isset( $_POST['groups'] ) ? $_POST['groups'] : '' ), ( isset( $_POST['sites'] ) ? $_POST['sites'] : '' ), $_POST['postId'], $_POST['userId'], $post_type, $_POST['search_on'] );
		die();
	}
	/**
	 * Method mainwp_pages_search()
	 *
	 * Search Post handler,
	 * Page: Pages.
	 */
	public function mainwp_pages_search() {
		$this->secure_request( 'mainwp_pages_search' );
		if ( isset( $_POST['maximum'] ) ) {
			MainWP_Utility::update_option( 'mainwp_maximumPages', MainWP_Utility::ctype_digit( $_POST['maximum'] ) ? intval( $_POST['maximum'] ) : 50 );
		}
		MainWP_Cache::init_session();
		MainWP_Page::render_table( false, $_POST['keyword'], $_POST['dtsstart'], $_POST['dtsstop'], $_POST['status'], ( isset( $_POST['groups'] ) ? $_POST['groups'] : '' ), ( isset( $_POST['sites'] ) ? $_POST['sites'] : '' ), $_POST['search_on'] );
		die();
	}

	/**
	 * Method mainwp_get_categories()
	 *
	 * Get post/page categories.
	 */
	public function mainwp_get_categories() {
		$this->secure_request( 'mainwp_get_categories' );
		MainWP_Post_Page_Handler::get_categories();
		die();
	}

	/**
	 * Method mainwp_post_get_edit()
	 *
	 * Get post to edit.
	 */
	public function mainwp_post_get_edit() {
		$this->secure_request( 'mainwp_post_get_edit' );
		MainWP_Post_Page_Handler::get_post();
		die();
	}

	/**
	 * Method mainwp_user_delete()
	 *
	 * Delete User from Child Site,
	 * Page: Users.
	 */
	public function mainwp_user_delete() {
		$this->secure_request( 'mainwp_user_delete' );
		MainWP_User::delete();
	}

	/**
	 * Method mainwp_user_edit()
	 *
	 * Edit User from Child Site,
	 * Page: Users.
	 */
	public function mainwp_user_edit() {
		$this->secure_request( 'mainwp_user_edit' );
		MainWP_User::edit();
	}

	/**
	 * Method mainwp_user_update_password(
	 *
	 * Update User passowrd from Child Site,
	 * Page: Users.
	 */
	public function mainwp_user_update_password() {
		$this->secure_request( 'mainwp_user_update_password' );
		MainWP_User::update_password();
	}

	/**
	 * Method mainwp_user_update_user()
	 *
	 * Update User from Child Site,
	 * Page: Users.
	 */
	public function mainwp_user_update_user() {
		$this->secure_request( 'mainwp_user_update_user' );
		MainWP_User::update_user();
	}

	/**
	 * Method mainwp_post_unpublish()
	 *
	 * Unpublish post from Child Site,
	 * Page: Recent Posts.
	 */
	public function mainwp_post_unpublish() {
		$this->secure_request( 'mainwp_post_unpublish' );
		MainWP_Recent_Posts::unpublish();
	}

	/**
	 * Method mainwp_post_publish()
	 *
	 * Publish post on Child Site,
	 * Page: Recent Posts
	 */
	public function mainwp_post_publish() {
		$this->secure_request( 'mainwp_post_publish' );
		MainWP_Recent_Posts::publish();
	}

	/**
	 * Method mainwp_post_approve()
	 *
	 * Approve post on Child Site,
	 * Page: Recent Posts.
	 */
	public function mainwp_post_approve() {
		$this->secure_request( 'mainwp_post_approve' );
		MainWP_Recent_Posts::approve();
	}

	/**
	 * Method mainwp_post_trash()
	 *
	 * Trash post on Child Site,
	 * Page: Recent Posts
	 */
	public function mainwp_post_trash() {
		$this->secure_request( 'mainwp_post_trash' );

		MainWP_Recent_Posts::trash();
	}

	/**
	 * Method mainwp_post_delete()
	 *
	 * Delete post on Child Site,
	 * Page: Recent Posts.
	 */
	public function mainwp_post_delete() {
		$this->secure_request( 'mainwp_post_delete' );

		MainWP_Recent_Posts::delete();
	}

	/**
	 * Method mainwp_post_restore()
	 *
	 * Restore post,
	 * Page: Recent Posts.
	 */
	public function mainwp_post_restore() {
		$this->secure_request( 'mainwp_post_restore' );

		MainWP_Recent_Posts::restore();
	}

	/**
	 * Method mainwp_page_unpublish()
	 *
	 * Unpublish page,
	 * Page: Recent Pages.
	 */
	public function mainwp_page_unpublish() {
		$this->secure_request( 'mainwp_page_unpublish' );
		MainWP_Page::unpublish();
	}

	/**
	 * Method mainwp_page_publish()
	 *
	 * Publish page,
	 * Page: Recent Pages.
	 */
	public function mainwp_page_publish() {
		$this->secure_request( 'mainwp_page_publish' );
		MainWP_Page::publish();
	}

	/**
	 * Method mainwp_page_trash()
	 *
	 * Trash page,
	 * Page: Recent Pages.
	 */
	public function mainwp_page_trash() {
		$this->secure_request( 'mainwp_page_trash' );
		MainWP_Page::trash();
	}

	/**
	 * Method mainwp_page_delete()
	 *
	 * Delete page,
	 * Page: Recent Pages.
	 */
	public function mainwp_page_delete() {
		$this->secure_request( 'mainwp_page_delete' );
		MainWP_Page::delete();
	}

	/**
	 * Method mainwp_page_restor()
	 *
	 * Restore page,
	 * Page: Recent Pages.
	 */
	public function mainwp_page_restore() {
		$this->secure_request( 'mainwp_page_restore' );
		MainWP_Page::restore();
	}

	/**
	 * Method mainwp_notice_status_update()
	 *
	 * Hide after installtion notices,
	 * (PHP version, Trust MainWP Child, Multisite Warning and OpenSSL warning).
	 */
	public function mainwp_notice_status_update() {
		$this->secure_request( 'mainwp_notice_status_update' );

		if ( 'mail_failed' === $_POST['notice_id'] ) {
			MainWP_Utility::update_option( 'mainwp_notice_wp_mail_failed', 'hide' );
			die( 'ok' );
		}

		global $current_user;
		$user_id = $current_user->ID;
		if ( $user_id ) {
			$status = get_user_option( 'mainwp_notice_saved_status' );
			if ( ! is_array( $status ) ) {
				$status = array();
			}
			$status[ $_POST['notice_id'] ] = 1;
			update_user_option( $user_id, 'mainwp_notice_saved_status', $status );
		}
		die( 1 );
	}

	/**
	 * Method mainwp_status_saving()
	 *
	 * Save last_sync_sites time() or mainwp_status_saved_values.
	 */
	public function mainwp_status_saving() {
		$this->secure_request( 'mainwp_status_saving' );
		$values = get_option( 'mainwp_status_saved_values' );

		if ( ! isset( $_POST['status'] ) ) {
			die( -1 );
		}

		if ( 'last_sync_sites' === $_POST['status'] ) {
			update_option( 'mainwp_last_synced_all_sites', time() );
			do_action( 'mainwp_synced_all_sites' );
			die( 'ok' );
		}

		if ( ! isset( $_POST['value'] ) || empty( $_POST['value'] ) ) {
			if ( isset( $values[ $_POST['status'] ] ) ) {
				unset( $values[ $_POST['status'] ] );
			}
		} else {
			$values[ $_POST['status'] ] = $_POST['value'];
		}

		update_option( 'mainwp_status_saved_values', $values );
		die( 'ok' );
	}

	/**
	 * Method ajax_widget_order()
	 *
	 * Update saved widget order.
	 */
	public function ajax_widgets_order() {

		$this->secure_request( 'mainwp_widgets_order' );
		$user = wp_get_current_user();
		if ( $user ) {
			update_user_option( $user->ID, 'mainwp_widgets_sorted_' . $_POST['page'], ( isset( $_POST['order'] ) ? $_POST['order'] : '' ), true );
			die( 'ok' );
		}
		die( -1 );
	}

	/**
	 * Method ajax_mainwp_save_settings()
	 *
	 * Update saved MainWP Settings.
	 */
	public function ajax_mainwp_save_settings() {
		$this->secure_request( 'mainwp_save_settings' );
		$option_name = 'mainwp_' . $_POST['name'];
		$val         = $_POST['value'];

		MainWP_Utility::update_option( $option_name, $val );

		die( 'ok' );
	}

	/**
	 * Method mainwp_leftmenu_filter_group()
	 *
	 * MainWP left menu filter by group.
	 */
	public function mainwp_leftmenu_filter_group() {
		$this->secure_request( 'mainwp_leftmenu_filter_group' );
		if ( isset( $_POST['group_id'] ) && ! empty( $_POST['group_id'] ) ) {
			$ids      = '';
			$websites = MainWP_DB::instance()->query( MainWP_DB::instance()->get_sql_websites_by_group_id( $_POST['group_id'], true ) );
			while ( $websites && ( $website  = MainWP_DB::fetch_object( $websites ) ) ) {
				$ids .= $website->id . ',';
			}
			MainWP_DB::free_result( $websites );
			$ids = rtrim( $ids, ',' );
			die( $ids );
		}
		die( '' );
	}

	/**
	 * Method mainwp_dismiss_twit()
	 *
	 * Dismiss the twitter bragger.
	 */
	public function mainwp_dismiss_twit() {
		$this->secure_request( 'mainwp_dismiss_twit' );

		global $current_user;
		$user_id = $current_user->ID;
		if ( $user_id && isset( $_POST['twitId'] ) && ! empty( $_POST['twitId'] ) && isset( $_POST['what'] ) && ! empty( $_POST['what'] ) ) {
			MainWP_Twitter::clear_twitter_info( $_POST['what'], $_POST['twitId'] );
		}
		die( 1 );
	}

	/**
	 * Method dismiss_activate_notice()
	 *
	 * Dismiss activate notice.
	 */
	public function dismiss_activate_notice() {
		$this->secure_request( 'mainwp_dismiss_activate_notice' );

		global $current_user;
		$user_id = $current_user->ID;
		if ( $user_id && isset( $_POST['slug'] ) && ! empty( $_POST['slug'] ) ) {
			$activate_notices = get_user_option( 'mainwp_hide_activate_notices' );
			if ( ! is_array( $activate_notices ) ) {
				$activate_notices = array();
			}
			$activate_notices[ $_POST['slug'] ] = time();
			update_user_option( $user_id, 'mainwp_hide_activate_notices', $activate_notices );
		}
		die( 1 );
	}

	/**
	 * Method mainwp_twitter_dashboard_action()
	 *
	 * Post handler for twitter bragger.
	 *
	 * @return mixed $html|$success
	 */
	public function mainwp_twitter_dashboard_action() {
		$this->secure_request( 'mainwp_twitter_dashboard_action' );

		$success = false;
		if ( isset( $_POST['actionName'] ) && isset( $_POST['countSites'] ) && ! empty( $_POST['countSites'] ) ) {
			$success = MainWP_Twitter::update_twitter_info( $_POST['actionName'], $_POST['countSites'], (int) $_POST['countSeconds'], ( isset( $_POST['countRealItems'] ) ? $_POST['countRealItems'] : 0 ), time(), ( isset( $_POST['countItems'] ) ? $_POST['countItems'] : 0 ) );
		}

		if ( isset( $_POST['showNotice'] ) && ! empty( $_POST['showNotice'] ) ) {
			if ( MainWP_Twitter::enabled_twitter_messages() ) {
				$twitters = MainWP_Twitter::get_twitter_notice( $_POST['actionName'] );
				$html     = '';
				if ( is_array( $twitters ) ) {
					foreach ( $twitters as $timeid => $twit_mess ) {
						if ( ! empty( $twit_mess ) ) {
							$sendText = MainWP_Twitter::get_twit_to_send( $_POST['actionName'], $timeid );
							$html    .= '<div class="mainwp-tips mainwp-notice mainwp-notice-blue twitter"><span class="mainwp-tip" twit-what="' . esc_attr( $_POST['actionName'] ) . '" twit-id="' . $timeid . '">' . $twit_mess . '</span>&nbsp;' . MainWP_Twitter::gen_twitter_button( $sendText, false ) . '<span><a href="#" class="mainwp-dismiss-twit mainwp-right" ><i class="fa fa-times-circle"></i> ' . __( 'Dismiss', 'mainwp' ) . '</a></span></div>';
						}
					}
				}
				die( $html );
			}
		} elseif ( $success ) {
			die( 'ok' );
		}

		die( '' );
	}

	/**
	 * Method mainwp_security_issues_request()
	 *
	 * Post hander for,
	 * Page: SecurityIssues.
	 */
	public function mainwp_security_issues_request() {
		$this->secure_request( 'mainwp_security_issues_request' );

		try {
			wp_send_json( array( 'result' => MainWP_Security_Issues::fetch_security_issues() ) );
		} catch ( MainWP_Exception $e ) {
			die(
				wp_json_encode(
					array(
						'error' => array(
							'message'    => $e->getMessage(),
							'extra'      => $e->get_message_extra(),
						),
					)
				)
			);
		}
	}

	/**
	 * Method  mainwp_security_issues_fix()
	 *
	 * Post hander for 'fix issues',
	 * Page: SecurityIssues.
	 */
	public function mainwp_security_issues_fix() {
		$this->secure_request( 'mainwp_security_issues_fix' );

		try {
			wp_send_json( array( 'result' => MainWP_Security_Issues::fix_security_issue() ) );
		} catch ( MainWP_Exception $e ) {
			die(
				wp_json_encode(
					array(
						'error' => array(
							'message'    => $e->getMessage(),
							'extra'      => $e->get_message_extra(),
						),
					)
				)
			);
		}
	}

	/**
	 * Method  mainwp_security_issues_unfix()
	 *
	 * Post hander for 'unfix issues',
	 * Page: SecurityIssues.
	 */
	public function mainwp_security_issues_unfix() {
		$this->secure_request( 'mainwp_security_issues_unfix' );

		try {
			wp_send_json( array( 'result' => MainWP_Security_Issues::unfix_security_issue() ) );
		} catch ( MainWP_Exception $e ) {
			die(
				wp_json_encode(
					array(
						'error' => array(
							'message'    => $e->getMessage(),
							'extra'      => $e->get_message_extra(),
						),
					)
				)
			);
		}
	}

	/**
	 * Method ajax_disconnect_site()
	 *
	 * Disconnect Child Site.
	 */
	public function ajax_disconnect_site() {
		$this->secure_request( 'mainwp_disconnect_site' );

		$siteid = $_POST['wp_id'];

		if ( empty( $siteid ) ) {
			die( wp_json_encode( array( 'error' => 'Error: site id empty' ) ) );
		}

		$website = MainWP_DB::instance()->get_website_by_id( $siteid );

		if ( ! $website ) {
			die( wp_json_encode( array( 'error' => 'Not found site' ) ) );
		}

		try {
			$information = MainWP_Connect::fetch_url_authed( $website, 'disconnect' );
		} catch ( \Exception $e ) {
			$information = array( 'error' => __( 'fetch_url_authed exception', 'mainwp' ) );
		}

		wp_send_json( $information );
	}

	/**
	 * Method ajax_display_rows()
	 *
	 * Display rows via ajax,
	 * Page: Manage Sites.
	 */
	public function ajax_display_rows() {
		$this->secure_request( 'mainwp_manage_display_rows' );
		MainWP_Manage_Sites::display_rows();
	}

	/**
	 * Method ajax_get_community_topics()
	 *
	 * Display rows via ajax,
	 * Page: Manage Sites.
	 */
	public function ajax_get_community_topics() {
		$this->secure_request( 'mainwp_get_community_topics' );
		MainWP_Community::get_mainwp_community_topics();
	}


	/**
	 * Method mainwp_bulkadduser()
	 *
	 * Bulk Add User for,
	 * Page: BulkAddUser.
	 */
	public function mainwp_bulkadduser() {
		if ( ! $this->check_security( 'mainwp_bulkadduser' ) ) {
			die( 'ERROR ' . wp_json_encode( array( 'error' => __( 'Invalid request!', 'mainwp' ) ) ) );
		}
		MainWP_User::do_bulk_add();
		die();
	}

	/**
	 * Method mainwp_importuser()
	 *
	 * Import user.
	 */
	public function mainwp_importuser() {
		$this->secure_request( 'mainwp_importuser' );
		MainWP_User::do_import();
	}

	/**
	 * Method mainwp_notes_save()
	 *
	 * Post handler for save notes on,
	 * Page: Manage Sites.
	 */
	public function mainwp_notes_save() {
		$this->secure_request( 'mainwp_notes_save' );
		MainWP_Manage_Sites_Handler::save_note();
	}

	/**
	 * Method mainwp_syncerrors_dismiss()
	 *
	 * Dismis Syncerrors for,
	 * Widget: RightNow.
	 */
	public function mainwp_syncerrors_dismiss() {

		$this->secure_request( 'mainwp_syncerrors_dismiss' );

		try {
			die( wp_json_encode( array( 'result' => MainWP_Updates_Overview::dismiss_sync_errors() ) ) );
		} catch ( \Exception $e ) {
			die( wp_json_encode( array( 'error' => $e->getMessage() ) ) );
		}
	}

	/**
	 * Method mainwp_events_notice_hide()
	 *
	 * Hide events notice.
	 */
	public function mainwp_events_notice_hide() {
		$this->secure_request( 'mainwp_events_notice_hide' );

		if ( isset( $_POST['notice'] ) ) {
			$current_options = get_option( 'mainwp_showhide_events_notice' );
			if ( ! is_array( $current_options ) ) {
				$current_options = array();
			}
			if ( 'first_site' === $_POST['notice'] ) {
				update_option( 'mainwp_first_site_events_notice', '' );
			} elseif ( 'request_reviews1' === $_POST['notice'] ) {
				$current_options['request_reviews1']           = 15;
				$current_options['request_reviews1_starttime'] = time();
			} elseif ( 'request_reviews1_forever' === $_POST['notice'] || 'request_reviews2_forever' === $_POST['notice'] ) {
				$current_options['request_reviews1'] = 'forever';
				$current_options['request_reviews2'] = 'forever';
			} elseif ( 'request_reviews2' === $_POST['notice'] ) {
				$current_options['request_reviews2']           = 15;
				$current_options['request_reviews2_starttime'] = time();
			} elseif ( 'trust_child' === $_POST['notice'] ) {
				$current_options['trust_child'] = 1;
			} elseif ( 'multi_site' === $_POST['notice'] ) {
				$current_options['hide_multi_site_notice'] = 1;
			}
			update_option( 'mainwp_showhide_events_notice', $current_options );
		}
		die( 'ok' );
	}

	/**
	 * Method mainwp_showhide_sections()
	 *
	 * Show/Hide sections.
	 */
	public function mainwp_showhide_sections() {
		if ( isset( $_POST['sec'] ) && isset( $_POST['status'] ) ) {
			$opts = get_option( 'mainwp_opts_showhide_sections' );
			if ( ! is_array( $opts ) ) {
				$opts = array();
			}
			$opts[ $_POST['sec'] ] = $_POST['status'];
			update_option( 'mainwp_opts_showhide_sections', $opts );
			die( 'ok' );
		}
		die( 'failed' );
	}

	/**
	 * Method mainwp_saving_status()
	 *
	 * MainWP Saving Status.
	 */
	public function mainwp_saving_status() {
		if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'mainwp_ajax' ) ) {
			die( 'Invalid request.' );
		}
		if ( isset( $_POST['saving_status'] ) ) {
			$current_options = get_option( 'mainwp_opts_saving_status' );
			if ( ! is_array( $current_options ) ) {
				$current_options = array();
			}

			if ( ! empty( $_POST['saving_status'] ) ) {
				$current_options[ $_POST['saving_status'] ] = $_POST['value'];
			}

			update_option( 'mainwp_opts_saving_status', $current_options );
		}
		die( 'ok' );
	}

	/**
	 * Method mainwp_recheck_http()
	 *
	 * Recheck Child Site http status code & message.
	 */
	public function mainwp_recheck_http() {
		if ( ! $this->check_security( 'mainwp_recheck_http' ) ) {
			die( wp_json_encode( array( 'error' => __( 'ERROR: Invalid request!', 'mainwp' ) ) ) );
		}

		if ( ! isset( $_POST['websiteid'] ) || empty( $_POST['websiteid'] ) ) {
			die( -1 );
		}

		$website = MainWP_DB::instance()->get_website_by_id( $_POST['websiteid'] );
		if ( empty( $website ) ) {
			die( -1 );
		}

		$result       = MainWP_Connect::is_website_available( $website );
		$http_code    = ( is_array( $result ) && isset( $result['httpCode'] ) ) ? $result['httpCode'] : 0;
		$check_result = MainWP_Connect::check_ignored_http_code( $http_code );
		MainWP_DB::instance()->update_website_values(
			$website->id,
			array(
				'offline_check_result'   => $check_result ? '1' : '-1',
				'offline_checks_last'    => time(),
				'http_response_code'     => $http_code,
			)
		);
		die(
			wp_json_encode(
				array(
					'httpcode' => esc_html( $http_code ),
					'status'   => $check_result ? 1 : 0,
				)
			)
		);
	}

	/**
	 * Method mainwp_ignore_http_response()
	 *
	 * Ignore Child Site https response.
	 */
	public function mainwp_ignore_http_response() {
		if ( ! $this->check_security( 'mainwp_ignore_http_response' ) ) {
			die( wp_json_encode( array( 'error' => __( 'ERROR: Invalid request!', 'mainwp' ) ) ) );
		}

		if ( ! isset( $_POST['websiteid'] ) || empty( $_POST['websiteid'] ) ) {
			die( -1 );
		}

		$website = MainWP_DB::instance()->get_website_by_id( $_POST['websiteid'] );
		if ( empty( $website ) ) {
			die( -1 );
		}

		MainWP_DB::instance()->update_website_values( $website->id, array( 'http_response_code' => '-1' ) );
		die( wp_json_encode( array( 'ok' => 1 ) ) );
	}

	/**
	 * Method mainwp_autoupdate_and_trust_child()
	 *
	 * Set MainWP Child Plugin to Trusted & AutoUpdate.
	 */
	public function mainwp_autoupdate_and_trust_child() {
		$this->secure_request( 'mainwp_autoupdate_and_trust_child' );
		if ( get_option( 'mainwp_automaticDailyUpdate' ) != 1 ) {
			update_option( 'mainwp_automaticDailyUpdate', 1 );
		}
		MainWP_Plugins_Handler::trust_plugin( 'mainwp-child/mainwp-child.php' );
		die( 'ok' );
	}

	/**
	 * Method mainwp_force_destroy_sessions()
	 *
	 * Force destroy sessions.
	 */
	public function mainwp_force_destroy_sessions() {
		$this->secure_request( 'mainwp_force_destroy_sessions' );

		$website_id = ( isset( $_POST['website_id'] ) ? (int) $_POST['website_id'] : 0 );

		if ( ! MainWP_DB::instance()->get_website_by_id( $website_id ) ) {
			die( wp_json_encode( array( 'error' => array( 'message' => __( 'This website does not exist.', 'mainwp' ) ) ) ) );
		}

		$website = MainWP_DB::instance()->get_website_by_id( $website_id );
		if ( ! MainWP_System_Utility::can_edit_website( $website ) ) {
			die( wp_json_encode( array( 'error' => array( 'message' => __( 'You cannot edit this website.', 'mainwp' ) ) ) ) );
		}

		try {
			$information = MainWP_Connect::fetch_url_authed(
				$website,
				'settings_tools',
				array(
					'action' => 'force_destroy_sessions',
				)
			);
			global $mainWP;
			if ( ( '2.0.22' === $mainWP->get_version() ) || ( '2.0.23' === $mainWP->get_version() ) ) {
				if ( 1 != get_option( 'mainwp_fixed_security_2022' ) ) {
					update_option( 'mainwp_fixed_security_2022', 1 );
				}
			}
		} catch ( \Exception $e ) {
			$information = array( 'error' => __( 'fetch_url_authed exception', 'mainwp' ) );
		}

		wp_send_json( $information );
	}

}
