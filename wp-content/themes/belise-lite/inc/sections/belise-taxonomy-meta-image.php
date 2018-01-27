<?php
/**
 * Taxonomy meta image
 *
 * @package WordPress
 * @since Belise 1.0
 */

/**
 * Add upload field to menu sections in Jetpack
 */
if ( ! class_exists( 'BeliseTaxonomyMetaImage' ) ) {
	/**
	 * Taxonomy meta image
	 */
	class BeliseTaxonomyMetaImage {

		/**
		 * Contruct
		 */
		public function __construct() {
		}

		/**
		 * Initialize the class and start calling our hooks and filters
		 */
		public function init() {
			// Nova menu
			add_action( 'nova_menu_add_form_fields', array( $this, 'belise_add_category_image' ), 10, 2 );
			add_action( 'created_nova_menu', array( $this, 'belise_save_category_image' ), 10, 2 );
			add_action( 'nova_menu_edit_form_fields', array( $this, 'admin' ), 10, 2 );
			add_action( 'edited_nova_menu', array( $this, 'belise_updated_category_image' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'belise_enqueue_media' ) );
			add_action( 'admin_footer', array( $this, 'belise_add_script' ) );

			// Categories
			add_action( 'category_add_form_fields', array( $this, 'belise_add_category_image' ), 10, 2 );
			add_action( 'created_category', array( $this, 'belise_save_category_image' ), 10, 2 );
			add_action( 'category_edit_form_fields', array( $this, 'admin' ), 10, 2 );
			add_action( 'edited_category', array( $this, 'belise_updated_category_image' ), 10, 2 );
		}

		/**
		 * Add a form field in the new category page
		 */
		public function belise_add_category_image( $taxonomy ) {
			?>
			<div class="form-field term-group">
				<label for="category-image-id"><?php esc_html_e( 'Image', 'belise-lite' ); ?></label>
				<input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
				<div id="category-image-wrapper"></div>
				<p>
					<input type="button" class="button button-secondary belise_media_button" id="belise_media_button" name="belise_media_button" value="<?php esc_attr_e( 'Add Image', 'belise-lite' ); ?>" />
					<input type="button" class="button button-secondary belise_media_remove" id="belise_media_remove" name="belise_media_remove" value="<?php esc_attr_e( 'Remove Image', 'belise-lite' ); ?>" />
				</p>
			</div>
			<?php
		}

		/**
		 * Save the form field
		 */
		public function belise_save_category_image( $term_id, $tt_id ) {
			if ( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ) {
				$image = $_POST['category-image-id'];
				add_term_meta( $term_id, 'category-image-id', $image, true );
			}
		}

		/**
		 * Edit the form field
		 */
		public function admin( $term, $taxonomy ) {
			?>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label for="category-image-id"><?php esc_html_e( 'Image', 'belise-lite' ); ?></label>
				</th>
				<td>
					<?php
					$image_id = get_term_meta( $term->term_id, 'category-image-id', true );
					?>
					<input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo esc_attr( $image_id ); ?>">
					<div id="category-image-wrapper">
						<?php if ( $image_id ) { ?>
							<?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
						<?php } ?>
					</div>
					<p>
						<input type="button" class="button button-secondary belise_media_button" id="belise_media_button" name="belise_media_button" value="<?php esc_attr_e( 'Add Image', 'belise-lite' ); ?>" />
						<input type="button" class="button button-secondary belise_media_remove" id="belise_media_remove" name="belise_media_remove" value="<?php esc_attr_e( 'Remove Image', 'belise-lite' ); ?>" />
					</p>
				</td>
			</tr>
			<?php
		}

		/**
		 * Update the form field value
		 */
		public function belise_updated_category_image( $term_id, $tt_id ) {
			if ( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ) {
				$image = $_POST['category-image-id'];
				update_term_meta( $term_id, 'category-image-id', $image );
			} else {
				update_term_meta( $term_id, 'category-image-id', '' );
			}
		}

		/**
		 * Enqueue media
		 */
		public function belise_enqueue_media() {
			wp_enqueue_media();
		}

		/**
		 * Add script
		 */
		public function belise_add_script( $hook ) {

			$screen = get_current_screen();
			if ( ! empty( $screen ) && ! empty( $screen->id ) && ( $screen->id !== 'appearance_page_belise-welcome' ) ) {
				wp_enqueue_script( 'customizer-editor-upload', get_template_directory_uri() . '/js/customizer-editor-upload.js', array( 'jquery' ), '', true );
			}

		}

	}

	$belise_taxonomy_meta_image = new BeliseTaxonomyMetaImage();
	$belise_taxonomy_meta_image->init();

}// End if().
