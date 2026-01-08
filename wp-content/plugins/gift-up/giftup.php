<?php
/**
 * Plugin Name: Gift Up
 * Plugin URI: https://www.giftup.com/
 * Description: The simplest way to sell your business’ gift cards online, all with no monthly fee. Gift cards are redeemable in-store via our app, and WooCommerce.
 * Version: 3.1.7
 * Author: Gift Up
 * Text Domain: gift-up
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Developer: Gift Up
 * Developer URI: https://www.giftup.com/
 * Author URI: https://www.giftup.com/
 * WC requires at least: 3.2.0
 * WC tested up to: 10.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class GiftUp {
	public $version = '3.1.3';

	protected static $_instance = null;


    public $woocommerce;

	/**
	 * Gift Up Options.
	 */
	public $options;

	/**
	 * Gift Up API.
	 */
	public $api;

	/**
	 * Gift Up Cache.
	 */
	public $cache;

	/**
	 * Gift Up Settings.
	 */
	public $settings;

	/**
	 * Gift Up Diagnostics.
	 */
	public $diagnostics;

	/**
	 * Main GiftUp instance. Ensures only one instance is loaded or can be loaded - @see 'GiftUp()'.
	 *
	 * @static
	 * @return  GiftUp
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, 'Not allowed!', '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, 'Not allowed!', '1.0.0' );
	}

	/**
	 * Make stuff.
	 */
	protected function __construct() {
		// Entry point.
		add_action( 'plugins_loaded', array( $this, 'initialize_plugin' ), 9 );
	}

	protected function maybe_define_constant( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	public function is_plugin_initialized() {
		return isset( GiftUp()->settings );
	}

	public function get_plugin_basename() {
		return plugin_basename( __FILE__ );
	}

	public function get_plugin_basedirectory() {
		return plugin_dir_path( __FILE__ );
	}

	public function initialize_plugin() {
		$this->define_constants();

		add_action( 'init', array( $this, 'load_translation' ) );
		
		$this->includes();

		// Instantiate global singletons.
		$this->options = new GiftUp_Options();
		$this->api = new GiftUp_API();
		$this->diagnostics = new GiftUp_Diagnostics();
		$this->cache = new GiftUp_Cache();
		$this->settings = new GiftUp_Settings();

		if ( $this->diagnostics->is_woocommerce_activated() ) {
			require_once GIFTUP_ABSPATH . 'includes/class-giftup-woocommerce.php';
			$this->woocommerce = new GiftUp_WooCommerce();
		}

		// Declare HPOS compatibility.
		add_action( 'before_woocommerce_init', array( $this, 'declare_hpos_compatibility' ) );

		// Declare Blocks compatibility.
		add_action( 'before_woocommerce_init', array( $this, 'declare_blocks_compatibility' ) );

		add_action( 'init', array( $this, 'on_init' ) );
	}

	public function define_constants() {
		$this->maybe_define_constant( 'GIFTUP_VERSION', $this->version );
		$this->maybe_define_constant( 'GIFTUP_ABSPATH', trailingslashit( $this->get_plugin_basedirectory() ) );
		$this->maybe_define_constant( 'GIFTUP_ACCEPTED_GIFTCARD_CODE', 'giftup_accepted_gift_card_code' );
		$this->maybe_define_constant( 'GIFTUP_REQUESTED_GIFTCARD_CODE', 'giftup_requested_gift_card_code' );
		$this->maybe_define_constant( 'GIFTUP_ORDER_META_CODE_KEY', '_giftup_code' );
		$this->maybe_define_constant( 'GIFTUP_ORDER_META_REQUESTED_BALANCE_KEY', '_giftup_requested_balance' );
		$this->maybe_define_constant( 'GIFTUP_ORDER_META_REDEEMED_BALANCE_KEY', '_giftup_redeemed_balance' );
		$this->maybe_define_constant( 'GIFTUP_WOO_MODE_DISCOUNT_COUPONS', 'DISCOUNT_COUPONS' );
		$this->maybe_define_constant( 'GIFTUP_WOO_MODE_API', 'API' );
	}

	public function includes() {
		require_once GIFTUP_ABSPATH . 'view/giftup-checkout.php';
		require_once GIFTUP_ABSPATH . 'includes/class-giftup-cache.php';
		require_once GIFTUP_ABSPATH . 'includes/class-giftup-api.php';
		require_once GIFTUP_ABSPATH . 'includes/class-giftup-options.php';
		require_once GIFTUP_ABSPATH . 'includes/class-giftup-settings.php';
		require_once GIFTUP_ABSPATH . 'includes/class-giftup-diagnostics.php';
		require_once GIFTUP_ABSPATH . 'blocks/build/checkout-block/giftup-checkout-block-integration.php';
	}

	/**
	 * Take PO file name for all JSON files in gift_up
	 */
	public function compile_single_json_for_gift_up( $jsonPath, $poPath ){
		$info = pathinfo($poPath);
		if( str_starts_with($info['filename'], 'gift-up') ){
			$path = $info['dirname'].'/'.$info['filename'].'.json';
		}
		return $path;
	}

	/**
	 * Strip MD5 suffix from all JSON files in gift_up
	 */
	public function load_single_json_for_gift_up( $file, $handle, $domain ){
		if( 'gift-up' === $domain && is_string($file) ){
			$file = substr($file,0,strlen($file)-38).'.json';
		}
		return $file;
	}

	public function load_translation() {
		$path = basename( dirname( __FILE__ ) ) . '/languages';
		$result = load_plugin_textdomain( 'gift-up', false, $path );

		add_filter('loco_compile_single_json', array( $this, 'compile_single_json_for_gift_up' ),999,2);
		add_filter('load_script_translation_file', array( $this, 'load_single_json_for_gift_up' ),999,3);
	}

	public function declare_hpos_compatibility() {
		if ( ! class_exists( 'Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			return;
		}

		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', GiftUp()->get_plugin_basename(), true );
	}

	public function declare_blocks_compatibility() {
		if ( ! class_exists( 'Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			return;
		}

		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', GiftUp()->get_plugin_basename(), true );
	}

	function on_init() {
		add_shortcode( 'giftup', 'giftup_shortcode' );

		$current_plugin_version = GIFTUP_VERSION;
		$current_db_version = GiftUp()->options->get_version();

		// Upgrade from v1 standard to v2
		if ( !$current_db_version ) {
			GiftUp()->options->upgrade_from_v1();

			if ( GiftUp()->options->has_api_key()
				&& GiftUp()->options->get_woocommerce_enabled() == null
				&& GiftUp()->diagnostics->woocommerce_installed_version() > 0) {

				$wc_status = GiftUp()->api->get_woocommerce_connection_status();

				if ( $wc_status != null && $wc_status['isConnected'] == true ) {
					GiftUp()->options->set_woocommerce_enabled( true );
				} else {
					GiftUp()->options->set_woocommerce_enabled( false );
				}
			} else {
				GiftUp()->options->set_woocommerce_operating_mode( GIFTUP_WOO_MODE_API );
			}

			GiftUp()->options->set_version( $current_plugin_version );
		}

		if ( GiftUp()->options->has_api_key()
			&& GiftUp()->options->get_woocommerce_operating_mode() != GIFTUP_WOO_MODE_API
			&& GiftUp()->options->get_woocommerce_enabled() ) {
				GiftUp()->api->notify_connect_woocommerce();
		}
		
		$response = register_block_type_from_metadata( GIFTUP_ABSPATH . 'blocks/build/checkout-block/block.json' );

		GiftUp_Checkout_Block_Integration::instance()->initialize();
	}

	public function on_deactivation() {
		if ( $this->options->get_woocommerce_enabled() ) {
        	GiftUp()->settings->delete_woocommerce_webhook();

			if ( $this->options->has_api_key()
				&& $this->options->get_woocommerce_operating_mode() == GIFTUP_WOO_MODE_API) {
					GiftUp()->api->notify_disconnect_woocommerce();
			}
		}
	}
}

/**
 * Returns the main instance of GiftUp to prevent the need to use globals.
 *
 * @return  GiftUp
 */
function GiftUp() {
	return GiftUp::instance();
}

GiftUp();

function giftup_on_uninstall() {
	remove_shortcode( 'giftup' );

	delete_option( "giftup_company_id" );
	delete_option( "giftup_api_key" );
	delete_option( "giftup_version" );
	delete_option( "giftup_woocommerce_operating_mode" );
	delete_option( "giftup_woocommerce_enabled" );
	delete_option( "giftup_woocommerce_apply_to_shipping" );
	delete_option( "giftup_woocommerce_apply_to_taxes" );
}

register_uninstall_hook( __FILE__, 'giftup_on_uninstall' );
register_deactivation_hook( __FILE__, array( GiftUp(), 'on_deactivation') );
