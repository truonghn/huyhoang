<?php
/**
 * Month View Content Template
 * The content template for the month view of events. This template is also used for
 * the response that is returned on month view ajax requests.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month/content.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<div id="tribe-events-content" class="tribe-events-month">

	<!-- Month Title -->
	<?php do_action( 'tribe_events_before_the_title' ) ?>
	<h2 class="tribe-events-page-title"><?php lanhtv_events_title() ?></h2>
	<?php do_action( 'tribe_events_after_the_title' ) ?>


	<!-- Month Header -->
	<?php do_action( 'tribe_events_before_header' ) ?>
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>

		<!-- Header Navigation -->
		<?php //tribe_get_template_part( 'month/nav' ); ?>
		<?php
		$date_next = Tribe__Events__Main::instance()->nextMonth( tribe_get_month_view_date() );
		$url_next  = tribe_get_next_month_link();
		$text_next = tribe_get_next_month_text();
		$date_pre = Tribe__Events__Main::instance()->previousMonth( tribe_get_month_view_date() );
		$url_pre  = tribe_get_previous_month_link();
		$text_pre = tribe_get_previous_month_text();
		?>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous" aria-label="previous month link">
				<?php echo '<a data-month="' . $date_pre . '" href="' . esc_url( $url_pre ) . '" rel="prev"><span>&#60;</span> ' . $text_pre . ' </a>'; ?>
			</li>
			<!-- .tribe-events-nav-previous -->
			<li class="tribe-events-nav-next" aria-label="next month link">
				<?php echo '<a data-month="' . $date_next . '" href="' . esc_url( $url_next ) . '" rel="next">' . $text_next . ' <span>&#62;</span></a>'; ?>
			</li>
			<!-- .tribe-events-nav-next -->
		</ul><!-- .tribe-events-sub-nav -->

	</div>
	<!-- #tribe-events-header -->
	<?php do_action( 'tribe_events_after_header' ) ?>

	<!-- Month Grid -->
	<?php tribe_get_template_part( 'month/loop', 'grid' ) ?>

	<!-- Month Footer -->
	<?php do_action( 'tribe_events_before_footer' ) ?>
	<div id="tribe-events-footer">

		<!-- Footer Navigation -->
		<?php do_action( 'tribe_events_before_footer_nav' ); ?>
		<?php tribe_get_template_part( 'month/nav' ); ?>
		<?php do_action( 'tribe_events_after_footer_nav' ); ?>

	</div>
	<!-- #tribe-events-footer -->
	<?php do_action( 'tribe_events_after_footer' ) ?>

	<?php tribe_get_template_part( 'month/mobile' ); ?>
	<?php tribe_get_template_part( 'month/tooltip' ); ?>

</div><!-- #tribe-events-content -->
