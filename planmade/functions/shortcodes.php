<?php
/**
 * iFrame embed shortcode
 */

function iframe_shortcode( $atts = array(), $content = null, $tag = '' ) {

  return "<iframe src='{$atts['src']}' frameborder='0' width='600' height='auto' style='border:0;' allowfullscreen loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>";
}

add_shortcode('iframe', 'iframe_shortcode');