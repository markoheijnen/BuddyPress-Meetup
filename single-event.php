<?php get_header(); ?>

	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_blog_single_post' ); ?>

			<div class="page" id="blog-single" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="post-title"><?php the_title(); ?></h1>

					<address>
						<?php echo get_post_meta( get_the_ID(), 'location_name', true ); ?><br/>
						<?php echo get_post_meta( get_the_ID(), 'address', true ); ?>
					</address>

					<div class="post-entry">
						<?php the_content(__('Read more &#8250;', 'events')); ?>
						<?php wp_link_pages(array('before' => '<div class="pagination">' . __( 'Pages:', 'events' ), 'after' => '</div>')); ?>
					</div><!-- end of .post-entry -->

					<div class="navigation">
						<div class="previous"><?php previous_post_link( '&#8249; %link' ); ?></div>
						<div class="next"><?php next_post_link( '%link &#8250;' ); ?></div>
					</div><!-- end of .navigation -->

				</div><!-- end of #post-<?php the_ID(); ?> -->



				<div class="event-aside">
					<div class="widget-wrapper">
						<?php
						$timestamp = get_post_meta( get_the_ID(), 'datetime_event', true );
						printf( '<p><time datetime="%1$s">%2$s<br/>%3$s</time></p>',
							esc_attr( date( 'c', $timestamp ) ),
							esc_html( date_i18n( get_option('date_format'), $timestamp ) ),
							esc_html( date_i18n( get_option('time_format'), $timestamp ) )
						);

						$spots       = absint( get_post_meta( get_the_ID(), 'spots', true ) );
						$count       = Responsive_Meetups_RSVP::counts( get_the_ID() );
						$avatar_size = 50;

						if( $timestamp > time() ) { ?>
							<ul>
								<li>
									<?php
									event_rsvp_button();
									?>
								</li>
								<li>
									<?php printf( _n( '%s spot', '%s spots', $spots, 'events' ), $spots ); ?>
								</li>
								<li>
									<?php printf( _n( '%s attending', '%s attending', $count->attend, 'events' ), $count->attend ); ?>
								</li>
								<?php if( $count->waitinglist ) { ?>
								<li>
									<?php printf( _n( '%s waiting', '%s waiting', $count->waitinglist, 'events' ), $count->waitinglist ); ?>
								</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div><!-- end of .widget-wrapper -->

					<?php
					$args = array(
						'post_type'      => 'rsvp',
						'post_status'    => 'attend',
						'post_parent'    => get_the_ID(),
						'posts_per_page' => -1,
						'order'          => 'asc',
						'fields'         => 'ids'
					);
					$rsvps = get_posts( $args );
					if( count( $rsvps ) > 0 ) {
					?>
					<div class="widget-wrapper rsvp-images">
						<h4><?php _e( 'Attendees', 'events' ); ?></h4>
						<ul>
							<?php foreach( $rsvps as $rsvp ) { ?>
							<li><?php echo get_avatar( get_post_meta( $rsvp, 'email', true ), $avatar_size, false, get_post_meta( $rsvp, 'name', true ) ); ?></li>

							<?php } ?>
						</ul>

						<?php
						$args = array(
							'post_type'      => 'rsvp',
							'post_status'    => 'waitinglist',
							'post_parent'    => get_the_ID(),
							'posts_per_page' => -1,
							'order'          => 'asc',
							'fields'         => 'ids'
						);
						$rsvps = get_posts( $args );

						if( count( $rsvps ) > 0 ) { ?>
						<h4><?php _e( 'Waitinglist', 'events' ); ?></h4>
						<ul>
							<?php foreach( $rsvps as $rsvp ) { ?>
							<li><?php echo get_avatar( get_post_meta( $rsvp, 'email', true ), $avatar_size, false, get_post_meta( $rsvp, 'name', true ) ); ?></li>

							<?php } ?>
						</ul>
						<?php }

						$args = array(
							'post_type'      => 'rsvp',
							'post_status'    => 'notattend',
							'post_parent'    => get_the_ID(),
							'posts_per_page' => -1,
							'order'          => 'asc',
							'fields'         => 'ids'
						);
						$rsvps = get_posts( $args );

						if( count( $rsvps ) > 0 ) { ?>
						<h4><?php _e( 'Not Attendees', 'events' ); ?></h4>
						<ul>
							<?php foreach( $rsvps as $rsvp ) { ?>
							<li><?php echo get_avatar( get_post_meta( $rsvp, 'email', true ), $avatar_size, false, get_post_meta( $rsvp, 'name', true ) ); ?></li>

							<?php } ?>
						</ul>
						<?php } ?>

					</div>
					<?php } ?>
				</div>



				<?php comments_template(); ?>

				<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div class="navigation">
					<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'events' ) ); ?></div>
					<div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'events' ) ); ?></div>
				</div><!-- end of .navigation -->
				<?php endif; ?>

			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'buddypress' ); ?></p>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_blog_single_post' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>