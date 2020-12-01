<?php
/**
 * @package M_Formatter
 * @version 0.1.0
*/
/*
Plugin Name: Power Query Formatter
Plugin URI: http://wordpress.org/plugins/powerqueryformatter/
Description: Use a simple shortcode to format your mcode: [mcode]let a = 1 in a[/mcode]
Author: mogular GmbH
Version: 0.1.0
Author URI: https://durchblick-durch-daten.de
*/

	function formatM($atts, $content = null, $tag = null) {
		return getCachedOrFromService($content, $atts);
	}
	
	function add_mformatter_stylesheet() {
		wp_register_style('mformatterstylesheet', '/wp-content/plugins/mformatter/mformatter.css');
		wp_enqueue_style('mformatterstylesheet');
	}
	
	
	// 1 day default cache-duration
	function getCachedOrFromService($mcode, $atts = array(), $cacheDuration = 86400)  {
		$cacheKey = 'mcode#' . md5($mcode . serialize($atts));
		$cached = get_transient($cacheKey);
		
		if(!empty($cached)){
			return 'Cached' . $cached;
        } else {
			$request_body = json_encode(array( "code" => $mcode, "config" => $atts ));
			$res =
				wp_remote_post("https://m-formatter.azurewebsites.net/api/format/v1", 
				array(
					'body' => $request_body,
					'timeout' => 60,
					'headers' => array('"Content-Type": "application/json"')
				));
			
			if(!is_wp_error($res) && ($res['response']['code'] == 200 || $res['response']['code'] == 201)) {
				$result = json_decode($res['body']);
				if(empty($result->{'errors'})) {
					$formatted = $result->{'result'};
					set_transient($cacheKey, $formatted, $cacheDuration);
					return $formatted;	
				}
			}
			return '<p style="color:red;">Error formatting:</p> ' . $mcode;
		}
	}
	
	add_action( 'init', 'wpdocs_add_custom_shortcode' );
	add_action( 'wp_print_styles', 'add_mformatter_stylesheet' );
 
	function wpdocs_add_custom_shortcode() {
		add_shortcode('mcode', 'formatM');
	}
	
?>