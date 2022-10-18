<?php

if(!function_exists('generateRandomString')){
    function generateRandomString($length = 5, $mode = 1)
    {
        if($mode == 1){ // alfa-numeric up and low case
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else if($mode == 2){ //alfa-numeric up case only
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else if($mode == 3){ //alfa-numeric low case only
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        } else if($mode == 4){ //alfa up case only
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else if($mode == 5){ //alfa low case only
            $characters = 'abcdefghijklmnopqrstuvwxyz';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}