<?php  

	function timeAgo ($time)
	{
		$time = time() - strtotime($time); // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array (
		    31536000 => 'year',
		    2592000 => 'month',
		    604800 => 'week',
		    86400 => 'day',
		    3600 => 'hour',
		    60 => 'minute',
		    1 => 'second'
		    );
	    
		foreach ($tokens as $unit => $text) {
		    if ($time < $unit) continue;
		    $numberOfUnits = floor($time / $unit);
		    return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}
	}
	
	function generate_coordinate($inputed_address) 
	{
	 
	     $address = str_replace(" ", "+", $inputed_address);
     
	     $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
	     $json = json_decode($json);
	     
	     $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	     $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	     
	     $arr_lat_lng = array(
				     'lat'   => $lat,
				     'lng'   => $long
		 
				 );
	     
	     return $arr_lat_lng;
	}
	
    	
	

