<?php
/**
 * Search form file
 *
 * @package Belise
 */
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html__( 'Search for:', 'belise-lite' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search', 'belise-lite' ); ?>" value="<?php get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>
