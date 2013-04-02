<?php get_header(); ?>

		<h1><?php printf( __( 'Registration for %s', 'events' ), get_the_title( $event_id ) ); ?></h1>

		<?php rsvp_registration_form(); ?>

<?php get_footer();?>