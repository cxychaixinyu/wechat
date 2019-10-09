<?php

namespace App\Model;

class Curl
{
    public function get($url)
    {
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_URL,"http://www.1901.com");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        $output=curl_exec($ch);
        cubrid_close($ch);
        return $output;
    }

    public function post($url,$postData)
    {
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_PORT,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postData);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        $output=curl_exec($ch);
        cubrid_close($ch);
        return $output;
    }
}
