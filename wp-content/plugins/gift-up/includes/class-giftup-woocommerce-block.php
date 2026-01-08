<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema;

class GiftUp_WooCommerce_Block {

	public static function init()
    {
        add_action( 'init', array( __CLASS__, 'woocommerce_register_cart_block' ) );
    }
    
    public static function woocommerce_register_cart_block() {
        if ( interface_exists('Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface') ) {
            
            require_once GIFTUP_ABSPATH . 'blocks/build/apply-block/giftup-apply-block-integration.php';
            $response = register_block_type_from_metadata( GIFTUP_ABSPATH . 'blocks/build/apply-block/block.json' );

            add_action(
                'woocommerce_blocks_cart_block_registration',
                function ( $integration_registry ) {
                    $integration_registry->register( GiftUp_Apply_Block_Integration::instance() );
                }
            );

            add_action(
                'woocommerce_blocks_checkout_block_registration',
                function ( $integration_registry ) {
                    $integration_registry->register( GiftUp_Apply_Block_Integration::instance() );
                }
            );

            if (function_exists('woocommerce_store_api_register_update_callback')) {
                woocommerce_store_api_register_update_callback(
                    [
                        'namespace' => 'giftup-apply-code',
                        'callback'  => function ( $data ) {
                            $giftCardCode = $data['giftCardCode'];

                            GiftUp()->woocommerce->apply_gift_card_to_cart( WC()->cart, $giftCardCode );
                        }
                    ]
                );

                woocommerce_store_api_register_update_callback(
                    [
                        'namespace' => 'giftup-remove-code',
                        'callback' => function ($data) {
                            GiftUp()->woocommerce->apply_gift_card_to_cart( WC()->cart, '' );
                        }
                    ]
                );
            }

            if (function_exists('woocommerce_store_api_register_endpoint_data')) {
                woocommerce_store_api_register_endpoint_data(
                    array(
                        'endpoint' => CartSchema::IDENTIFIER,
                        'namespace' => 'giftup-apply-block',
                        'data_callback' => function() {

                            $giftcard_not_found = strlen(GiftUp()->cache->get_requested_gift_card_code()) > 0
                                                    && GiftUp()->cache->get_accepted_gift_card_code() == null;
                            $giftcard_code = GiftUp()->cache->get_accepted_gift_card_code();
                            $giftcard_applied_balance = GiftUp()->cache->applied_gift_card_balance;
                            $giftcard_balance = GiftUp()->api->get_gift_card_balance($giftcard_code);
                    
                            return [
                                'giftcard_not_found' => $giftcard_not_found,
                                'giftcard_code' => $giftcard_code,
                                'giftcard_balance' => html_entity_decode(strip_tags(wc_price($giftcard_balance))),
                                'giftcard_applied_balance' => $giftcard_applied_balance
                            ];
                        },
                        'schema_type' => ARRAY_A
                    )
                );
            }
        }
    }
}

GiftUp_WooCommerce_Block::init();
