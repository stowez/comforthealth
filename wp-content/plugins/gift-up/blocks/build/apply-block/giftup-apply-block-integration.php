<?php
use Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface;

/**
 * Class for integrating with WooCommerce Blocks
 */
class GiftUp_Apply_Block_Integration implements IntegrationInterface {

	/**
	 * The single instance of the class.
	 *
	 * @var GiftUp_Apply_Block_Integration
	 */
	protected static $_instance = null;

	/**
	 * Main GiftUp_Apply_Block_Integration instance. Ensures only one instance of GiftUp_Apply_Block_Integration is loaded or can be loaded.
	 *
	 * @static
	 * @return GiftUp_Apply_Block_Integration
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * The name of the integration.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'giftup-apply-block';
	}

	/**
	 * When called invokes any initialization/setup for the integration.
	 */
	public function initialize() {

		add_action('enqueue_block_editor_assets', array($this, 'register_block_editor_scripts'));
		add_action('enqueue_block_assets', array($this, 'register_block_frontend_scripts'));

		// Todo - replace...
		// add_action( 'wp_enqueue_scripts', array($this, 'wp_set_script_translations_editor' ) );
	}

	/**
	 * Returns an array of script handles to enqueue in the frontend context.
	 *
	 * @return string[]
	 */
	public function get_script_handles() {
		return array( 'giftup-apply-block-frontend' );
	}

	/**
	 * Returns an array of script handles to enqueue in the editor context.
	 *
	 * @return string[]
	 */
	public function get_editor_script_handles() {
		return array( 'giftup-apply-block-editor' );
	}

	/**
	 * An array of key, value pairs of data made available to the block on the client side.
	 *
	 * @return array
	 */
	public function get_script_data() {
		$data = array(
			'giftup-example' => true
		);

		return $data;
	}

    public function register_block_editor_scripts() {
		$handle 		   = 'giftup-apply-block-editor';
        $script_path       = '/blocks/build/apply-block/editor.js';
        $script_url        = plugins_url( 'gift-up' ) . $script_path;
        $script_asset_path = GIFTUP_ABSPATH . 'blocks/build/apply-block/editor.asset.php';
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

    public function register_block_frontend_scripts() {
		$handle 		   = 'giftup-apply-block-frontend';
        $script_path       = '/blocks/build/apply-block/frontend.js';
        $script_url        = plugins_url( 'gift-up' ) . $script_path;
        $script_asset_path = GIFTUP_ABSPATH . 'blocks/build/apply-block/frontend.asset.php';
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