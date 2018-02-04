<?php
add_action('init','gt_news');
function gt_news(){

    $labels = array(
        'name'               => _x( 'اخبار', 'news', 'mojtabaramezani' ),
        'singular_name'      => _x( 'اخبار', 'news', 'mojtabaramezani' ),
        'menu_name'          => _x( 'اخبار', 'admin menu', 'mojtabaramezani' ),
        'name_admin_bar'     => _x( 'خبر جدید', 'add new on admin bar', 'mojtabaramezani' ),
        'add_new'            => _x( 'اضافه کردن', 'news', 'mojtabaramezani' ),
        'add_new_item'       => __( 'اضافه کردن مورد جدید', 'mojtabaramezani' ),
        'new_item'           => __( 'مورد جدید', 'mojtabaramezani' ),
        'edit_item'          => __( 'ویرایش مورد', 'mojtabaramezani' ),
        'view_item'          => __( 'نمایش مورد', 'mojtabaramezani' ),
        'all_items'          => __( 'تمام موارد', 'mojtabaramezani' ),
        'search_items'       => __( 'جستجوی موارد', 'mojtabaramezani' ),
        'parent_item_colon'  => __( 'مورد والد', 'mojtabaramezani' ),
        'not_found'          => __( 'موردی یافت نشد', 'mojtabaramezani' ),
        'not_found_in_trash' => __( 'موردی در زباله دان یافت نشد', 'mojtabaramezani' )
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        //'query_var'          => true,
        'rewrite'            => array( 'slug' => 'news','with_front'=>true),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
		    'menu_icon'          => 'dashicons-megaphone' ,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'taxonomies'         =>array( 'post_tag' ,'month')
    );
    register_post_type( 'news', $args );
}
?>