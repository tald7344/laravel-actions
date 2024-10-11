<?php
function generate_code($length = 6, $type = 'numeric')
{
    if($type == 'mix')
        $characters = '3s5df46w84e351asd35';
    elseif($type == 'string')
        $characters = 'a3s51f35as4df68a4e86rw3153f5a1s';
    elseif($type == 'numeric')
        $characters = '321654987';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}