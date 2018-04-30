<!--  featured page -->
<?php
global $post;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$ancestors = array();
$ancestors = get_ancestors($post->ID,'page');
$parent = (!empty($ancestors)) ? array_pop($ancestors) : $post->ID;
$args = array(
	'post_type' => 'page',
	'order'=>'ASC',
    'orderby'=>'title',
    'post_parent' => get_the_ID(),
    'paged' => $paged
);
$query = new WP_Query($args);

if ( $query->have_posts() ):
?>
<section class="section section-featured-pages padding">


	<div class="grid-container box-container">
		<div class="container">
	    
	    <?php

	    if (!is_front_page()){
            if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb('<p id="breadcrumbs">','</p>');
            
            }
	    }
	    ?>
			<div class="row">

				<?php 
				while ( $query->have_posts() ) : 
					$query->the_post();
					?>
					<div class="col-sm-6 col-md-4 col-lg-4">
    					<div class="grid grid-guide">
    					    <div class="title">
    					        <a href="<?php echo get_permalink(); ?>">
        					    	<h2 class="autoheight-2"><?php echo get_the_title(); ?></h2>
        					    </a>
        			            <div class="line"><div class="inner"></div></div>
    			            </div>
    			            <div class="image">
    			                <a href="<?php echo get_permalink(); ?>">
        			                <?php
        			                $post_id = icl_object_id( get_the_ID() , 'post', true, DEFAULT_LANGUAGE);
            			            if ( has_post_thumbnail($post_id) ):
                        			    echo get_the_post_thumbnail($post_id, 'full', ['class' => 'img-responsive', 'title' => get_the_title(), 'alt' => get_the_title() ]);
                        			endif;
                    			?>
                    			</a>
    			            </div>
    			            <div class="content box">
    			                <?php the_excerpt(); ?>
    			            </div>
    			            <div class="action">
    			                <a href="<?php echo get_permalink(); ?>" class="read-more"><?php echo __('Learn more','happistar'); ?></a>
    			            </div>
    			            <div class="clear"></div>
    					</div>
					</div>
					<?php
				endwhile; 
				?>

			</div>
		</div>
	</div>

	<div class="grid-pagination-cointainer">
		<?php
		if ( get_option('permalink_structure') ) {
	        $format = 'page/%#%';
	    } else {
	        $format = '&paged=%#%';
	    }
	    $args = array(
	        'base' => get_permalink( $post->post_parent ) . '%_%',
	        'format' => $format,
	        'current' => $paged,
	        'total' => $query->max_num_pages
	    );
	    echo '<ul class="pagination">';
	    echo paginate_links( $args );
	    echo '</ul>';
	    ?>
	</div>


</section>
<?php wp_reset_postdata(); ?>
<?php endif; ?>
<!--  .featured page -->
