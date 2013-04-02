<?php
class WP_Serbia {

	public function __construct() {
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles'), 11 );

		//$this->generate_css();

		if( ! class_exists( 'Meetups' ) )
			include 'plugin/meetup.php';

		add_filter( 'responive_meetups_event_slug', array( $this, 'change_event_slug' ) );
	}


	public function change_event_slug() {
		return 'догађаји';
	}





	public function enqueue_styles() {
		wp_deregister_style('bp-default-main');
		wp_register_style( 'bp-default-main', get_stylesheet_directory_uri() . '/css/default.css', array(), bp_get_version() );
		wp_enqueue_style('bp-default-main');
	}

	public function generate_css() {
		$old     = get_template_directory() . '/_inc/css/default.css';
		$new     = get_stylesheet_directory() . '/css/default.css';

		$mixture = new Hex_Mixture( file_get_contents( $old ) );
		//$mixture->change_color_structure( '$3$2$1' );

		file_put_contents( $new, $mixture->get_string() );
	}
}
new WP_Serbia;


class Hex_Mixture {
	private $string;

	public function __construct( $string ) {
		$this->string = $string;
	}

	public function get_string() {
		return $this->string;
	}

	public function change_color_structure( $structure = '$1$2$3' ) {
		$structure = '#' . $structure;

		$this->string = preg_replace( '/#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})/', $structure, $this->string );
		//$this->string = preg_replace( '/#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])/', $structure, $this->string );
	}

	public function color_inverse($color){
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6){ return '000000'; }
		$rgb = '';
		for ($x=0;$x<3;$x++){
			$c = 255 - hexdec(substr($color,(2*$x),2));
			$c = ($c < 0) ? 0 : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
		}
		return '#'.$rgb;
	}

	public function minimize() {
		$this->string = preg_replace('/([^=])#([a-f\\d])\\2([a-f\\d])\\3([a-f\\d])\\4([\\s;\\}])/i', '$1#$2$3$4$5', $this->string );
	}
}



function event_menu() {
	global $wp_query;

	$menu = array(
		''     => __( 'Upcoming', 'events' ),
		'past' => __( 'Past', 'events' )
	);

	$selected = esc_attr( $wp_query->get('event_var') );
	if( ! isset( $menu[ $selected ] ) )
		$selected = '';

	$html = '<ul class="menu-horizontal">';
	foreach( $menu as $slug => $name ) {
		$url = get_post_type_archive_link('event') . $slug;

		if( $slug == $selected )
			$html .= '<li class="selected"><a href="' . $url . '">' . $name . '</a></li>';
		else
			$html .= '<li><a href="' . $url . '">' . $name . '</a></li>';
	}
	$html .= '</ul>';

	echo $html;
}

function event_rsvp_button( $event_id = false ) {
	if( ! $event_id )
		$event_id = get_the_ID();

	Responsive_Meetups_RSVP::rsvp_button( $event_id );
}