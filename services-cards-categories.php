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
?>
<?php function show_cards_categories() { ?>
		<ul class="services-cards-container" id="cardContainer">
			<?php 
				$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
				$categories = new WP_Query(array(
					'post_type'  => 'get_categories_info',
					'posts_per_page' => 4,
					//'orderby'    => 'rand',
					'orderby'      => 'DESC',
					'paged' => $paged,
					
				));
				while($categories->have_posts()){
					  $categories->the_post();
				?>
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
							  		<h1><?php the_title(); ?></h1>  
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
				<?php 
			} 
			wp_reset_postdata();?>
		</ul>
		<div class="pagitanition-custom-services-cards">
		<?php 
		   		$totalpages = $categories -> max_num_pages;
				echo paginate_links(array(
						'total'    => $totalpages,
						'current'  => $paged,
						'show_all' => true,
				));	
		?>
		</div>
<?php	wp_enqueue_script( 'Open_Close_Card', plugin_dir_url( __FILE__ )  . '/js/open-close.js', array(), '1.0.0', true );
	}	
add_shortcode( 'add-categories-cards', 'show_cards_categories');
