<?php

class Add_post_types {

  var $single; //this represents the singular name of the post type
  var $plural; //this represents the plural name of the post type
  var $type; //this is the actual type

  function init($options){
    foreach($options as $key => $value){
      $this->$key = $value;
    }
  }

  function add_post_type(){
    $labels = array(
      'name' => _x($this->plural, 'post type general name'),
      'singular_name' => _x($this->single, 'post type singular name'),
      'add_new' => _x('Add ' . $this->single, $this->single),
      'add_new_item' => __('Add New ' . $this->single),
      'edit_item' => __('Edit ' . $this->single),
      'new_item' => __('New ' . $this->single),
      'view_item' => __('View ' . $this->single),
      'search_items' => __('Search ' . $this->plural),
      'not_found' =>  __('No ' . $this->plural . ' Found'),
      'not_found_in_trash' => __('No ' . $this->plural . ' found in Trash'),
      'parent_item_colon' => ''
    );
    $options = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'hierarchical' => false,
      'menu_position' => null,
      'supports' => array('title','editor','author','thumbnail','excerpt','comments')
      );
    register_post_type($this->type, $options);
  }

  function add_messages ( $messages ) {

    $messages[$this->type] = array(
    0 => '', 
    1 => sprintf( __($this->single . ' updated. <a href="%s">View ' . $this->single . '</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __($this->single . ' updated.'),
    5 => isset($_GET['revision']) ? sprintf( __($this->single .' restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __($this->single . ' published. <a href="%s">View ' . $this->single . '</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Book saved.'),
    8 => sprintf( __($this->single . ' submitted. <a target="_blank" href="%s">Preview ' . $this->single . '</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __($this->single . ' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview ' . $this->single . '</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __($this->single . ' draft updated. <a target="_blank" href="%s">Preview ' . $this->single . '</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
  }

}

