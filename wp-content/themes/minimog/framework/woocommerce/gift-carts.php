<?php

namespace Minimog\Woo;

defined( 'ABSPATH' ) || exit;

class WC_Gift_Cards {

	protected static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function initialize() {
		if ( ! $this->activate() ) {
			return;
		}

		add_action( 'minimog/cart_actions/after', [ $this, 'output_gift_cards_toggle_button' ] );

		add_action( 'woocommerce_gc_before_apply_gift_card_form', [ $this, 'add_modal_wrap_before' ], -9999 );
		add_action( 'woocommerce_gc_after_apply_gift_card_form', [ $this, 'add_modal_wrap_after' ], 9999 );
	}

	public function activate() {
		return class_exists( '\WC_Gift_Cards' );
	}

	public function output_gift_cards_toggle_button() {
		if ( ! function_exists( 'wc_gc_is_ui_disabled' ) || ! wc_gc_is_ui_disabled() ) {
			return;
		}
		?>
		<a href="#"
		   data-minimog-toggle="modal"
		   data-minimog-target="#modal-cart-gift-cards"
		>
			<span class="icon">
				<svg class="w-[22px] h-[22px]" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
				     viewBox="0 0 576 512">
				<path
					d="M288 101L326.8 38.97C341.9 14.73 368.5 0 397.1 0H400C444.2 0 480 35.82 480 80C480 98.01 474 114.6 464 128H512C547.3 128 576 156.7 576 192V448C576 483.3 547.3 512 512 512H64C28.65 512 0 483.3 0 448V192C0 156.7 28.65 128 64 128H111.1C101.1 114.6 96 98.01 96 80C96 35.82 131.8 0 176 0H178.9C207.5 0 234.1 14.73 249.2 38.97L288 101zM397.1 32C379.5 32 363.2 41.04 353.9 55.93L308.9 128H400C426.5 128 448 106.5 448 80C448 53.49 426.5 32 400 32H397.1zM267.1 128L222.1 55.93C212.8 41.04 196.5 32 178.9 32H176C149.5 32 128 53.49 128 80C128 106.5 149.5 128 176 128H267.1zM64 160C46.33 160 32 174.3 32 192V288H544V192C544 174.3 529.7 160 512 160H322.2L380.3 229.8C385.9 236.5 385 246.6 378.2 252.3C371.5 257.9 361.4 257 355.7 250.2L288 168.1L220.3 250.2C214.6 257 204.5 257.9 197.8 252.3C190.1 246.6 190.1 236.5 195.7 229.8L253.8 160H64zM32 320V384H544V320H32zM544 448V416H32V448C32 465.7 46.33 480 64 480H512C529.7 480 544 465.7 544 448z"/>
			</svg>
			</span>
			<span><?php esc_html_e( 'Gift Cards', 'minimog' ); ?></span>
		</a>
		<?php
	}

	public function add_modal_wrap_before() {
		?>
		<div class="minimog-modal modal-cart modal-cart-gift-cards" id="modal-cart-gift-cards" aria-hidden="true" role="dialog" hidden>
		<div class="modal-overlay"></div>
		<div class="modal-content">
		<div class="button-close-modal" role="button" aria-label="<?php esc_attr_e( 'Close', 'minimog' ); ?>"></div>
		<div class="modal-content-wrap">
		<div class="modal-content-inner">
		<?php
	}

	public function add_modal_wrap_after() {
		?>
		</div></div></div></div>
		<?php
	}
}

WC_Gift_Cards::instance()->initialize();
