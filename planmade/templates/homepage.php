<?php
/**
* Template Name: Home Page
*/

wp_body_open(); ?>
<div class="wp-site-blocks">
  
  <?php 
  // echo Global_Entry_Scraper::request()['response'];
  // echo json_encode(count(Global_Entry_Scraper::request()['response_decoded']), JSON_PRETTY_PRINT);
  the_content();?>

</div>
<?php wp_footer(); ?>