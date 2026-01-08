<?php
if ( ! empty( $attributes['companyId'] ) ) {
    $companyId = $attributes['companyId'];
} else {
    $companyId = GiftUp()->options->get_company_id();
}

$companyId = trim( sanitize_text_field( $companyId ) );

// Quotation sanitization
$companyId = str_replace( "“", "", $companyId );
$companyId = str_replace( "”", "", $companyId );
$companyId = str_replace( "'", "", $companyId );
$companyId = str_replace( "„", "", $companyId );
$companyId = str_replace( "‘", "", $companyId );
$companyId = str_replace( "’", "", $companyId );
$companyId = str_replace( "‚", "", $companyId );

if ( strlen($companyId) == 36 ) {
    ?><div <?php echo get_block_wrapper_attributes(); ?>>
        <div class="gift-up-target gift-up-block <?php echo esc_attr($attributes['alignment'] ?? "") ?>" 
            data-site-id="<?php echo esc_attr($companyId) ?>" 
            data-product-id="<?php echo esc_attr($attributes['product'] ?? "") ?>"
            data-group-id="<?php echo esc_attr($attributes['group'] ?? "") ?>"
            data-payment-methods="<?php echo esc_attr($attributes['payment'] ?? "") ?>"
            data-language="<?php echo esc_attr($attributes['language'] ?? "") ?>"
            data-purchaser-name="<?php echo esc_attr($attributes['purchasername'] ?? "") ?>"
            data-purchaser-email="<?php echo esc_attr($attributes['purchaseremail'] ?? "") ?>"
            data-recipient-name="<?php echo esc_attr($attributes['recipientname'] ?? "") ?>"
            data-recipient-email="<?php echo esc_attr($attributes['recipientemail'] ?? "") ?>"
            data-step="<?php echo esc_attr($attributes['step'] ?? "") ?>"
            data-who-for="<?php echo esc_attr($attributes['whofor'] ?? "") ?>"
            data-promo-code="<?php echo esc_attr($attributes['promocode'] ?? "") ?>"
            data-hide-artwork="<?php echo esc_attr(($attributes['hideartwork'] ?? false) ? "true" : "false") ?>"
            data-hide-google-fonts="<?php echo esc_attr(($attributes['hidegooglefonts'] ?? false) ? "true" : "false") ?>"
            data-custom-value-amount="<?php echo esc_attr($attributes['customvalueamount'] ?? "") ?>"
            data-referrer="<?php echo esc_attr($attributes['referrer'] ?? "") ?>"
			data-optional-message="<?php echo esc_attr($attributes['optionalmessage'] ?? "") ?>"
            data-platform="Wordpress"
        ></div>
    </div><?php
}
else if (strlen($companyId) > 0) {
    echo __("Gift Up plugin notice to site admin:<br>Badly configured Account Id value of '" . $companyId . "'. Please ensure that you have entered a correct Gift Up Account Id in the block settings.");
}
else {
    echo __("Gift Up plugin notice to site admin:<br>Please connect your Gift Up account to WordPress in Settings / Gift Up!");
}
