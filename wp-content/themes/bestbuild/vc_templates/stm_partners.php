<?php
extract( shortcode_atts( array(
	'css' => ''
), $atts ) );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

?>

<div class="our_partners<?php echo esc_attr( $css_class ); ?>">
	<?php if( !empty( $content ) ){ ?>
		<ul>
			<?php echo wpb_js_remove_wpautop($content); ?>
		</ul>
	<?php } ?>
</div>