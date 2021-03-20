<?php

namespace App\Services;

use App\Services\Sms;



class SendSms
{
    
    const BASE_URL = 'https://api.orange.com';

    public function __construct()
    {
    }

    
    public function sendSMS($phone, $message)
    {
        $config = array(
            'clientId' => 'FFZaKInaUAerDrGsQQlT7lTmzMi9UE94',
            'clientSecret' =>  '2O4WWvHLvPqfbw4S',
        );

        $osms = new Sms($config);

        $data = $osms->getTokenFromConsumerKey();
        $token = array(
            'token' => $data['access_token']
        );


        $response = $osms->sendSms(
        // sender
            'tel:+2210000',
            // receiver
            'tel:+221' . $phone,
            // message
            $message,
            'SMB'
        );
       // dd($response);
    }
}