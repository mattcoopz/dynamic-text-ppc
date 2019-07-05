<?php
/**
 * Plugin Name: Dynamic Text PPC
 * Plugin URI: 
 * Description: Create dynamic headings from URL parameters.
 * Version: 1.6
 * Author: Matt Cooper
 * Author URI: https://onswitch.com.au
 * License: GPLv3 or later
*/

/*  © Copyright 2019  Matt Cooper  ( https://onswitch.com.au )

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}


// Attach the default style in the css to the plugin
function dtppc_user_scripts() {
	wp_enqueue_style('main-styles', plugins_url( '/assets/css/dynamic-text-ppc.css' , __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'dtppc_user_scripts' );
	
// ============= Custom settings for the Dynamic Text PPC Function - Options sections within the Settings > General page
add_action('admin_init', 'my_dynamic_text_section');  
function my_dynamic_text_section() {  
    add_settings_section(  
        'my_dynamic_text_section', // Section ID 
        'Dynamic Text Settings', // Section Title
        'my_section_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'dtppc_url_parameter_1', // Option ID
        'Parameter 1 name to look for:', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'my_dynamic_text_section', // Name of our section
        array( // The $args
            'dtppc_url_parameter_1' // Should match Option ID
        )  
    ); 

    add_settings_field( // Option 2
        'dtppc_url_parameter_2', // Option ID
        'Parameter 2 name to look for:', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_dynamic_text_section', // Name of our section (General Settings)
        array( // The $args
            'dtppc_url_parameter_2' // Should match Option ID
        )  
    ); 

    add_settings_field( // Option 3
        'dtppc_style_parameter_3', // Option ID
        'Default style to use as fallback:', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_dynamic_text_section', // Name of our section (General Settings)
        array( // The $args
            'dtppc_style_parameter_3' // Should match Option ID
        )  
	);

    add_settings_field( // Option 4
        'dtppc_fallback_parameter_4', // Option ID
        'Use page title as the fallback:', // Label
        'my_checkbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_dynamic_text_section', // Name of our section (General Settings)
        array( // The $args
            'dtppc_fallback_parameter_4' // Should match Option ID
        )  
	);
	
    register_setting('general','dtppc_url_parameter_1', 'esc_attr');
    register_setting('general','dtppc_url_parameter_2', 'esc_attr');
    register_setting('general','dtppc_style_parameter_3', 'esc_attr');
    register_setting('general','dtppc_fallback_parameter_4', 'esc_attr');
}

function my_section_options_callback() { // Section Callback
    echo '<p>Add or edit up to two parameters you wish the plugin to look for within the URL. These parameters will be the fallbacks if no parameters are added to the shortcode.<br />The final parameter is the style that you can set as a fallback for the display.</p>';  
}

function my_textbox_callback($args) {  // Textbox Callback to save the parameters
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

function my_checkbox_callback($args) {  // Checkbox Callback to save the parameters
    $option = get_option($args[0]);
	$isitchecked = '';
	if ($option == 1){ $isitchecked = 'checked';}
    echo '<input type="checkbox" id="'. $args[0] .'" name="'. $args[0] .'" value="1" '. $isitchecked  .'/>';
}

// Get the stylesheet for the plugin and use the style within as the final fallback
function add_my_stylesheet() 
{
    wp_enqueue_style( 'myCSS', plugins_url( '/css/dynamic-text-ppc.css', __FILE__ ) );
}
add_action('admin_print_styles', 'add_my_stylesheet');


//============================= Create the shortcode and check for the parameters being passed and the various fallbacks 
add_shortcode('display_keyword_ppc','keyword_ppc_output');

//perform the shortcode output
function keyword_ppc_output($atts, $content = '', $tag){
	global $post;
	extract( shortcode_atts( array(
		'backup_term' => '',
		'findthisparameter' => '',
		'pre_term' => '',
		'post_term' => '',
		'style_class' => '',
		'which_tag' => 'p',
	), $atts ) );
	
// If the findthisparameter is blank then check if there are parameters to look for within the database  
	if ($findthisparameter == ''){
		$saved_parameter1 = get_option('dtppc_url_parameter_1');   // Parameter 1 name to look for
		$saved_parameter2 = get_option('dtppc_url_parameter_2');   // Parameter 2 name to look for
		if ($saved_parameter1 != ''){
			$findthisparameter = $saved_parameter1;
		}elseif ($saved_parameter2 != ''){
			$findthisparameter = $saved_parameter2;
		}
	}

// Get the parameter from the URL if possible	
	$search_term = $_GET[$findthisparameter];   

	$saved_parameter_style = get_option('dtppc_style_parameter_3');   // Default style to use as fallback
	$saved_fallback_title = get_option('dtppc_fallback_parameter_4');   // Use page title as the fallback
	
// If the user has set a fallback style then set the style to that parameter
	if ($saved_parameter_style != '' && $style_class == ''){
		$style_class = $saved_parameter_style;
	}

// If there is no parameter passed in the URL and "Use page title" has been set
	if ($search_term == '' && $saved_fallback_title == 1){   
		$backup_term = $post->post_title;
	}

	/* Build up HTML to display */
    $html = '';
	$html .= '<'. $which_tag;
	$html .= ' class="'. $style_class .'"';

    if ($search_term != ''){
		$search_term = str_replace('-',' ', $search_term);
		$html .= '>'. $pre_term .' '. $search_term .' '.$post_term .'</'. $which_tag .'>';
	}else{
		$html .= '>'. $pre_term .' '. $backup_term .' '.$post_term .'</'. $which_tag .'>';
	}
    return $html;
}
