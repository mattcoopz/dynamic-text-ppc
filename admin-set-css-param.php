<?php 
// ============================================= Custom settings for setting default style and parameter to search for
add_action('admin_init', 'my_vouchersend_section');  
function my_vouchersend_section() {  
    add_settings_section(  
        'my_vouchersend_section', // Section ID 
        'Gift Voucher Specific Settings', // Section Title
        'my_section_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'option_vouchersend_user', // Option ID
        'Send Copy Voucher to:', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'my_vouchersend_section', // Name of our section
        array( // The $args
            'option_vouchersend_user' // Should match Option ID
        )  
    ); 

    add_settings_field( // Option 1
        'option_notify_product', // Option ID
        'ID of product to be notified about:', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'my_vouchersend_section', // Name of our section
        array( // The $args
            'option_notify_product' // Should match Option ID
        )  
    ); 

	
    register_setting('general','option_vouchersend_user', 'esc_attr');
    register_setting('general','option_notify_product', 'esc_attr');
}

function my_section_options_callback() { // Section Callback
    echo '<p>Editing this information will effect where notifications are sent.</p>';  
}

function my_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

?>