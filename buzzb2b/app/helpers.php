<?php

if (! function_exists('generate_coordinate'))
{  
   function generate_coordinate($inputed_address) 
   {
        /*$arr_lat_lng = array(
                              'lat'   => '',
                              'lng'   => ''
            
                            );*/
        return $inputed_address;exit();
        echo $address = str_replace(" ", "+", $inputed_address);exit();
/*
        $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
        $json = json_decode($json);
        
        echo '<><>'.$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        echo '<><>'.$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        exit();
        $arr_lat_lng = array(
                              'lat'   => $lat,
                              'lng'   => $long
            
                            );
        
        return $arr_lat_lng;
        */
   }
    
}