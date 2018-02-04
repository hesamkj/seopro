<?php
add_action('init', 'product_type_f', 0);
function product_type_f() {
  $labels = array(
	'name'                       => _x( 'نوع محصول', 'glob', 'idlik-hyper' ),
    'singular_name'              => _x( 'نوع محصول', 'glob', 'idlik-hyper' ),
    'menu_name'                  => __( 'نوع محصول', 'idlik-hyper' ),
    'all_items'                  => __( 'همه موارد', 'idlik-hyper' ),
    'parent_item'                => __( 'مورد والد', 'idlik-hyper' ),
    'parent_item_colon'          => __( 'مورد والد', 'idlik-hyper' ),
    'new_item_name'              => __( 'نام مورد جدید', 'idlik-hyper' ),
    'add_new_item'               => __( 'اضافه کردن مورد جدید', 'idlik-hyper' ),
    'edit_item'                  => __( 'ویرایش مورد', 'idlik-hyper' ),
    'update_item'                => __( 'ویرایش مورد', 'idlik-hyper' ),
    'view_item'                  => __( 'نمایش مورد', 'idlik-hyper' ),
    'separate_items_with_commas' => __( 'جدا کردن موارد با کاما', 'idlik-hyper' ),
    'add_or_remove_items'        => __( 'اضافه یا حذف مورد', 'idlik-hyper' ),
    'choose_from_most_used'      => __( 'انتخاب مورد به عنوان محبوب ترین', 'idlik-hyper' ),
    'popular_items'              => __( 'موارد محبوب', 'idlik-hyper' ),
    'search_items'               => __( 'جستجوی موارد', 'idlik-hyper' ),
    'not_found'                  => __( 'موردی یافت نشد', 'idlik-hyper' ),
    'no_terms'                   => __( 'موردی یافت نشد', 'idlik-hyper' ),
    'items_list'                 => __( 'لیست موارد', 'idlik-hyper' ),
    'items_list_navigation'      => __( 'لیست موارد', 'idlik-hyper' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'product_type', array( 'products' ), $args );
}
?>