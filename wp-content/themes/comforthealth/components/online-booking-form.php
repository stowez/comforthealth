<?php $formId = get_sub_field('form_id') ?: 4;?>
<section class="contained-content cmpnt booking-form">
        <div class="container">
            <div class="">
                <? the_sub_field('wysiwyg_content');?>
                <? gravity_form($formId, false, false, false, false, false); ?>
            </div>
        </div>
</section>
