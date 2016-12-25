<?php

/**

 * The template used for displaying page content in page.php

 *

 * @package zerif

 */

?>



<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<span class="date updated published"><?php the_time( get_option('date_format') ); ?></span>
		<span class="vcard author byline"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="fn"><?php the_author(); ?></a></span>
	
		<?php zerif_page_header_trigger(); ?>
		
	</header><!-- .entry-header -->

	<?php

	$zerif_add_thumbnail_pages = get_theme_mod( 'zerif_add_thumbnail_pages' );

	if( isset($zerif_add_thumbnail_pages) && $zerif_add_thumbnail_pages == 1  && has_post_thumbnail() ) {

		the_post_thumbnail('full');
	}

	?>

	<div class="entry-content" itemprop="text">

		<?php the_content(); ?>

		<?php

			wp_link_pages( array(

				'before' => '<div class="page-links">' . __( 'Pages:', 'zerif' ),

				'after'  => '</div>',

			) );

		?>

	</div><!-- .entry-content -->

	<?php edit_post_link( __( 'Edit', 'zerif' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>

</article><!-- #post-## -->