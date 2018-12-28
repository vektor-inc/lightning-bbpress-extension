<?php
/**
 * Plugin Name:     Lightning bbPress Extension
 * Plugin URI:
 * Description:
 * Author:          Vektor,Inc.
 * Author URI:
 * Text Domain:     lightning-bbpress-extension
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Lightning_BBpress_Extension
 */

 require 'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/vektor-inc/lightning-bbpress-extension',
	__FILE__, // Full path to the main plugin file or functions.php.
	'lightning-bbpress-extension'
);
 $myUpdateChecker->setBranch( 'master' );

/*-------------------------------------------*/
/*  フォーラムのパンくずリスト書き換え
/*-------------------------------------------*/
add_filter(
	'lightning_panListHtml', function( $panListHtml ) {
		if ( function_exists( 'bbp_get_forum_post_type' ) ) {
			$postType = lightning_get_post_type();
			if ( $postType['slug'] == 'topic' ) {

				// Microdata
				// http://schema.org/BreadcrumbList
				/*-------------------------------------------*/
				$microdata_li = ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"';

				$before_html = '<!-- [ .breadSection ] -->
<div class="section breadSection">
<div class="container">
<div class="row">
<ol class="breadcrumb" itemtype="http://schema.org/BreadcrumbList">';

				$after_html = '</ol>
</div>
</div>
</div>
<!-- [ /.breadSection ] -->';

				$args = array(
					// HTML
					'before'         => $before_html,
					'after'          => $after_html,
					'sep'            => '',
					'crumb_before'   => '<li' . $microdata_li . '><span>',
					'crumb_after'    => '</span></li>',
					'home_text'      => '<i class="fa fa-home"></i> HOME',
					'current_before' => '',
					'current_after'  => '',
				);
				$panListHtml = bbp_get_breadcrumb( $args );
			}
		}
		return $panListHtml;
	}
);
