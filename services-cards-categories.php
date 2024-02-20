<?php 
/*
    Plugin Name: HSG services Cards Categories
    Plugin URI:
    Description: Show information about categories, phone numbers and blogs links.
    Version: 1.1.0
    Autor: Nicolas Castro
    Text Domain: HSGPRO categories
*/
if(!defined('ABSPATH')) die();
// Registra CSS
function categories_services_card_styles(){
    wp_enqueue_style('categories_services_card_styles', plugins_url('services-card-categories.css',__FILE__));
}
add_action('wp_enqueue_scripts','categories_services_card_styles');
// Registrar Custom Post Type
function services_card_categories_post_types() {
	$labels = array(
		'name'                  => _x( 'Categories', 'Post Type General Name', 'HSGPRO' ),
		'singular_name'         => _x( 'Categories services cards', 'Post Type Singular Name', 'HSGPRO' ),
		'menu_name'             => __( 'Services Category Cards', 'HSGPRO' ),
		'name_admin_bar'        => __( 'Clase', 'HSGPRO' ),
		'archives'              => __( 'Archives', 'HSGPRO' ),
		'attributes'            => __( 'Attributes', 'HSGPRO' ),
		'parent_item_colon'     => __( 'Parent item cATEGORY', 'HSGPRO' ),
		'all_items'             => __( 'All Categories', 'HSGPRO' ),
		'add_new_item'          => __( 'New Category card', 'HSGPRO' ),
		'add_new'               => __( 'Add Category', 'HSGPRO' ),
		'new_item'              => __( 'Add new category', 'HSGPRO' ),
		'edit_item'             => __( 'Edit Category', 'HSGPRO' ),
		'update_item'           => __( 'Update Category', 'HSGPRO' ),
		'view_item'             => __( 'View Category', 'HSGPRO' ),
		'view_items'            => __( 'View Categories', 'HSGPRO' ),
		'search_items'          => __( 'Search Categories', 'HSGPRO' ),
		'not_found'             => __( 'No Category Found', 'HSGPRO' ),
		'not_found_in_trash'    => __( 'Not Category found in trash', 'HSGPRO' ),
		'featured_image'        => __( 'Featured image', 'HSGPRO' ),
		'set_featured_image'    => __( 'Set featured Image', 'HSGPRO' ),
		'remove_featured_image' => __( 'Remove featured Image', 'HSGPRO' ),
		'use_featured_image'    => __( 'Use featured image', 'HSGPRO' ),
		'insert_into_item'      => __( 'Insert into Category', 'HSGPRO' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Category', 'HSGPRO' ),
		'items_list'            => __( 'Category List', 'HSGPRO' ),
		'items_list_navigation' => __( 'Category Navigation', 'HSGPRO' ),
		'filter_items_list'     => __( 'Category Filter', 'HSGPRO' ),
	);
	$args = array(
		'label'                 => __( 'Services Category Cards', 'HSGPRO' ),
		'description'           => __( 'Services Category Cards', 'HSGPRO' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => true, // true = posts , false = paginas
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-embed-photo',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'get_categories_info', $args );
}
add_action( 'init', 'services_card_categories_post_types', 0 );
if (!function_exists('ic_custom_posts_pagination')) :
    function ic_custom_posts_pagination($the_query=NULL, $paged=1){
        global $wp_query;
        $the_query = !empty($the_query) ? $the_query : $wp_query;
        if ($the_query->max_num_pages > 1) {
            $big = 999999999; // need an unlikely integer
            $items = paginate_links(apply_filters('adimans_posts_pagination_paginate_links', array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'prev_next' => TRUE,
                'current' => max(1, $paged),
                'total' => $the_query->max_num_pages,
                'type' => 'array',
                'prev_text' => ' <i class="fas fa-angle-double-left"></i> ',
                'next_text' => ' <i class="fas fa-angle-double-right"></i> ',
                'end_size' => 1,
                'mid_size' => 1
            )));

            $pagination = "<div class=\"col-sm-12 text-center\"><div class=\"ic-pagination\"><ul class='pagination-container'><li>";
            $pagination .= join("</li><li>", (array)$items);
            $pagination .= "</li></ul></div></div>";

            echo apply_filters('ic_posts_pagination', $pagination, $items, $the_query);
        }
    }
endif;



function show_cards_categories() {

$property_per_page = 3;
$paged = get_query_var('paged') ?? get_query_var('page') ?? 1;
$args = array(
  'post_type'        	=> 'get_categories_info',
  'posts_per_page'  	=> $property_per_page ? (int)$property_per_page : 12,
  'paged' 				=> $paged,
);
// the query
$property_query = new WP_Query( $args );
if ( $property_query->have_posts() ) : ?>

<div class="properties-wrapper">
  <ul class="row">
    <!-- the loop -->
    <?php while ( $property_query->have_posts() ) : $property_query->the_post(); ?>
				<li>
				<details class="scard-body">
  						<summary class="scard">
							<div class="scard-icon">
									<?php 
										if(has_post_thumbnail()):
												the_post_thumbnail(); 
										else:
									?> 	
											 <img src="<?php echo plugin_dir_url( __FILE__ ) . 'FavIcon.png';?>" alt="">
									 <?php endif;?>
							</div>
							<div class="scard-title">
							  		<h3><?php the_title(); ?></h3>  
							</div>
							<div class="scard-close-open" id="close">
							  <span><img class="scard-toggle-open" src="<?php echo plugin_dir_url( __FILE__ ) . 'expanded-services-card.svg';?>" alt=""></span>
							   <img class="scard-toggle-close" src="<?php echo plugin_dir_url( __FILE__ ) . 'close-icon.svg';?>" alt="" hidden>
						   </div>
						</summary>
  							<div class="scard-contenido">
								<?php the_content(); ?>
							</div>
							<div class="scard-btns">
									<a href="<?php the_field('link_category_page')?>">View Page</a> 
									<span>
										<a href="<?php the_field('link_category_blog')?>">View Blog</a>
									</span> 
									<p><a href="tel:<?php the_field('category_call_number')?>">Call to local Business</a></p>
							</div>
						</details>		
				</li>	
    <?php endwhile; ?>
    <!-- end of the loop -->
</ul>
  <!-- pagination here -->
  <div class="row">
    <div class="text-center">
      <?php ic_custom_posts_pagination($property_query, $paged); ?>
    </div>
  </div>
</div><!-- .properties-wrapper -->
  <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p class="text-warning"><?php esc_html_e( 'Sorry, no property matched your criteria.', 'ichelper' ); ?></p>
<?php endif; 
    
} 
add_shortcode('add-categories-cards', 'show_cards_categories');
wp_enqueue_script('Open_Close_Card', plugin_dir_url(__FILE__) . '/js/open-close.js', array(), '1.0.0', true);
wp_enqueue_script('ajax', plugin_dir_url(__FILE__) . '/js/wp_ajax_load_more_categories.js', array('jquery'), '1.0.0', true);
