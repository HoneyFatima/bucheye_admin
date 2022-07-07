<?php

namespace App\Providers;

use App\Providers\ResetPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOtpVerificationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\ResetPassword  $event
     * @return void
     */
    public function handle(ResetPassword $event)
    {
       $smsmessage =urlencode("Your One Time Password is $event->otp Do not share with anyone. EASY LIFE");
       $sms_url1 = "http://sms.osdigital.in/V2/http-api.php?apikey=aSyRLbHzjJUaPMGM&senderid=EASYLS&number=".$event->mobile."&message=".$smsmessage."&format=json";
       $res=file_get_contents($sms_url1);
    //    dd($res);
       
    }
}
