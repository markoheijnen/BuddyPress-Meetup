<?php

include 'lib/custom-meta-boxes/custom-meta-boxes.php';
include 'inc/custom-meta-boxes-addon.php';

include 'inc/template.php';

include 'inc/meetups.php';
include 'inc/rsvp.php';

class Meetups {
	public function __construct() {
		new Responsive_Meetups_Events();
		new Responsive_Meetups_RSVP();

		if( ! did_action( 'plugins_loaded' ) )
			add_action( 'init', array( $this, 'load_textdomain_plugin' ) );
		else
			add_action( 'after_setup_theme', array( $this, 'load_textdomain_theme' ) );
	}

	public function load_textdomain_theme() {
		add_filter( 'theme_locale', array( $this, 'theme_locale' ), 10, 2 );
		load_theme_textdomain( 'events', get_stylesheet_directory() . '/plugin/languages' );
		remove_filter( 'theme_locale', array( $this, 'theme_locale' ) );
	}

	public function load_textdomain_plugin() {
		load_plugin_textdomain( 'events', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}


	public function theme_locale( $locale, $domain ) {
		if( 'events' == $domain )
			return "{$domain}-{$locale}";

		return $locale;
	}
}
new Meetups();