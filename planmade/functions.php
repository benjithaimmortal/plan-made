<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage hooks
 * @since Twenty Twenty-One 1.0
 */

require_once(__DIR__ . '/functions/admin.php');
require_once(__DIR__ . '/functions/enqueues.php');
require_once(__DIR__ . '/functions/shortcodes.php');

/**
 * This is how we set new schedule times
 */
add_filter( 'cron_schedules', 'cron_five_minutes' );
add_filter( 'cron_schedules', 'cron_one_minute' );

function cron_five_minutes( $schedules ) {
   // Adds once weekly to the existing schedules.
   $schedules['five_minutes'] = array(
       'interval' => 300,
       'display' => __( 'Once Every Five Minutes' )
   );
   return $schedules;
}
function cron_one_minute( $schedules ) {
   // Adds once weekly to the existing schedules.
   $schedules['one_minute'] = array(
       'interval' => 60,
       'display' => __( 'Once Every Minute' )
   );
   return $schedules;
}



/**
 * This is how to actually schedule the cron job.
 * 
 * Note that we're calling this as a function, 
 * but if it's in a plugin it'll need to be inside this hook:
 * register_activation_hook(__FILE__, 'my_hookname') {}
 */
function schedule_crons(){
  if( ! wp_next_scheduled( 'action_name' )){
      // Schedule the event for right now, then to repeat every 15 minutes using the hook 'action_name'
      wp_schedule_event( time(), 'five_minutes', 'action_name' );
  }
  // if( ! wp_next_scheduled( 'other_action_name' )){
  //     wp_schedule_event( time(), 'twenty_minutes', 'other_action_name' );
  // }
}

// // TURN THIS ON HERE
schedule_crons();



/**
 * Here's where we define the processes that the crons will fire
 */
add_action( 'action_name', 'custom_cache' );

function custom_cache() {
  // code here

  $response = Global_Entry_Scraper::request($url);
  $response_decoded = $response['response_decoded'];
  if (!count($response_decoded)) return;

  $to = 'benjamin.kostenbader@gmail.com';
  $title = 'Appointments available in Pittsburgh';
  $body = $response['response'];
  wp_mail($to, $title, $body, 'Content-Type: text/html; charset=UTF-8');
}




class Global_Entry_Scraper {
	private $params;
	private $http_header;
	// private $endpoint;
	public  $response;

	// make the cURL request
	public static function request($url = null) {
    $api_baseurl = $url ?: "https://ttp.cbp.dhs.gov/schedulerapi/slots?orderBy=soonest&limit=100&locationId=9200&minimum=1";

		// Init cURL session
		$ch = curl_init($api_baseurl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // // Part 1: want to see the header? (this breaks JSON-only response)
    // curl_setopt($ch, CURLOPT_HEADER, 1);

    // // Part 1: want to see the HTTP request? (this is separate from $response)
    // curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($ch);

    // // Part 2: want to see the header? (this breaks JSON-only response)
    // $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    // $header = substr($response, 0, $header_size);
    // $body = substr($response, $header_size);
    
    // // Part 2: want to see the HTTP request? (this is separate from $response)
    // $info = curl_getinfo($ch);

    curl_close($ch);

		return array(
      'timestamp' => time(),
      'response_decoded' => json_decode($response, true),
      'response' => $response,
    );
	}
}
