<?php
/**
 * @package PBI_Formatter
 * @version 1.0.0
*/
/*
Plugin Name: Code Formatter for PowerBI
Plugin URI: http://wordpress.org/plugins/code-formatter-for-powerbi/
Description: Use simple shortcodes to format your DAX and M code (all attributes are optional): [mcode theme=dark lineWidth=90 width=600px ]let a = 1 in a[/mcode]  [daxcode width=600px region=EU ]EVALUATE myTable[/daxcode]
Author: mogular GmbH
Version: 1.0.0
Author URI: https://durchblick-durch-daten.de
Github Repo: https://github.com/mogular/wp-powerbicodeformatter
*/

	function formatM($atts, $content = null, $tag = null) {
		return getCachedOrFromServiceM($content, $atts);
	}

	function formatDAX($atts, $content = null, $tag = null) {
		return getCachedOrFromServiceDAX($content, $atts);
	}
	
	function add_mformatter_stylesheet() {
		wp_register_style('mformatterstylesheet', '/wp-content/plugins/mformatter/mformatter.css');
		wp_enqueue_style('mformatterstylesheet');
	}
	
	function getCachedOrFromServiceDAX($daxcode, $atts = array())  {
		$region = isset($atts['region']) ? $atts['region'] : 'US';
		$cacheKey = 'daxcode#' . md5($daxcode) . '#' . $region;
		$cached = get_transient($cacheKey);
		$cacheDuration = 30 * 86400; // 1 month
		$width = isset($atts['width']) ? $atts['width'] : '100%';
			
		if(!empty($cached)){
			return '<iframe onload="this.height = (this.contentWindow.document.body.scrollHeight + 5) + \'px\'" title="" width="'. $width .'" height="" scrolling="no" frameborder="0" marginheight="0" class="daxcode daxcode-cached" srcdoc="' . htmlentities($cached) . '"> ' . htmlentities($daxcode) . ' </iframe>';
        } else {
			$res = wp_remote_post("https://www.daxformatter.com",
				array(
					'body' => array( 
						'fx' => $daxcode,
						'embed' => '1',
						'version' => '0.5.3', //see https://www.daxformatter.com/raw/
						'l' => 'short', // short/long lines
						's' => '1', // 1/2 space after function. no space after function
						'r' => $region // US/EU -> commas or semicolons
					),
					'timeout' => 60,
					'headers' => array('"Content-Type": "application/x-www-form-urlencoded"')
				));
			
			if(!is_wp_error($res)) {
				$formatted = $res['body'];
				set_transient($cacheKey, $formatted, $cacheDuration);
				return '<iframe onload="this.height = (this.contentWindow.document.body.scrollHeight + 5) + \'px\'" title="" width="100%" height="" scrolling="no" frameborder="0" marginheight="0" class="daxccode daxcode-fresh" srcdoc="' . htmlentities($formatted) . '"> . htmlentities($daxcode) . </iframe>';
			}
			return '<pre class="daxcode-error" > ' . htmlentities($daxcode) . '</pre>';
		}
	}
	
	function getCachedOrFromServiceM($mcode, $atts = array())  {

		$theme = isset($atts['theme']) ? $atts['theme'] : 'light';
		$lineWidth = isset($atts['lineWidth']) ? $atts['lineWidth'] : 100;
		$cacheKey = 'mcode#' . md5($mcode) . '#' . $theme . $lineWidth;
		$cached = get_transient($cacheKey);
		$cacheDuration = 30 * 86400; // 1 month
		$width = isset($atts['width']) ? $atts['width'] : '100%';
			
		if(!empty($cached)){
			return '<iframe onload="this.height = (this.contentWindow.document.body.scrollHeight + 5) + \'px\'" title="" width="'. $width .'" height="" scrolling="no" frameborder="0" marginheight="0" class="mcode mcode-cached" srcdoc="' . htmlentities($cached) . '"> ' . htmlentities($mcode) . ' </iframe>';
        } else {
			$res = wp_remote_post("https://m-formatter.azurewebsites.net/api/v2",
				array(
					'body' => array( 
						'code' => $mcode,  
						'resultType' => 'iframe',
						'theme' => $theme,
						'lineWidth' => $lineWidth
					),
					'timeout' => 60,
					'headers' => array('"Content-Type": "application/x-www-form-urlencoded"')
				));
			
			if(!is_wp_error($res)) {
				$formatted = $res['body'];
				set_transient($cacheKey, $formatted, $cacheDuration);
				return '<iframe onload="this.height = (this.contentWindow.document.body.scrollHeight + 5) + \'px\'" title="" width="100%" height="" scrolling="no" frameborder="0" marginheight="0" class="mcode mcode-fresh" srcdoc="' . htmlentities($formatted) . '"> ' . htmlentities($mcode) . ' </iframe>';
			}
			return '<pre class="mcode-error" > ' . htmlentities($mcode) . '</pre>';
		}
	}
	
 	function wpdocs_add_custom_shortcode() {
		add_shortcode('mcode', 'formatM');
		add_shortcode('daxcode', 'formatDAX');
	}

	function shortcodes_to_exempt_from_wptexturize( $shortcodes ) {
    	$shortcodes[] = 'mcode';
		$shortcodes[] = 'daxcode';
    	return $shortcodes;
	}
	
	add_action( 'init', 'wpdocs_add_custom_shortcode' );
	add_action( 'wp_print_styles', 'add_mformatter_stylesheet' );
	add_filter( 'no_texturize_shortcodes', 'shortcodes_to_exempt_from_wptexturize' );
