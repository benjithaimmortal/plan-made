<?php
/**
* Template Name: Codin Page
*/

wp_body_open(); ?>
<div class="wp-site-blocks">
  
  <?php 
  echo '<pre>'; 
  // echo substr(Global_Entry_Scraper::request()['response'], 0, 2990) . "<br>";
  echo global_entry_checker() . "<br>";
  echo "Total count (max 100): " . json_encode(count(Global_Entry_Scraper::request()['response_decoded']), JSON_PRETTY_PRINT) . "<br>";
  // echo json_encode(get_post_meta(get_the_id(), 'debug', true), JSON_PRETTY_PRINT);
  echo '</pre>';

  the_content();?>

</div>
<?php wp_footer(); ?>