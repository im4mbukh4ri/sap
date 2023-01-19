<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Log;

class UpdatePhoneNumber extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $username;

    private $phoneNumber;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($username, $phoneNumber)
    {
        $this->username = $username;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $parameters = [
            'access_id' => '1031MYSIP201704',
            'access_pass' => '300980e7d88a85adb814387ffb914066',
            'access_type' => 'UPD',
            'username' => $this->username,
            'phone' => $this->phoneNumber
        ];
        $url = 'https://access.sipindonesia.com/api/modify_phone.asp';
        $log = Log::create([
            'request' => json_encode($parameters),
            'url' => $url
        ]);
        $curl = curl_init();

        $options = [
            CURLOPT_URL => 'https://access.sipindonesia.com/api/modify_phone.asp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($parameters),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ]
        ];

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $data = json_decode($response, true);

        if ($err) {
            $log->response = 'error : ' . $err;
            $log->save();
            return $this;
        }
        $log->response = $response;
        $log->save();
        return $this;
    }
}
