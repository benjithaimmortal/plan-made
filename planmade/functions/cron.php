<?php


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
  // if( ! wp_next_scheduled( 'action_name' )){
  //     // Schedule the event for right now, then to repeat every 15 minutes using the hook 'action_name'
  //     wp_schedule_event( time(), 'five_minutes', 'action_name' );
  // }
  // if( ! wp_next_scheduled( 'other_action_name' )){
  //     wp_schedule_event( time(), 'twenty_minutes', 'other_action_name' );
  // }
}

// // TURN THIS ON HERE
schedule_crons();



/**
 * Here's where we define the processes that the crons will fire
 */
add_action( 'global_entry', 'global_entry_checker' );

function global_entry_checker() {
  // code here

  $response = Global_Entry_Scraper::request($url);
  $response_decoded = $response['response_decoded'];
  if (!count($response_decoded)) return "No results";
  if (strtotime($response_decoded[0]['startTimestamp']) > strtotime("May 1, 2023")) return "Too late: " . $response_decoded[0]['startTimestamp'];

  $body = "Available appointment times: (Before May 1)";
  foreach ($response_decoded as $slot){
    if (strtotime($slot['startTimestamp']) > strtotime("May 1, 2023")) break;
    $body .= "\n{$slot['startTimestamp']}";
  }

  // $body = json_encode($body, JSON_PRETTY_PRINT);
  $to = 'benjamin.kostenbader@gmail.com';
  $title = 'Appointments available in Pittsburgh';
  $body = strlen($body > 1000) ? substr($body, 0, 1000) . "..." : $body;
  $response = slackbot("Hey @benjamin.kostenbader, schedule an appointment at https://ttp.cbp.dhs.gov/\nRequest: $url\nResponse:```$body```");
  return '<pre>' . json_encode(array($response_decoded, $body), JSON_PRETTY_PRINT) . '</pre>';
  // wp_mail($to, $title, $body, 'Content-Type: text/html; charset=UTF-8');
}
