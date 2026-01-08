<?php

class GiftUp_Options
{
    public function __construct()
    {
        $args = array(
			'type'         => 'string',
			'show_in_rest' => true
        );

        register_setting( 'giftup', 'giftup_company_id', $args );
    }

    public function has_api_key() {
        if ($this->get_api_key()) {
            return true;
        }

        return false;
    }

    public function get_version() {
        return $this->get_option( "version" );
    }
    public function set_version( $value ) {
        return $this->update_option( "version", $value );
    }

    public function get_company_id() {
        return $this->get_option( "company_id" );
    }
    public function set_company_id( $value ) {
        return $this->update_option( "company_id", $value );
    }

    public function get_api_key() {
        $key = $this->get_option( "api_key" );
        return apply_filters('giftup_api_key', $key, 10);
    }
    public function set_api_key( $value ) {
        return $this->update_option( "api_key", $value );
    }

    public function get_woocommerce_enabled() {
        return $this->get_option( "woocommerce_enabled" );
    }
    public function set_woocommerce_enabled( $value ) {
        return $this->update_option( "woocommerce_enabled", $value );
    }

    public function get_woocommerce_apply_to_shipping() {
        return $this->get_option( "woocommerce_apply_to_shipping" );
    }
    public function set_woocommerce_apply_to_shipping( $value ) {
        return $this->update_option( "woocommerce_apply_to_shipping", $value );
    }

    public function get_woocommerce_apply_to_taxes() {
        return $this->get_option( "woocommerce_apply_to_taxes" );
    }
    public function set_woocommerce_apply_to_taxes( $value ) {
        return $this->update_option( "woocommerce_apply_to_taxes", $value );
    }

    public function get_woocommerce_is_in_test_mode() {
        return current_user_can('administrator') && isset($_COOKIE["giftup_test_mode"]) && $_COOKIE["giftup_test_mode"] == "test";
    }

    public function get_woocommerce_test_mode_cookie_set() {
        return isset($_COOKIE["giftup_test_mode"]) && $_COOKIE["giftup_test_mode"] == "test";
    }

    public function get_woocommerce_diagnostics_mode() {
        return isset($_COOKIE["giftup_diagnostics_mode"]) && $_COOKIE["giftup_diagnostics_mode"] == "on";
    }

    // Can be either 'DISCOUNT_COUPONS' or 'API'
    public function get_woocommerce_operating_mode() {
        $setting = $this->get_option( "woocommerce_operating_mode" );

        if ($setting == null || strlen($setting) == 0) {
            return GIFTUP_WOO_MODE_DISCOUNT_COUPONS;
        }

        return $setting;
    }

    public function set_woocommerce_operating_mode( $value ) {
        return $this->update_option( "woocommerce_operating_mode", $value );
    }

    public function disconnect() {
        GiftUp()->api->notify_disconnect_woocommerce();
        GiftUp()->settings->delete_woocommerce_webhook();

        delete_option( "giftup_company_id" );
        delete_option( "giftup_api_key" );
        delete_option( "giftup_version" );
        delete_option( "giftup_woocommerce_operating_mode" );
        delete_option( "giftup_woocommerce_enabled" );
        delete_option( "giftup_woocommerce_apply_to_shipping" );
        delete_option( "giftup_woocommerce_apply_to_taxes" );
    }

    public function upgrade_from_v1() {
        // Fix options so that they have a giftup_ prefix due to a v1 plugin bug
        if ( !get_option( "giftup_company_id" ) && get_option( "company_id" )) {
            update_option( "giftup_company_id", get_option( "company_id" ));
            delete_option( "company_id" );

            update_option( "giftup_api_key", get_option( "api_key" ));
            delete_option( "api_key" );
        }
    }

    private function get_option( $option, $default = false ) {
        return get_option( "giftup_$option", $default );
    }
    private function update_option( $option, $value ) {
        return update_option( "giftup_$option", $value );
    }
}
