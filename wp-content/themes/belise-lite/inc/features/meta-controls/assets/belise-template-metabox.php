<?php
/**
 * Register a meta.
 *
 * @package Belise
 */

/**
 * Class Belise_Template_Meta_Box
 */
class Belise_Template_Meta_Box {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php', array( $this, 'belise_init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'belise_init_metabox' ) );
		}

	}

	/**
	 * Meta box initialization.
	 */
	public function belise_init_metabox() {
		add_action( 'add_meta_boxes', array( $this, 'belise_add_metabox' ) );
		add_action( 'save_post', array( $this, 'belise_save_metabox' ), 10, 2 );
	}


	/**
	 * Adds the meta box.
	 */
	public function belise_add_metabox() {
		global $post;
		if ( ! empty( $post ) ) {
			$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
			$is_blog_page  = ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) === $post->ID );
			$is_shop       = get_option( 'woocommerce_shop_page_id' ) === $post->ID;
			if ( $is_shop || $is_blog_page || $page_template === 'template-with-header.php' || $page_template === 'template-full-width.php' || $page_template === 'template-main-events.php' ) {
				add_meta_box(
					'belise-text-before-title',
					__( 'Text before title', 'belise-lite' ),
					array( $this, 'belise_render_metabox' ),
					'page',
					'side',
					'default'
				);
			}
		}
	}

	/**
	 * Renders the meta box.
	 */
	public function belise_render_metabox( $post ) {

		wp_nonce_field( basename( __FILE__ ), 'belise_nonce' );
		$belise_stored_meta = get_post_meta( $post->ID );

		?>


		<div class="belise-row-content">
			<label for="hide-header-checkbox">
				<input type="text" name="text-before-title" id="text-before-title"
						value="
						<?php
						if ( isset( $belise_stored_meta['text-before-title'] ) ) {
							echo esc_attr( $belise_stored_meta['text-before-title'][0] );
						}
?>
"/>
			</label>

		</div>


		<?php
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int $post_id Post ID.
	 */
	public function belise_save_metabox( $post_id ) {

		// Checks save status - overcome autosave, etc.
		$is_autosave    = wp_is_post_autosave( $post_id );
		$is_revision    = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST['belise_nonce'] ) && wp_verify_nonce( $_POST['belise_nonce'], basename( __FILE__ ) ) ) ? 'true' : 'false';

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}

		// Checks for input and saves - save checked as yes and unchecked at no
		if ( isset( $_POST['text-before-title'] ) ) {
			update_post_meta( $post_id, 'text-before-title', $_POST['text-before-title'] );
		}

	}
}

new Belise_Template_Meta_Box();
