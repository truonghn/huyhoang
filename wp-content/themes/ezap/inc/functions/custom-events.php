<?php
/**
 * Loop Functions
 *
 * Display functions (template-tags) for use in WordPress templates.
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( class_exists( 'Tribe__Events__Main' ) ) {

	/**
	 * Event Title (Display)
	 *
	 * Display an event's title with pseudo-breadcrumb if on a category
	 *
	 * @param bool $depth include linked title
	 */
	function lanhtv_events_title( $depth = true ) {
		echo apply_filters( 'lanhtv_events_title', lanhtv_get_events_title( $depth ) );
	}

	/**
	 * Event Title
	 *
	 * Return an event's title with pseudo-breadcrumb if on a category
	 *
	 * @param bool $depth include linked title
	 *
	 * @return string title
	 * @todo move logic to template classes
	 */
	function lanhtv_get_events_title( $depth = true ) {
		$events_label_plural = tribe_get_event_label_plural();

		global $wp_query;

		$tribe_ecp = Tribe__Events__Main::instance();

		$title = sprintf( esc_html__( 'Upcoming %s', 'the-events-calendar' ), $events_label_plural );

		// If there's a date selected in the tribe bar, show the date range of the currently showing events
		if ( isset( $_REQUEST['tribe-bar-date'] ) && $wp_query->have_posts() ) {
			$first_returned_date = tribe_get_start_date( $wp_query->posts[0], false, Tribe__Date_Utils::DBDATEFORMAT );
			$first_event_date    = tribe_get_start_date( $wp_query->posts[0], false );
			$last_event_date     = tribe_get_end_date( $wp_query->posts[ count( $wp_query->posts ) - 1 ], false );

			// If we are on page 1 then we may wish to use the *selected* start date in place of the
			// first returned event date
			if ( 1 == $wp_query->get( 'paged' ) && $_REQUEST['tribe-bar-date'] < $first_returned_date ) {
				$first_event_date = tribe_format_date( $_REQUEST['tribe-bar-date'], false );
			}

			$title = sprintf( __( '%1$s for %2$s - %3$s', 'the-events-calendar' ), $events_label_plural, $first_event_date, $last_event_date );
		} elseif ( tribe_is_past() ) {
			$title = sprintf( esc_html__( 'Past %s', 'the-events-calendar' ), $events_label_plural );
		}

		if ( tribe_is_month() ) {
			$title = sprintf(
				esc_html__( '%1$s', 'the-events-calendar' ),
				date_i18n( tribe_get_date_option( 'monthAndYearFormat', 'F Y' ), strtotime( tribe_get_month_view_date() ) )
			);
		}

		// day view title
		if ( tribe_is_day() ) {
			$title = sprintf(
				esc_html__( '%1$s for %2$s', 'the-events-calendar' ),
				$events_label_plural,
				date_i18n( tribe_get_date_format( true ), strtotime( $wp_query->get( 'start_date' ) ) )
			);
		}

		if ( is_tax( $tribe_ecp->get_event_taxonomy() ) && $depth ) {
			$cat = get_queried_object();
			$title =  $cat->name . ' ' . $title;
		}

		return apply_filters( 'lanhtv_get_events_title', $title, $depth );
	}
}
