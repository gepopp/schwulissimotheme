<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package schwulissimp
 */

get_header(); ?>

<div class="row">
    <div class="col-md-8">
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
                    global $wp_query;
		if ( have_posts() ) : ?>
			<header class="page-header">
				<h1 class="page-title"><?php echo $wp_query->found_posts . ' '; printf( esc_html__( 'Ergebnisse f&uuml;r: %s', 'schwulissimo' ),  '<span>' . get_search_query() . '</span>' ); ?></h1>
                                <?php echo paginate_links()?>

                        </header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

                        
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->
    </div>
    <div class="col-sm-4 hidden-xs">
        <?php get_sidebar(); ?>
    </div>
</div>

<?php

get_footer();
