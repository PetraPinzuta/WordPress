<?php
/**
 * File to include meta fields for nova menu, woo categories and
 * metabox for Page with header template
 *
 * @package Belise
 */

// Require metabox class
require_once get_template_directory() . '/inc/features/meta-controls/assets/belise-template-metabox.php';

// Require meta fields
$belise_file_to_include = BELISE_PHP_INCLUDE . '/features/meta-controls/assets/belise-meta-fields.php';
if ( file_exists( $belise_file_to_include ) ) {
	require_once $belise_file_to_include;
}
