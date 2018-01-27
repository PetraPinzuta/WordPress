<?php
/**
 * Ribbon section from footer
 *
 * @package WordPress
 * @since Belise 1.0
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function belise_ribbon_widget_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Ribbon area', 'belise-lite' ),
			'id'            => 'ribbon_area',
			'description'   => 'Add widgets here to display them on FrontPage within Ribbon Area',
			'before_widget' => '<div id="%1$s"><div class="container"><div class="row">',
			'after_widget'  => '</div></div></div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_widget( 'belise_ribbon_widget' );
}
add_action( 'widgets_init', 'belise_ribbon_widget_init' );

/*
 * Ribbon widget
 */
if ( ! class_exists( 'belise_ribbon_widget' ) ) {

	/**
	 * Class Belise_Ribbon_Widget
	 */
	class Belise_Ribbon_Widget extends WP_Widget {

		/**
		 * Constructor
		 */
		public function __construct() {
			parent::__construct(
				'belise_ribbon-widget',
				esc_html__( 'Belise - Ribbon', 'belise-lite' ),
				array(
					'customize_selective_refresh' => true,
				)
			);
			add_action( 'admin_enqueue_scripts', array( $this, 'widget_scripts' ) );
		}

		/**
		 * Enqueue scripts
		 */
		function widget_scripts( $hook ) {
			if ( $hook != 'widgets.php' ) {
				return;
			}
			wp_enqueue_media();
			wp_enqueue_script( 'belise_widget_media_script', get_template_directory_uri() . '/js/widget-media.js', false, '1.1', true );
		}

		/**
		 * Widget display
		 */
		function widget( $args, $instance ) {
			if ( ! empty( $args['before_widget'] ) ) {
				echo wp_kses_post( $args['before_widget'] );
			}
			?>
		</div></div>
		<div class="ribbon">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 text-center ribbon-content">
					<?php
						$title       = ! empty( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
						$text        = ! empty( $instance['text'] ) ? apply_filters( 'belise_translate_single_string', $instance['text'], 'Ribbon Widget' ) : '';
						$button      = ! empty( $instance['button_text'] ) ? apply_filters( 'belise_translate_single_string', $instance['button_text'], 'Ribbon Widget' ) : '';
						$button_link = ! empty( $instance['button_link'] ) ? apply_filters( 'belise_translate_single_string', $instance['button_link'], 'Ribbon Widget' ) : '';
						$image       = ! empty( $instance['image_uri'] ) ? apply_filters( 'belise_translate_single_string', $instance['image_uri'], 'Ribbon Widget' ) : '';
						?>
					<?php if ( ! empty( $title ) ) : ?>
						<h5><?php echo htmlspecialchars_decode( $title ); ?></h5>
					<?php endif; ?>

					<?php if ( ! empty( $text ) ) : ?>
						<h3><?php echo htmlspecialchars_decode( $text ); ?></h3>
					<?php endif; ?>

					<?php
					if ( ! empty( $button_link ) && ! empty( $button ) ) :
						echo '<a href="' . esc_url( $button_link ) . '" class="btn">' . htmlspecialchars_decode( $button ) . '</a>';
					endif;
					?>
				</div></div>
			</div>

			<?php
			if ( ! empty( $image ) && ( $image != 'Upload Image' ) ) {
				echo '<div class="ribbon-image" style="background: url(' . esc_url( $image ) . '); background-size:cover;)"></div>';
			} elseif ( ! empty( $instance['custom_media_id'] ) ) {
				$belise_custom_media_id = wp_get_attachment_image_url( $instance['custom_media_id'] );

				if ( ! empty( $belise_custom_media_id ) ) {
					echo '<div class="ribbon-image" style="background: url(' . esc_url( $belise_custom_media_id ) . '); background-size:cover;)"></div>';
				}
			}
			?>

		</div><div class="container"><div class="row">

			<?php
			if ( ! empty( $args['after_widget'] ) ) {
				echo wp_kses_post( $args['after_widget'] );
			}
		}

		/**
		 * Update
		 */
		function update( $new_instance, $old_instance ) {
			$instance                        = $old_instance;
			$instance['text']                = stripslashes( wp_filter_post_kses( $new_instance['text'] ) );
			$instance['title']               = strip_tags( $new_instance['title'] );
			$instance['button_text']         = strip_tags( $new_instance['button_text'] );
			$instance['button_link']         = strip_tags( $new_instance['button_link'] );
			$instance['image_uri']           = strip_tags( $new_instance['image_uri'] );
			$instance['custom_media_id']     = strip_tags( $new_instance['custom_media_id'] );
			$instance['image_in_customizer'] = strip_tags( $new_instance['image_in_customizer'] );
			$this->belise_ribbon_register( $instance, 'Ribbon Widget' );
			return $instance;
		}

		/**
		 * Widget form
		 */
		function form( $instance ) {
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'belise-lite' ); ?></label><br/>
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="
													<?php
													if ( ! empty( $instance['title'] ) ) :
														echo esc_attr( $instance['title'] );
endif;
?>
" class="widefat">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text', 'belise-lite' ); ?></label><br/>
				<textarea class="widefat" rows="3" cols="20" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>">
																				<?php
																				if ( ! empty( $instance['text'] ) ) :
																					echo htmlspecialchars_decode( $instance['text'] );
endif;
?>
</textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button text', 'belise-lite' ); ?></label><br/>
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" value="
													<?php
													if ( ! empty( $instance['button_text'] ) ) :
														echo esc_attr( $instance['button_text'] );
endif;
?>
" class="widefat">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'first-line' ) ); ?>"><?php esc_html_e( 'Button link', 'belise-lite' ); ?></label><br/>
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>" value="
													<?php
													if ( ! empty( $instance['button_link'] ) ) :
														echo esc_attr( $instance['button_link'] );
endif;
?>
" class="widefat">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image_uri' ) ); ?>"><?php esc_html_e( 'Image', 'belise-lite' ); ?></label><br/>

				<?php
				$image_in_customizer = '';
				$display             = 'none';
				if ( ! empty( $instance['image_in_customizer'] ) && ! empty( $instance['image_uri'] ) ) {
					$image_in_customizer = esc_url( $instance['image_in_customizer'] );
					$display             = 'inline-block';
				} else {
					if ( ! empty( $instance['image_uri'] ) ) {
						$image_in_customizer = esc_url( $instance['image_uri'] );
						$display             = 'inline-block';
					}
				}
				$belise_image_in_customizer = $this->get_field_name( 'image_in_customizer' );
				?>
				<input type="hidden" class="custom_media_display_in_customizer"
					name="
					<?php
					if ( ! empty( $belise_image_in_customizer ) ) {
						echo esc_html( $belise_image_in_customizer );
					}
?>
"
					value="
					<?php
					if ( ! empty( $instance['image_in_customizer'] ) ) :
						echo esc_attr( $instance['image_in_customizer'] );
endif;
?>
">
				<img class="custom_media_image" src="<?php echo esc_url( $image_in_customizer ); ?>"
					style="margin:0;padding:0;max-width:100px;float:left;display:<?php echo esc_attr( $display ); ?>"
					alt="<?php echo esc_html__( 'Uploaded image', 'belise-lite' ); ?>"/><br/>

				<input type="text" class="widefat custom_media_url"
					name="<?php echo esc_attr( $this->get_field_name( 'image_uri' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'image_uri' ) ); ?>"
					value="
					<?php
					if ( ! empty( $instance['image_uri'] ) ) :
						echo esc_url( $instance['image_uri'] );
endif;
?>
"
						style="margin-top:5px;">

				<input type="button" class="button button-primary custom_media_button" id="custom_media_button"
					name="<?php echo esc_attr( $this->get_field_name( 'image_uri' ) ); ?>"
					value="<?php esc_attr_e( 'Upload Image', 'belise-lite' ); ?>" style="margin-top:5px;">
			</p>

			<input class="custom_media_id" id="<?php echo esc_attr( $this->get_field_id( 'custom_media_id' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'custom_media_id' ) ); ?>" type="hidden"
				value="
					<?php
					if ( ! empty( $instance['custom_media_id'] ) ) :
						echo esc_attr( $instance['custom_media_id'] );
endif;
?>
"/>

			<?php
		}

		/**
		 * Register ribbon strings for pll
		 *
		 * @since 1.1.0
		 * @access public
		 */
		function belise_ribbon_register( $instance, $name ) {
			if ( empty( $instance ) || ! function_exists( 'pll_register_string' ) ) {
				return;
			}
			foreach ( $instance as $field_name => $field_value ) {
				$f_n = function_exists( 'ucfirst' ) ? esc_html( ucfirst( $field_name ) ) : esc_html( $field_name );
				pll_register_string( $f_n, $field_value, $name );
			}
		}
	}
}// End if().
