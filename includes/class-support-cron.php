<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Blog_Tutor_Support Cron class
	 *
	 * @package  Blog_Tutor_Support
	 * @category Core
	 * @author Sergio Scabuzzo, Trevor Polischuk
	 */
class NerdPress_Support_Cron {

	public static function init() {
		$class = __CLASS__;
		new $class;
	}

	public function __construct() {
		add_action( 'wp_loaded', array( $this, 'schedule_snapshot_cron' ) );
	}

	/**
	 * Assemble and send data dump ping to relay API endpoint every 12 hours
	 *
	 * @since 1.0+
	 */
	public function schedule_snapshot_cron() {

		if (get_option( 'blog_tutor_support_settings' )['schedule_snapshot']) {
			if ( ! wp_next_scheduled( 'ping_relay' ) ) {
				wp_schedule_event( time(), 'twicedaily', 'ping_relay');
			}
		} else {
			if ( wp_next_scheduled( 'ping_relay' ) ) {
				wp_clear_scheduled_hook( 'ping_relay' );
			}
		}
	}
}

add_action( 'init', array( 'NerdPress_Support_Cron', 'init' ) );