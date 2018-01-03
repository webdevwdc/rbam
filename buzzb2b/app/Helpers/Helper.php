<?php
/**
* change plain number to formatted currency
*
* @param $number
* @param $currency
*/
use App\Category;

    function getdata(){
        $data['categories'] = Category::orderBy('name','ASC')->get();
        return $data;
     }
     
     
     
     
 function presentPeosAmount($peosAmount, $valueIfZero = '0.00') {
	return (($peosAmount == 0 || is_null($peosAmount)) ? $valueIfZero : convertFromPeosAmount($peosAmount, true));
}

/**
 * Converts a stored peos currency-type int to a float
 * 
 * @param  int     $peosAmount  peos int format from storage (ex: 299)
 * @param  bool    $commas      option to include commas in output number
 * @return string               a standard decimal type (ex: 2.99)
 */
function convertFromPeosAmount($peosAmount = 0, $commas = false) {
	return number_format( (float) $peosAmount/100, 2, '.', ($commas) ? ',' : '');
}

/**
 * Presents a float barter amount
 * 
 * @param  int     $peosAmount   peos int format from storage (ex: 299)
 * @param  string  $valueIfZero  a string to reurn if no value
 * @param  string  $prefix       prefix to include before output number
 * @param  bool    $commas       option to include commas in output number
 * @return string                a barter amount, ex: T$2.99
 */
function presentBarterAmount($peosAmount, $valueIfZero = '0.00', $prefix = 'T$', $commas = true) {
	return (($peosAmount == 0 || is_null($peosAmount)) ? $valueIfZero : $prefix . convertFromPeosAmount($peosAmount, $commas));
}

/**
 * Presents a float cash amount
 * 
 * @param  int     $peosAmount   peos int format from storage (ex: 299)
 * @param  string  $valueIfZero  a string to reurn if no value
 * @param  string  $prefix       prefix to include before output number
 * @param  bool    $commas       option to include commas in output number
 * @return string                a cash amount, ex: $2.99
 */
function presentCashAmount($peosAmount, $valueIfZero = '0.00', $prefix = '$', $commas = true) {
	return (($peosAmount == 0 || is_null($peosAmount)) ? $valueIfZero : $prefix . convertFromPeosAmount($peosAmount, $commas));
}

/**
 * Presents a rate amount
 * 
 * If rate ends with a clean ".00" then output number will not include decimal points
 * 
 * @param  int     $peosAmount   peos int format from storage (ex: 1000)
 * @param  string  $valueIfZero  a string to reurn if no value
 * @param  string  $suffix       suffix to include after output number
 * @param  bool    $commas       option to include commas in output number
 * @return string                a cash amount, ex: 10%
 */
function presentRateAmount($peosAmount, $valueIfZero = '0', $suffix = '%', $commas = true) {

	$decimalAmount = convertFromPeosAmount($peosAmount);

	if (substr($decimalAmount, -3) == '.00')
	{
		$decimalAmount = substr($decimalAmount, 0, -3);
	}

	return (($decimalAmount == 0) ? $valueIfZero : $decimalAmount . $suffix);
}

/**
 * Converts an input string currency-type to a peos currency-type
 * 
 * @param  string $amount  an input string decimal
 * @return int             a peos integer type dollar amount
 */
function sanitizeDecimalForStore($amount = 0) {
	
	// remove any commas
	$amount = str_replace(',', '', $amount);

	$peos_int = $amount * 100;

	return $peos_int;
}

/**
 * Converts an input standard phone number to an integer
 * 
 * @param  string $inputValue format: (999) 999-9999 | 9999999999
 * @return int                format: 999999999
 */
function sanitizePhoneForStore($inputValue) {

	if (is_numeric($inputValue))
	{
		return substr($inputValue, 0, 10);
	}

	return substr($inputValue, 1, 3) . substr($inputValue, 6, 3) . substr($inputValue, 10, 4);

}

function presentPhoneNumber($number)
{
	return '(' . substr($number, 0, 3) . ') ' . substr($number, 3, 3) . '-' . substr($number, 6, 4); 
}

function trim_site_url($subdomain = false, $trimExtension = false) {
	
	$parts = explode("//", \Config::get('app.url'));

	$site_url = $parts[1];
	
	if ($trimExtension)
	{
		$parts = explode(".", $site_url);

		$site_url = $parts[0];
	}
	
	return (! $subdomain) ? $site_url : $subdomain . '.' . $site_url;
}

// function link_to_bin_image($filename) {
// 	return link_to_peos_base('img/bin/' . $filename);
// }

// function link_to_some_image($filename) {
// 	return link_to_peos_base('img/' . $filename);
// }

// function link_to_peos_base($path) {

// 	if (\App::environment('production'))
// 	{
// 		return secure_url($path);
// 	}

// 	return url($path);
// }

function generate_api_key($type, $id) {

	switch ($type) {
		case 'member':
			$prefix = 'm';
			break;
		case 'user':
			$prefix = 'u';
			break;
		default:
			$prefix = '';
	}
	
	$key = $prefix . str_random(16) . $id . '-' . str_random(16);

	return $key;
}    

?>