<?php

class AuthController
{
    static function isLogged()
    {
        if(isset($_SESSION['user']))
        {
            return true;
        }else{
            return false;
        }
    }
}