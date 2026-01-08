<?php

class GiftUp_Cache
{
    // Cache API gift card get API result per web request
    public $giftcard = null;

    // Cache some cart totals
    public $applied_gift_card_balance = 0;

    public function gift_card_found() {
        return $this->giftcard != null
               && strlen($this->get_accepted_gift_card_code()) > 0; 
    }

    public function get_requested_gift_card_code() {
        if (WC()->session) {
            return WC()->session->get( GIFTUP_REQUESTED_GIFTCARD_CODE );
        }
        return null;
    }

    public function get_accepted_gift_card_code() {
        if (WC()->session) {
            return WC()->session->get( GIFTUP_ACCEPTED_GIFTCARD_CODE );
        }
        return null;
    }

    public function set_gift_card_code( $code ) {
        if (WC()->session) {
            WC()->session->set( GIFTUP_REQUESTED_GIFTCARD_CODE, $code );

            if (empty($code) || $code == null) {
                WC()->session->set( GIFTUP_ACCEPTED_GIFTCARD_CODE, null );
            }
            else if (GiftUp()->api->get_gift_card($code) != null) {
                WC()->session->set( GIFTUP_ACCEPTED_GIFTCARD_CODE, $this->giftcard['code'] );
            }
            else {
                WC()->session->set( GIFTUP_ACCEPTED_GIFTCARD_CODE, null );
            }
        }
    }
}
