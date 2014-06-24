<?php
/**
 * Example for writing a WP plugin that adds a custom post type and flushes
 * rewrite rules only once on initialization.
 */

/**
 * On activation, we'll set an option called 'my_plugin_name_flush' to true,
 * so our plugin knows, on initialization, to flush the rewrite rules.
 */
function wpmm_cpt_activation() {
    add_option( 'wpmm_flush', 'true' );
}

register_activation_hook( WPMM_FILE, 'wpmm_cpt_activation' );

/**
 * On deactivation, we'll remove our 'my_plugin_name_flush' option if it is
 * still around. It shouldn't be after we register our post type.
 */
function wpmm_cpt_deactivation() {
    delete_option( 'wpmm_flush' );
}

register_deactivation_hook( WPMM_FILE , 'wpmm_cpt_deactivation' );

// Register the post type for locations
add_action( 'init', 'register_cpt_wpmm_location' );

function register_cpt_wpmm_location() {

	$labels = apply_filters('wpmm_location_post_type_labels', array(
		'name' => _x( 'Miembros', 'post type general name', 'wpmm-map-markers' ),
		'singular_name' => _x( 'Miembro', 'post type singular name', 'wpmm-map-markers' ),
		'add_new' => __( 'Agregar nuevo', 'wpmm-map-markers' ),
		'add_new_item' => __( 'Agregar nuevo miembro', 'wpmm-map-markers' ),
		'edit_item' => __( 'Editar miembro', 'wpmm-map-markers' ),
		'new_item' => __( 'Nuevo miembro', 'wpmm-map-markers' ),
		'view_item' => __( 'Ver miembro', 'wpmm-map-markers' ),
		'search_items' => __( 'Buscar miembros', 'wpmm-map-markers' ),
		'not_found' => __( 'No se han encontrado miembros', 'wpmm-map-markers' ),
		'not_found_in_trash' => __( 'No se han encontrado miembros en la basura', 'wpmm-map-markers' ),
		'parent_item_colon' => __( 'Miembros padre:', 'wpmm-map-markers' ),
		'menu_name' => __( 'Miembros', 'wpmm-map-markers' ),
	) );

	$args = apply_filters('wpmm_location_post_type_args', array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => __('Un miembro de ENA que pued ser geolozalizado','wpmm-map-markers'),
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => false,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array( 'slug' => 'miembro'),
		'capability_type' => 'post'
	));

	register_post_type( 'wpmm_location', $args );

	    // Check the option we set on activation.
    if (get_option('wpmm_flush') == 'true') {
        flush_rewrite_rules();
        delete_option('wpmm_flush');
    }
}

	