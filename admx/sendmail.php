<?php
error_reporting(0);
include "includes/Func.php";
//start api now
header("content-type: application/json");

//send one signal messages
function SendOneSignalMessage($title, $message, $img, $appId, $aoth)
{
    // Your code here!
    $fields = array(
        'app_id' => $appId,
        'included_segments' => ["Active Users", "Inactive Users"],
        'contents' => array("en" => $message),
        'headings' => array("en" => $title),
        'big_picture' => 'https://ellingtonelectric.com/dwn/quote/' . $img,
        'data' => array("image" => $img, "quote" => $message, "author" => $title),
        'large_icon' => 'https://ellingtonelectric.com/dwn/quote/' . $img,
        'ios_attachments' => array('id1' => 'https://ellingtonelectric.com/dwn/quote/' . $img),
        'small_icon' => '@mipmap/ic_launcher',
    );

    $fields = json_encode($fields);
    //print("\nJSON sent:\n");
    //print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $aoth));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

//call to functions
function sendNot($author, $body, $img)
{
    // $data = file_get_contents("raw.json");
    // $data = json_decode($data);
    // //iterate quotes
    // $quotes = (array)$data[rand(0, count($data)-1)];
    // $arr = $quotes;
    echo SendOneSignalMessage("Ellington Daily Mindset Booster", $author . ": " . $body, $img, "a72cd359-3cd6-44e2-9952-a26ca011684d", "ODU5NzA5OTEtOWQ0OC00YTdkLWE4NDAtMDg4YmJkODIzZTlh");
}

//get all and send email
function sendEmail($body, $image)
{
    date_default_timezone_set('Africa/Lagos');
    $rd = DB::query("SELECT * FROM `emails` WHERE `estatus`=1");
    if (!$rd) {
        return false;
    }
    //send email now

    foreach ($rd as $k => $v) {
        $time = time();
        $check = $time + date("Z", $time);

        $to = $v['eemail'];
        $subject = 'Daily Mindset Booster Today';
        $from = 'Ellington <hello@ellingtonelectric.com>';

// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
        $headers .= 'From: ' . $from . "\r\n" .
            'Reply-To: Ellington <' . $from . ">\r\n" .
            'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email message
        $message = '<html>';
        $message .= '<body style="text-align: center; width: 100%">
<div style="width: 512px; overflow: auto; height: 650px; border: 0px solid grey; background-color: #e7e7e7; position: absolute; left: 31%; top: 1%; bottom: 0;">
    <div style="padding: 3px;">
        <p>' . $body . '</p>
    </div>
    <img style="width: 512px;" src="https://ellingtonelectric.com/api/reedax/images/' . $image . '.jpg"/>
    <div style="width: 100%; position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.16); height: 30px;">
        <a href="http://ellingtonelectric.com/dwn/quote/' . $image . ' " download>Download Image</a>
    </div>
</div>
</body>';
        $message .= '</html>';

// Sending email
        if (mail($to, $subject, $message, $headers)) {
            //return true;
        } else {
            //echo false;
        }
    }
}

;

//prepare email
function sendEmailPre()
{
    //initialize model
    $model = new Model();
    $model->
    $data = $model->getDaily();
    //check if images
    if (!file_exists("../images/" . $data['image'] . ".jpg")) {
        //re-shuffle
        sendEmailPre();
        return;
    }
    //send noti & email
    sendNot($data['author'], $data['quote'], $data['image']);
    sendEmail("<strong>" . $data['author'] . "</strong>: " . $data['quote'], $data['image']);
    //var_dump($data);
}

sendEmailPre();