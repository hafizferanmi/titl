<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use AfricasTalking\SDK\AfricasTalking;

class USSDcontroller extends Controller
{
    public function askUSSDMoney(Request $req) {
        
        $sessionId = $req->sessionId;
        $serviceCode = $req->serviceCode;
        $phoneNumber = str_replace('+234', '0', $req->phoneNumber);
        $text = $req->text;

        $exploded_text = explode('*', $text);
        $step = count($exploded_text);

        // return $serviceCode;

        if ($text == "") { // TODO: write regular expression to figure out type of query string
            $response  = "CON What do you like to do \n";
            $response .= "1. My data balance \n";
            $response .= "2. My phone number \n";
            $response .= "3. REFER A FRIEND (REWARD PROGRAM) \n";
            $response .= "4. Get wallet balance \n";
            $response .= "5. Next \n";

        } else if ($text == "1") {
            $response = "END Your data balance is 500mb"; // TODO - Should fetch data balance from DB
        } else if ($text == "2") {
            $response = "END Your phone number is " . $phoneNumber;
        } else if ($text == "3") {
            $response = "CON Enter friends phone number";
        } else if ($text == "4") {
            $user = User::Where('phone', $phoneNumber)->first();
            $response = "END Your wallet balance is N" . $user->wallet_balance;
        } else if ($text == "5") {
            $response = "CON 1.Call a friend \n";
            $response .= "2 Ping a friend \n";
            $response .= "3. Previous \n";
        } else if($text == '5*1') {
            $response = 'END You just called a friend';
        } else if ($text == '5*2') {
            $response = 'END You just pinged a friend';
        } else if ($text == '5*3') {
            $response  = "CON What do you like to do \n";
            $response .= "1. My data balance \n";
            $response .= "2. My phone number \n";
            $response .= "3. REFER A FRIEND (REWARD PROGRAM) \n";
            $response .= "4. Get wallet balance \n";
            $response .= "5. Next \n";
        } else {
            $text = explode('*', $text);
            $referredPhone = $text[1];
            $user = new User;
            $user->name = '';
            $user->phone = $referredPhone;
            $user->referred_by = $phoneNumber;

            $this->sendSMS($user->phone);
            $user->save();

            $response = 'END You have successfully referred your friend';
        }
        header('Content-type: text/plain');
        echo $response;
    }

    private function sendSMS($to) {
        $username   = "sandbox";
        $apiKey     = "0eb0628f330ba0bc8feb39fb18bc277952348099d61429cf5c1a8efb364d3ae1";
        $AT         = new AfricasTalking($username, $apiKey);

        $sms        = $AT->sms();
        $recipients = $to;
        $message    = "Hello world";
        $from       = "HAFIZ";
        
        try {
            $result = $sms->send([
                'to'      => $recipients,
                'message' => $message,
                'from'    => $from
            ]);
           return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
