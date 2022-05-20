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
	<template id="job-item-template">
		<div class="maddie-col-6 job-item maddie-post-item" data-post-id="">
			<div class="job-item-wrapper">
				<a class="job-item-title" data-link="" href=""></a>
				<span class="job-item-team"></span>
				<span class="job-item-date"><small></small></span>
			</div>
		</div>
	</template>

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

					<form class="job_filter_form" method="get" data-empty="<?php _e('No Jobs', 'maddie'); ?>">
						<label for="keyword">Keyword: </label><br>
						<input type="text" id="keyword" name="keyword" value="">
						<div class="team_checklist mt_1x">
							<h3>Teams:</h3>
							<?php maddie_get_terms_checklist('tax_job_team'); ?>
						</div>
					</form> 

					<div class="jobs-viewed">
						<h2>Recently viewed positions:</h2>
						<div class="jobs-viewed-wrapper">

						</div>
					</div>
				</div>
				<div class="maddie-col-8">
					<div class="page-content maddie-row" id="jobs_container">
						<?php
							$jobs_list = array();

							while ( have_posts() ) {
								the_post();
								get_template_part( 'loop-templates/content', 'job');

								$post_id = get_the_ID();
								$post_title = get_the_title();
								$post_id = get_the_ID();

								$team_obj_list = get_the_terms( $post->ID, 'tax_job_team' );
								$teams_name    = join(', ', wp_list_pluck($team_obj_list, 'name'));
								$teams_id      = join(', ', wp_list_pluck($team_obj_list, 'term_id'));

								$jobs_list[] = array(
									'jobId'        => $post_id,
									'jobLink'      => get_the_permalink(),
									'jobTitle'     => $post_title,
									'jobTeamsName' => $teams_name,
									'jobTeamsId'   => $teams_id,
									'jobDate'      => get_the_date('F m, Y'),
								);
							} 
						?>
					</div>
					<div class="save_jobs_data" data-jobs_list='<?php echo json_encode($jobs_list); ?>'></div>
				</div>
			</div>
		</div>
	</div>
</main>
