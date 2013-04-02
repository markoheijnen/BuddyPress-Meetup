<?php get_header(); ?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_archive' ); ?>

		<div class="page" id="blog-archives" role="main">

			<h3 class="pagetitle"><?php _e( 'Events', 'events' ); ?></h3>

			<?php if ( have_posts() ) : ?>

				<?php bp_dtheme_content_nav( 'nav-above' ); ?>

				<?php while (have_posts()) : the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__( 'Permanent Link to %s', 'events' ), the_title_attribute( 'echo=0' )); ?>"><?php the_title(); ?></a></h2>

						<address>
							<?php echo get_post_meta( get_the_ID(), 'location_name', true ); ?><br/>
							<?php echo get_post_meta( get_the_ID(), 'address', true ); ?>
						</address>

						<div class="post-entry">
							<?php if ( has_post_thumbnail()) : ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
									<?php the_post_thumbnail('thumbnail', array('class' => 'alignleft')); ?>
								</a>
							<?php endif; ?>
							<?php the_excerpt(); ?>
							<?php wp_link_pages(array('before' => '<div class="pagination">' . __( 'Pages:', 'events' ), 'after' => '</div>')); ?>
						</div><!-- end of .post-entry -->

						<div class="post-data">
							<?php get_the_term_list( null, 'event_type', __('Type:', 'events'), ', ', '' ); ?>
						</div><!-- end of .post-data -->             
		   
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

							$spots = absint( get_post_meta( get_the_ID(), 'spots', true ) );
							$count = Responsive_Meetups_RSVP::counts( get_the_ID() );

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
									<?php if( comments_open() ) { ?>
									<li>
										<a href="<?php comments_link(); ?>"><?php comments_number(); ?></a>
									</li>
									<?php } ?>
								</ul>
							<?php } ?>
						</div><!-- end of .widget-wrapper -->
					</div>



				<?php endwhile; ?>

				<?php bp_dtheme_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ); ?></h2>
				<?php get_search_form(); ?>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_archive' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>