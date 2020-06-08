<?php

class Radiate_Upsell_Custom_Control extends WP_Customize_Control {

	public $type = "radiate-upsell-control";

	public function enqueue() {
		wp_enqueue_style( 'radiate-customizer', get_template_directory_uri() . '/inc/customize-controls/assets/css/customizer-upsell.css', array(), RADIATE_THEME_VERSION );
	}

	public function render_content() {
		?>
		<div class="radiate-upsell-wrapper">
			<ul class="upsell-features">
				<h3 class="upsell-heading"><?php esc_html_e( 'More Awesome Features', 'radiate' ); ?></h3>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'Advanced Header Options', 'radiate' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'Advanced Footer Options', 'radiate' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'More Blog Layout', 'radiate' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'Advanced Typography Options', 'radiate' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( '100+ Customizer Options', 'radiate' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'More WooCommerce Features', 'radiate' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'Page Settings', 'radiate' ); ?>
				</li>
			</ul>

			<div class="launch-offer">
				<?php
				printf(
				/* translators: %1$s discount coupon code., %2$s discount percentage */
					esc_html__( 'Use the coupon code %1$s to get %2$s discount (limited time offer). Enjoy!', 'radiate' ),
					'<span class="coupon-code">save10</span>',
					'10%'
				);
				?>
			</div>
		</div> <!-- /.radiate-upsell-wrapper -->

		<a class="upsell-cta" target="_blank"
		   href="<?php echo esc_url( 'https://themegrill.com/radiate-pricing/?utm_source=radiate-customizer&utm_medium=view-pricing-link&utm_campaign=upgrade' ); ?>"><?php esc_html_e( 'View Pricing', 'radiate' ); ?></a>
		<?php
	}

}

