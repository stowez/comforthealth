<?php
/**
 * Class for integrating with WooCommerce Blocks
 */
class GiftUp_Checkout_Block_Integration {

	/**
	 * The single instance of the class.
	 *
	 * @var GiftUp_Checkout_Block_Integration
	 */
	protected static $_instance = null;

	/**
	 * Main GiftUp_Checkout_Block_Integration instance. Ensures only one instance of GiftUp_Checkout_Block_Integration is loaded or can be loaded.
	 *
	 * @static
	 * @return GiftUp_Checkout_Block_Integration
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * When called invokes any initialization/setup for the integration.
	 */
	public function initialize() {
		add_action('enqueue_block_editor_assets', array($this, 'register_block_editor_scripts'));
		add_action('enqueue_block_assets', array($this, 'enqueue_block_assets'));
	}

    public function register_block_editor_scripts() {
		$handle 		   = 'giftup-checkout-block-editor';
        $script_path       = '/blocks/build/checkout-block/editor.js';
        $script_url        = plugins_url( 'gift-up' ) . $script_path;
        $script_asset_path = GIFTUP_ABSPATH . 'blocks/build/checkout-block/editor.asset.php';
        $script_asset      = file_exists( $script_asset_path )
            ? require $script_asset_path
            : array(
                'dependencies' => array(),
                'version'      => $this->get_file_version( $script_asset_path ),
            );

        wp_register_script(
            $handle,
            $script_url,
            $script_asset['dependencies'],
            $script_asset['version'],
            true
        );

        wp_set_script_translations($handle, 'gift-up', GIFTUP_ABSPATH . 'languages');
    }

    public function enqueue_block_assets() {
        $script_path = '/blocks/build/checkout-block/checkout.js';
        $script_url  = plugins_url( 'gift-up' ) . $script_path;

        wp_register_script(
			"giftup-checkout-external",
			$script_url,
			[],
			$this->get_file_version( $script_path ),
			array(
				'strategy' => 'defer'
			) );

        $style_path = '/blocks/build/checkout-block/checkout.css';
        $style_url  = plugins_url( 'gift-up' ) . $style_path;

        wp_register_style(
			"giftup-checkout-external",
			$style_url,
			[],
			$this->get_file_version( $style_path )
		);
	}
	
	/**
	 * Get the file modified time as a cache buster if we're in dev mode.
	 *
	 * @param string $file Local path to the file.
	 * @return string The cache buster value to use for the given file.
	 */
	protected function get_file_version( $file ) {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG && file_exists( $file ) ) {
			return filemtime( $file );
		}
		return GIFTUP_VERSION;
	}
}