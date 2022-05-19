<?php
/**
 * The template for displaying archive pages.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<main id="content" class="archive-job-content px_2x" role="main">
	<div class="maddie_container">
		<div class="archive-job-wrapper">
			<div class="maddie-row">
				<div class="maddie-col-4">
					<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="entry-title">', '</h1>' );
							the_archive_description( '<p class="archive-description">', '</p>' );
							?>
						</header>
					<?php endif; ?>

					<form class="news_filter_form" action="<?php echo esc_url( get_the_permalink() ); ?>" method="get">
						<label for="keyword">Keyword: </label><br>
						<input type="text" id="keyword" name="keyword" value="">

						<div class="team_checklist mt_1x">
							<h3>Teams:</h3>
							<?php maddie_get_terms_checklist('tax_job_team'); ?>
						</div>
				
					</form> 
				</div>
				<div class="maddie-col-8">
					<div class="page-content maddie-row">
						<?php
							while ( have_posts() ) {
								the_post();
								get_template_part( 'loop-templates/content', 'job');
							} 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
