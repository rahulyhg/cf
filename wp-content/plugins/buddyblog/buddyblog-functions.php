<?php


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * are we inside the buddyblog component on users profile
 * @return type 
 */
function bp_is_buddyblog_component() {
        
   return bp_is_current_component( 'buddyblog' ) ;
	    
}
/**
 * Get allowd post type for BuddyBlog
 * 
 * @return type
 */
function buddyblog_get_posttype() {
	$post_type = buddyblog_get_option( 'post_type' );
	
	if ( ! $post_type ) {
		$post_type = 'post';
	}
	
    return apply_filters( 'buddyblog_get_post_type', $post_type );
	
}
/**
 * Get allowed taxonomies
 * 
 * @return type
 */
function buddyblog_get_taxonomies() {
	
    return apply_filters( 'buddyblog_get_taxonomies', buddyblog_get_option( 'allowed_taxonomies' ) );
}


/**
 * Get total no. of Posts  posted by a user
 * @global type $wpdb
 * @param type $user_id
 * @return int 
 * @todo : may need revisist
 */

function buddyblog_get_total_posted( $user_id = false ) {
	
    if ( ! $user_id ) {
        $user_id = bp_displayed_user_id ();
	}
	
    //Needs revisist
    global $wpdb;
    
	$count = $wpdb->get_var( $wpdb->prepare( "SELECT count('*') FROM {$wpdb->posts} WHERE post_author=%d AND post_type=%s AND (post_status='publish'||post_status='draft')", $user_id, buddyblog_get_posttype() ) );
    
    return intval( $count);
}
/**
 * Get total no. of published post for the user
 * @global type $wpdb
 * @param type $user_id
 * @return type 
 */
function buddyblog_get_total_published_posts( $user_id = false ) {
	
    if ( ! $user_id ) {
        $user_id = get_current_user_id ();
	}
    //Needs revisist
    global $wpdb;
   
     $count = $wpdb->get_var( $wpdb->prepare( "SELECT count('*') FROM {$wpdb->posts} WHERE  post_author=%d AND post_type=%s AND post_status='publish'", $user_id,  buddyblog_get_posttype() ) );

    return intval( $count);
}
/**
 * Get allowed no. of posts
 * Use this filter
 * @param type $user_id
 * @return type 
 */
function buddyblog_get_allowed_no_of_posts( $user_id = false ) {
	
    if ( ! $user_id ) {
        $user_id = bp_displayed_user_id ();
	}
    //filter on this hook to change the no. of posts allowed
    return apply_filters( 'buddyblog_allowed_posts_count', buddyblog_get_option( 'max_allowed_posts' ), $user_id );//by default no. posts allowed
}
/**
 * get remaining no. of posts to be activated
 * @param type $user_id
 * @return type 
 */
function buddyblog_get_remaining_posts( $user_id = false ) {
    
	$total_allowed = buddyblog_get_allowed_no_of_posts( $user_id );
	
    return intval( $total_allowed - buddyblog_get_total_published_posts( $user_id ) );
}

/**
 * Are we viewing the single post listing on user profile?
 * @return type 
 */
function buddyblog_is_single_post() {
	
    $action = bp_current_action();
    $post_id = 0; 
    //make sure 
    //check the strategy
    if ( buddyblog_use_slug_in_permalink() ) {
		$slug = bp_action_variable( 0 );
        $post_id = buddyblog_get_post_id_from_slug( $slug );
     } else {   
		$post_id = intval( bp_action_variable(0) );
	}
	
    if ( bp_is_buddyblog_component() && $action == BUDDYBLOG_ARCHIVE_SLUG && ! empty( $post_id ) ) {
        return true;
	}
    
    return false;
}
/**
 * Is it posts archive for user?
 * @return type 
 */
function buddyblog_is_posts_archive() {
	
    $action = bp_current_action();
    $post_id = bp_action_variable( 0 );
	
    if ( bp_is_buddyblog_component() && $action == BUDDYBLOG_ARCHIVE_SLUG && empty( $post_id ) ) {
        return true;
	}
    
	return false;
}
/**
 * Is it Post edit page ?
 * @return type 
 */
function buddyblog_is_edit_post() {
	
    $action = bp_current_action();
    $post_id = bp_action_variable( 0 );
    
	if ( bp_is_buddyblog_component() && $action == 'edit' && ! empty( $post_id ) ) {
        return true;
	}
	
    return false;
}
/**
 * Is it new Post page
 * @return type 
 */
function buddyblog_is_new_post() {
	
    $action = bp_current_action();
    $post_id = bp_action_variable( 0 );
	
    if ( bp_is_buddyblog_component() && $action == 'edit' && empty( $post_id ) ) {
        return true;
	}
	
    return false;
}


/**
 * Has user posted
 * @return type 
 */

function buddyblog_user_has_posted() {
	
    $total_posts = buddyblog_get_total_posted();
    
    return (bool) $total_posts;
}
/**
 * Get the url of the BuddyBlog component for the given user
 * 
 * @global type $bp
 * @param type $user_id
 * @return string 
 */
function buddyblog_get_home_url( $user_id = false ) {
	
    if ( ! $user_id ) {
        $user_id = get_current_user_id ();
	}
    
    $url = bp_core_get_user_domain( $user_id ) . buddypress()->buddyblog->slug . '/';
	
    return $url;
}

/**
 * Get the url for publishing/unpublishing the post
 * @param type $post_id
 * @return string 
 */  
function buddyblog_get_post_publish_unpublish_url( $post_id = false ) {
	
	if ( ! $post_id ) {
		return;
	}
   
	$post = get_post( $post_id );
	$url = '';
	
	if ( buddyblog_user_can_publish( get_current_user_id(), $post_id ) ) {
       //check if post is published
		$url = buddyblog_get_home_url( $post->post_author );
	  
		if ( buddyblog_is_post_published( $post_id ) ) {
			$url = $url . 'unpublish/' . $post_id . '/';
		} else {
			$url = $url . 'publish/' . $post_id . '/';
		}
   }
   
   return $url;
   
}
/**
 * retusn a link that allows to publish/unpublish the post
 * @param type $post_id
 * @param type $label_ac
 * @param type $label_de
 * @return type 
 */  
function buddyblog_get_post_publish_unpublish_link( $post_id = false, $label_ac = 'Publish', $label_de = 'Unpublish' ) {
	
	if ( ! $post_id ) {
		return;
	}
	
	if ( ! buddyblog_user_can_publish( get_current_user_id(), $post_id ) ) {
	   return ;
	}
	
	$post = get_post( $post_id );
	
	$url = '';
	
	if ( ! ( is_super_admin() || $post->post_author == get_current_user_id() ) ) {
           return;
	}
        
       //check if post is published
    $url = buddyblog_get_post_publish_unpublish_url( $post_id );
	
    if ( buddyblog_is_post_published( $post_id ) ) {
		$link = "<a href='{$url}'>{$label_de}</a>";
	} else {
		$link = "<a href='{$url}'>{$label_ac}</a>";
	}
	
	return $link;
   
}
/**
 * Is this post published?
 * @param type $post_id
 * @return bool 
 */
function buddyblog_is_post_published( $post_id ) {
	
    return get_post_field( 'post_status', $post_id ) == 'publish';
}

function buddyblog_use_slug_in_permalink() {
    
    return apply_filters( 'buddyblog_use_slug_in_permalink', false );//whether to use id or slug in permalink
}
/**
 * Get the id of the post via 
 * @param type $slug
 * @return int ID of Post
 */
function buddyblog_get_post_id_from_slug( $slug ) {
	
    if ( ! $slug ) {
        return 0;
	}
    
    $post = get_page_by_path( $slug, false, buddyblog_get_posttype() );
    
    if ( $post ) {
        return $post->ID;
	}
	
    return 0;
    
}
/**
 * Get the id of the post  
 * @param type $slug  or ID
 * @return int ID of Post
 */
function buddyblog_get_post_id( $slug_or_id ) {
    
    if ( is_numeric( $slug_or_id ) ) {
		return absint( $slug_or_id );
	}
    //otherwise
    return buddyblog_get_post_id_from_slug( $slug_or_id );
}

function buddyblog_get_option( $option_name ) {
	
	$settings = buddyblog_get_settings();

	if ( isset( $settings[ $option_name ] ) ) {
		return $settings[ $option_name ];
	}
	
	return '';
	
}
/**
 * Was this post posted by buddyblog
 * 
 * @param int $post_id
 * @return boolean
 */
function buddyblog_is_buddyblog_post( $post_id ) {
	
	return get_post_meta( $post_id, '_is_buddyblog_post', true );
}
/**
 * Get BuddyBlog Settings
 * 
 * @return type
 */
function buddyblog_get_settings() {
    
    $default = array(
		//'root_slug'			=> 'buddyblog',
        'post_type'				=> 'post',
		'post_status'			=> 'publish',
		'comment_status'		=> 'open',
		'show_comment_option'	=> 1,
		'custom_field_title'	=> '',
		'enable_taxonomy'		=> 1,
		'allowed_taxonomies'	=> '',
		'enable_category'		=> 1,
		'enable_tags'			=> 1,
		'show_posts_on_profile' => 0,
		'limit_no_of_posts'		=> 0,
		'max_allowed_posts'		=> 20,
		'publish_cap'			=> 'read',
		'allow_unpublishing'	=> 1,//subscriber //see https://codex.wordpress.org/Roles_and_Capabilities
		'post_cap'				=> 'read',
		'allow_edit'			=> 1,
		'allow_delete'			=> 1,
		'allow_upload'			=> 1,
		//'enabled_tags'			=> 1,
        //'taxonomies'		=> array( 'category' ),
        'allow_upload'		=> false,
        'max_upload_count'	=> 2,
		'post_update_redirect'	=> 'archive'
        );
    
    return bp_get_option( 'buddyblog-settings', $default );
}
