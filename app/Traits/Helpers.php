<?php

namespace App\Traits;

trait Helpers {

    /**
     * get a random name for a file
     * @param string $prefix
     */
    public function getRandomName($prefix = null){
        if(!is_null($prefix))
            $randomName = $prefix . '_';
        else
            $randomName = '';
        $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomName .= substr(str_shuffle($permittedChars), 0, 15) . '_' . time();
        return $randomName;
    }
}
