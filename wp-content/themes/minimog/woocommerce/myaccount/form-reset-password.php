<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>

	<div class="woocommerce-form-wrap woocommerce-form-has-background woocommerce-form-reset-password-wrap">

		<h2><?php esc_html_e( 'Reset your password', 'minimog' ); ?></h2>
		<p><?php echo apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'minimog' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

		<form method="post" class="woocommerce-ResetPassword lost_reset_password">
			<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
				<label for="password_1"><?php esc_html_e( 'New password', 'minimog' ); ?>&nbsp;<span
						class="required">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'minimog' ); ?></span></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1"
				       id="password_1" autocomplete="new-password" required aria-required="true"/>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
				<label for="password_2"><?php esc_html_e( 'Re-enter new password', 'minimog' ); ?>&nbsp;<span
						class="required">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'minimog' ); ?></span></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2"
				       id="password_2" autocomplete="new-password" required aria-required="true"/>
			</p>

			<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>"/>
			<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>"/>

			<div class="clear"></div>

			<?php do_action( 'woocommerce_resetpassword_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<input type="hidden" name="wc_reset_password" value="true"/>
				<button type="submit" class="woocommerce-Button button <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ); ?>"
				        value="<?php esc_attr_e( 'Save', 'minimog' ); ?>"><?php esc_html_e( 'Save', 'minimog' ); ?></button>
			</p>

			<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

		</form>
	</div>
<?php
do_action( 'woocommerce_after_reset_password_form' );

