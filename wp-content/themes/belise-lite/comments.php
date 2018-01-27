<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<div class="container">
		<?php

		if ( have_comments() ) :
		?>
			<div class="comments-title clearfix">
				<h3 class="pull-left">
					<?php
						$comments_number = get_comments_number();
					if ( '1' === $comments_number ) {
						/* translators: %s: number of comments */
						printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'belise-lite' ), get_the_title() );
					} else {
						/* translators: %s: number of comments */
						printf( esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments_number, 'comments title', 'belise-lite' ) ), number_format_i18n( $comments_number ), '<span>' . get_the_title() . '</span>' );
					}
					?>
				</h3>
				<span id="leave-a-reply" class="pull-right"><?php echo esc_html__( 'Leave A Reply', 'belise-lite' ); ?></span>
			</div>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through?
			?>
				<nav id="comment-nav-above" class="navigation comment-navigation">
					<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'belise-lite' ); ?></h2>
					<div class="nav-links">

						<div
							class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'belise-lite' ) ); ?></div>
						<div
							class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'belise-lite' ) ); ?></div>

					</div><!-- .nav-links -->
				</nav><!-- #comment-nav-above -->
			<?php
			endif; // Check for comment navigation.
			?>

			<ol class="comment-list">
				<?php
				wp_list_comments(
					array(
						'style'       => 'ol',
						'avatar_size' => 145,
						'short_ping'  => true,
						'max_depth'   => '',
						'callback'    => 'belise_comment',
					)
				);
				?>
			</ol><!-- .comment-list -->

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through?
			?>
				<nav id="comment-nav-below" class="navigation comment-navigation">
					<h2 class="screen-reader-text"><?php echo esc_html__( 'Comment navigation', 'belise-lite' ); ?></h2>
					<div class="nav-links">

						<div
							class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'belise-lite' ) ); ?></div>
						<div
							class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'belise-lite' ) ); ?></div>

					</div><!-- .nav-links -->
				</nav><!-- #comment-nav-below -->
				<?php
			endif; // Check for comment navigation.

		endif; // Check for have_comments().


		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>

			<p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'belise-lite' ); ?></p>
			<?php
		endif;

		comment_form( belise_comments_template() );

		?>
	</div>
</div><!-- #comments -->
