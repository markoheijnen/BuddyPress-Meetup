<?php get_header(); ?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_archive' ); ?>

		<div class="page" id="blog-archives" role="main">

			<h3 class="pagetitle"><?php printf( __( 'Registration for %s', 'events' ), get_the_title( $event_id ) ); ?></h3>

			<?php if( is_user_logged_in() ) { ?>
				<?php rsvp_registration_form(); ?>
			<?php } else { ?>

			<?php
				_e( 'Before registrating for this event you first need to register for an user account.', 'events' );
			?>

			<?php } ?>

		</div>

		<?php do_action( 'bp_after_archive' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>