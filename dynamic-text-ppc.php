<?php
/**
 * Plugin Name: Dynamic Text PPC
 * Plugin URI: 
 * Description: Create dynamic headings from URL parameters.
 * Version: 1.0
 * Author: Matt Coopz
 * Author URI:
 * License: GPL2
 
 Dynamic Text PPC is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Dynamic Text PPC is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}

//public function tab_style()
//{
	wp_enqueue_style( '/css/dynamic-text-ppc.css' );
//}
 
add_shortcode('display_keyword_ppc','keyword_ppc_output');
//perform the shortcode output
function keyword_ppc_output($atts, $content = '', $tag){
	extract( shortcode_atts( array(
		'backup_term' => '',
		'findthisparameter' => '',
		'pre_term' => '',
		'post_term' => '',
		'style_class' => '',
		'which_tag' => 'p',
	), $atts ) );
	$search_term = $_GET[$findthisparameter];
    $html = '';
    if ($search_term != ''){
		$html .= '<'. $which_tag;
		if ($style_class != ''){
			$html .= ' class="'. $style_class .'"';
		}else{
			$html .= ' class="default"';
		}
		$html .= '>'. $pre_term .' '. $search_term .' '.$post_term .'</'. $which_tag .'>';
	}else{
		$html .= '<'. $which_tag;
		if ($style_class != ''){
			$html .= ' class="'. $style_class .'"';
		}else{
			$html .= ' class="default"';
		}
		$html .= '>'. $pre_term .' '. $passed_term .' '.$post_term .'</'. $which_tag .'>';
		}
    return $html;
}

