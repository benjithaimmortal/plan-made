<?php
/**
* Template Name: Codin Page
*/

wp_body_open(); ?>
<div class="wp-site-blocks">
  
  <?php 
  echo '<pre>'; 
  echo Global_Entry_Scraper::request()['response'] . "<br>";
  echo json_encode(count(Global_Entry_Scraper::request()['response_decoded']), JSON_PRETTY_PRINT);
  echo '</pre>';

  slackbot('Benji');
  the_content();?>

</div>
<?php wp_footer(); ?>