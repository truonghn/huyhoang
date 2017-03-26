<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newsmag
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">

	<?php get_template_part( 'template-parts/social' ); ?>

	<?php
	$center_class = false;
	if ( has_custom_logo() ) {
		$center_class = true;
	}
	?>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding container <?php echo $center_class ? 'centered-branding' : '' ?>">
			<div class="row">
				<div class="col-md-4 col-sm-12 header-logo">
					<div class='site-logo'>
					<?php
					$header_textcolor = get_theme_mod( 'header_textcolor' );
					if ( function_exists( 'the_custom_logo' ) ) {
						if ( has_custom_logo() ) {
							the_custom_logo();
						}
					}
					?>
					</div>
				</div>

				<div class="col-md-8 col-sm-12 header-contact">
					<?php dynamic_sidebar('contact-sidebar'); ?>
				</div>
			</div>
		</div><!-- .site-branding -->
		<?php
		$enable_search  = get_theme_mod( 'newsmag_enable_menu_search', true );
		$enable_sticky  = get_theme_mod( 'newsmag_enable_sticky_menu', false );
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image          = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		?>
		<nav id="site-navigation" class="main-navigation <?php echo $enable_sticky ? 'stick-menu' : '' ?>"
		     role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php if ( $enable_sticky && ! empty( $image[0] ) ): ?>
							<div class="stick-menu-logo hidden-xs hidden-sm">
								<a href="<?php echo esc_url( get_home_url() ) ?>"><img
										src="<?php echo esc_url( $image[0] ); ?>"/></a>
							</div>
						<?php endif; ?>
						<button class="menu-toggle" aria-controls="primary-menu"
						        aria-expanded="false"><span class="fa fa-bars"></span></button>
						<?php
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array(
								             'theme_location' => 'primary',
								             'menu_id'        => 'primary-menu',
								             'items_wrap'     => '<ul id="%1$s" class="menu nav-menu %2$s">%3$s</ul>'
							             ) );

						} else {
							?>
							<div class="menu-all-pages-container">
								<ul id="primary-menu" class="menu nav-menu menu" aria-expanded="false">
									<li id="menu-item-1636"
									    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1636">
										<a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ) ?>"><?php echo __( 'Add a menu', 'newsmag' ); ?></a>
									</li>
								</ul>
							</div>
							<?php
						}
						?>
						<?php if ( $enable_search ): ?>
							<button href="#" class="search-form-opener" type="button"><span class="fa fa-search"></span>
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</nav><!-- #site-navigation -->
		<?php if ( $enable_search ): ?>
			<?php $search_query = get_search_query(); ?>
			<div class="header-search-form">
				<div class="container">
					<!-- Search Form -->
					<form role="search" method="get" id="searchform_topbar"
					      action="<?php echo esc_url_raw( home_url( '/' ) ); ?>">
						<label><span class="screen-reader-text"><?php echo __( 'Search for:', 'newsmag' ) ?></span>
							<input
								class="search-field-top-bar <?php echo $search_query === '' ? '' : 'opened'; ?>"
								id="search-field-top-bar"
								placeholder="<?php echo __( 'Type the search term', 'newsmag' ) ?>"
								value="<?php echo esc_attr( $search_query ); ?>" name="s"
								type="search">
						</label>
						<button id="search-top-bar-submit" type="button"
						        class="search-top-bar-submit <?php echo $search_query === '' ? '' : 'submit-button'; ?>"><span
								class="first-bar"></span><span
								class="second-bar"></span></button>
					</form>
				</div>
			</div>
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
