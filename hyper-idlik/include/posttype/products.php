<?php
add_action('init','gt_products');
function gt_products(){   
    $labels = array(
		'name'               => __( 'محصولات', 'products', 'fa313' ),
		'singular_name'      => __( 'محصول', 'product', 'fa313' ),
		'menu_name'          => __( 'محصولات', 'admin menu', 'fa313' ),
		'name_admin_bar'     => __( 'محصول', 'add new on admin bar', 'fa313' ),
		'add_new'            => __( 'اضافه کردن', 'products', 'fa313' ),
		'add_new_item'       => __( 'اضافه کرن محصول جدید', 'fa313' ),
		'new_item'           => __( 'محصول جدید', 'fa313' ),
		'edit_item'          => __( 'ویرایش محصول', 'fa313' ),
		'view_item'          => __( 'نمایش محصول', 'fa313' ),
		'all_items'          => __( 'تمام محصولات', 'fa313' ),
		'search_items'       => __( 'جستجوی محصول', 'fa313' ),
		'parent_item_colon'  => __( 'محصول والد:', 'fa313' ),
		'not_found'          => __( 'محصولی یافت شند', 'fa313' ),
		'not_found_in_trash' => __( 'محصولی در زباله دادن یافت نشد', 'fa313' )
	);
    	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		//'query_var'          => true,
		'rewrite'            => array( 'slug' => 'products','with_front'=>true),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-cart',
		'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'         => array('tax_glob')
	);    
    register_post_type( 'products', $args );
}
?>