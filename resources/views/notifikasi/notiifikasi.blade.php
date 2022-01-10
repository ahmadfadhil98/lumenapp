<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "to":"'.$user->fcm_token.'",
    "data" : {
        "booking_id" : "'.$booking->id.'",
        "homestay_id" : "'.$homestay->id.'",
        "status" : "'.$booking->status.'"
    },
    "notification":{
        "title":"'.$notifikasi->title.'",
        "body":"'.$notifikasi->message.'"
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: key=AAAAbGnz1ls:APA91bGMFisIK9_x3Tby2MNSHkLA2_cq6Zy11Mr5fXkPFov0vMV2kSUtImlfQz_9s1G9tU6qY8EnxHI1DdNQHIiERecBRh4P3Tnih4S5gmQOvFJ29ep0NBzuAFIbEhNxp9r0odO5aaMb',
    'Content-Type: application/json',
    'token: 2847b61228c6661c4ceeda0e2e53fd36e9439535b53f8ca8dd1df6c792e8d8e06072441f72573624'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
