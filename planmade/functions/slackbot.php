<?php
function slackbot($message, $title = null) {
  $slack_api_secrets = "T0862LY9J/B04D68VCBDL/rIYSzLDCtGRTAcN4oUc9hnQ2";
  $slack_url = "https://hooks.slack.com/services/$slack_api_secrets";
  $ch = curl_init($slack_url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "response_type" => "in_channel",
    "text" => $title ?: "Slackbot from " . get_site_url(),
    "blocks" => array(
      array(
        "type" => "context",
        "elements" => array(
          array(
            "type" => "mrkdwn",
            "text" => "Site: " . get_site_url()
          )
        )
      ),
      array(
        "type" => "section",
        "fields" => array(
          array(
            "type" => "mrkdwn",
            "text" => (strpos(get_site_url(), "wpengine") !== false ? "[staging] " : "") . $message
          )
        )
      )
    )
  )));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);
  return json_encode($result);
}


add_action( 'rest_api_init', function () {
  register_rest_route( 'slack', '/commands', array(
      'methods'  => array('POST', 'GET'),
      'callback' => 'endpoint_commander',
  ) );
} );

function endpoint_commander() {
  return array(
    'POST' => $_POST,
    'FILES' => $_FILES,
    'GET' => $_GET
  );
}