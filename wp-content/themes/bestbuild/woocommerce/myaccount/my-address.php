<?php
/**
 * My Addresses
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) {
	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', __( 'My Addresses', 'woocommerce' ) );
	$get_addresses    = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => __( 'Billing Address', 'woocommerce' ),
		'shipping' => __( 'Shipping Address', 'woocommerce' )
	), $customer_id );
} else {
	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', __( 'My Address', 'woocommerce' ) );
	$get_addresses    = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' =>  __( 'Billing Address', 'woocommerce' )
	), $customer_id );
}
?>

<h4><?php echo balanceTags( $page_title, true ); ?></h4>

<p class="myaccount_address">
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) echo '<div class="row addresses">'; ?>

<?php foreach ( $get_addresses as $name => $title ) : ?>

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 address">
		<header class="title">
			<h4><?php echo balanceTags( $title, true ); ?></h4>
		</header>
			<?php
				$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
					'country'     => array(
						'title' => 'Country',
						'value' => get_user_meta( $customer_id, $name . '_country', true )
					),
					'first_name'     => array(
						'title' => 'Fist Name',
						'value' => get_user_meta( $customer_id, $name . '_first_name', true )
					),
					'last_name'     => array(
						'title' => 'Last Name',
						'value' => get_user_meta( $customer_id, $name . '_last_name', true )
					),
					'company'     => array(
						'title' => 'Company',
						'value' => get_user_meta( $customer_id, $name . '_company', true )
					),
					'address'     => array(
						'title' => 'Address',
						'value' => get_user_meta( $customer_id, $name . '_address_1', true ) .' / '. get_user_meta( $customer_id, $name . '_address_2', true )
					),
					'city'     => array(
						'title' => 'City',
						'value' => get_user_meta( $customer_id, $name . '_city', true )
					),
					'state'     => array(
						'title' => 'State',
						'value' => get_user_meta( $customer_id, $name . '_state', true )
					),
					'postcode'     => array(
						'title' => 'Postcode',
						'value' => get_user_meta( $customer_id, $name . '_postcode', true )
					)

				), $customer_id, $name );


				if ( ! $address )
					_e( 'You have not set up this type of address yet.', 'woocommerce' );
				else

					$output = '';
					$output .= '<table class="address-table">';
					$output .= '<tbody>';
					foreach($address as $value ) {
						$output .= '<tr><th>'. esc_html( $value['title'] ).'</th><td>'. esc_html( $value['value'] ).'</td></tr>';
					}
					$output .= '</tbody>';
					$output .= '</table>';
					echo balanceTags( $output, true );
			?>
		<footer>
			<a href="<?php echo wc_get_endpoint_url( 'edit-address', $name ); ?>" class="button edit"><?php _e( 'Edit', 'woocommerce' ); ?></a>
		</footer>
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) echo '</div>'; ?>
