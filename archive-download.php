<?php

/**

 * The template for displaying Archive pages.

 *

 * Learn more: http://codex.wordpress.org/Template_Hierarchy

 *

 * @package zerif

 */

get_header(); 
?>

	<div class="clear"></div>
</header> <!-- / END HOME SECTION  -->
<?php zerif_after_header_trigger(); ?>
<div id="content" class="site-content">
	<div class="container">
		<?php zerif_before_archive_content_trigger(); ?>
		<div class="content-left-wrap col-md-12">
			<?php zerif_top_archive_content_trigger(); ?>
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
				<?php if ( have_posts() ) : ?>
					<header class="page-header">
						<?php
						/* Title */
						zerif_page_header_title_archive_trigger();

						/* Optional term description */
						zerif_page_term_description_archive_trigger();
						?>
					</header><!-- .page-header -->
					<?php 
						while ( have_posts() ) : 
							the_post();
							get_template_part( 'content', 'archive-download' );
						endwhile;
						zerif_paging_nav(); 
					else:
						get_template_part( 'content', 'none' ); 
					endif;
					?>
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php zerif_bottom_archive_content_trigger(); ?>
		</div><!-- .content-left-wrap -->
		<?php zerif_after_archive_content_trigger(); ?>
	</div><!-- .container -->
</div><!-- .site-content -->
<?php get_footer(); ?>