<?php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
if(!function_exists('qrCode')){
    function qrCode($value){
        return QrCode::size(75)->generate($value);
    }

}