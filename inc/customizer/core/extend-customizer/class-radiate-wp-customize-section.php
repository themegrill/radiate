<?php
/**
 * Extend customize section to include nested sections.
 *
 * Class Radiate_WP_Customize_Section
 *
 * @package    ThemeGrill
 * @subpackage Radiate
 * @since      Radiate 3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extend customize section to include nested sections.
 *
 * Class Radiate_WP_Customize_Section
 */
class Radiate_WP_Customize_Section extends WP_Customize_Section {

	/**
	 * Section
	 *
	 * @var string
	 */
	public $section;

	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'radiate_section';

	/**
	 * Get section parameters for JS.
	 *
	 * @return array Exported parameters.
	 */
	public function json() {

		$array                   = wp_array_slice_assoc(
			(array) $this,
			array(
				'id',
				'description',
				'priority',
				'panel',
				'type',
				'description_hidden',
				'section',
			)
		);
		$array['title']          = html_entity_decode(
			$this->title,
			ENT_QUOTES,
			get_bloginfo( 'charset' )
		);
		$array['content']        = $this->get_content();
		$array['active']         = $this->active();
		$array['instanceNumber'] = $this->instance_number;

		if ( $this->panel ) {
			$array['customizeAction'] = sprintf(
				esc_html__( 'Customizing &#9656; %s', 'radiate' ),
				esc_html( $this->manager->get_panel( $this->panel )->title )
			);
		} else {
			$array['customizeAction'] = esc_html__( 'Customizing', 'radiate' );
		}

		return $array;

	}

}
