<?php
namespace app\service;
use Carbon\Carbon;
use DB;

class AuthService 
{
    public function verify($token) 

    {
        $token = $this->setExpireTime($token);
        return $token;
    }

    private function setExpireTime($token)
    {
        $expireTime = Carbon::now()->addSeconds(30000)->timestamp;
        DB::table('oauth_access_tokens')->where('id',$token['access_token'])->update(['expire_time' => $expireTime]);
        $token['expires_in'] = 30000;
        return $token;
    }



}


?>