<?php
function fill_string_values($string , $model)
{
    foreach($model->attributesToArray() as $key => $value)
    {
        if(!is_array($value))
            $string = str_replace('{'.$key.'}', $value, $string);
    }
    return $string;
}