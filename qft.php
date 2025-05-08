<?php
/**
 * Plugin Name:       Quiz for Tags
 * Plugin URI:        
 * Description:       
 * Version:           1.0.0
 * Author:            
 */
 
/* enqueue the css/scripts/etc... */
add_action('wp_enqueue_scripts','qft_init_js_tug87e');
function qft_init_js_tug87e() {
    wp_enqueue_script( 'qft', plugins_url( '/qft.js', __FILE__ ), array('jquery'));
	wp_enqueue_style( 'qft', plugins_url( '/qft.css', __FILE__ ) );
}
function localize_my_script() {
	wp_localize_script('qft', 'qft_ajax_object', array(
		'ajaxurl' => admin_url('admin-ajax.php')
	));
}
add_action('wp_enqueue_scripts', 'localize_my_script');

/* the form by way of a shortcode */
function qft_init_tug87e( $atts) {
	$quiz = '';
	$quiz .= '<div class="qft-step qft-q-1">';
	$quiz .= '<p>Do you like Apples or Pears better?</p>';
	$quiz .= '<button value="apples" class="qft-answer">Apples</button> <button value="pears" class="qft-answer">Pears</button>';
	$quiz .= '</div>';
	
	$quiz .= '<div class="qft-step qft-q-2">';
	$quiz .= '<p>Do you like Bananas or Oranges better?</p>';
	$quiz .= '<button value="bananas" class="qft-answer">Bananas</button> <button value="oranges" class="qft-answer">Oranges</button>';
	$quiz .= '</div>';
	
	$form = '<div class="qft-step">';
	$form .= '<form method="post">';
	$form .= '<input type="hidden" id="qft-tags" name="qft-tags">';
	$form .= '';
	$form .= '<button type="submit" id="qft-search">QFT Search</button>';
	$form .= '</form>';
	$form .= '</div>';
	$form .= '<div id="qft-result"></div>';
	
	$output = $quiz.$form;
	return '<div id="qft">'.$output.'</div>';

}
add_shortcode( 'qft', 'qft_init_tug87e' );

/* the ajax seacrh */
function qft_ajax_search() {
	$data = $_POST['data'];
	$args = array(
		'posts_per_page' => -1,
		'tag' => $data,
	);
	$query = query_posts($args);
	$resp = '';
	foreach($query as $q){
		$resp .= '<div>';
		$resp .= '<p><a href="'.get_the_permalink($q->ID).'">'.$q->post_title.'</a></p>';
		$tags = get_the_tags($q->ID);
		$resp .= '<ul>';
		foreach($tags as $tag){
			$resp .= '<li>'.$tag->name.'</li>';
		}
		$resp .= '</ul>';
		$resp .= '</div>';
	}
	echo $resp;
	wp_die();
}
add_action('wp_ajax_qft_ajax_search', 'qft_ajax_search');
add_action('wp_ajax_nopriv_qft_ajax_search', 'qft_ajax_search');

?>