<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('key_generator'))
	{
		function key_generator($length)
		{
			$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
			
			for($i=0; $i<$length; $i++)
			{
				$rand_value=rand(0,61);
				$rand_number=$number["$rand_value"];
			
				if(empty($con))
				{ 
				$con=$rand_number;
				}
				else
				{
				$con="$con"."$rand_number";}
				}
			return $con;
		}
	}

	if(!function_exists('rec_display_children'))
	{
		function rec_display_children($parent,$level){
			$CI =& get_instance();
			$CI->load->model('admin/main_menu');
			
			
			return $this->main_menu->display_children($parent,$level);
		
		}
	}
	
	//Return date with full Chars of Month 
	if(!function_exists('get_date_full_month'))
	{
		function get_date_full_month($full_date = Null){
			if($full_date){
				$final_date = date('F j, Y', strtotime($full_date));
			}else{$final_date="";}
			return $final_date;
		}
	}
	
	//Return date with first 3Chars of Month 
	if(!function_exists('get_date_small_month'))
	{
		function get_date_small_month($full_date = Null){
			if($full_date){
				$final_date = date('M j, Y', strtotime($full_date));
			}else{$final_date="";}
			return $final_date;
		}
	}
	//
	if(!function_exists('dateConvert')){
		function dateConvert($date){
			list($year,$month,$day) = explode('-',$date);
			//list($hour,$minute,$second) = explode(':',$date);
			$day = $day+1;
			$day = $day-1;
			switch ($month)
			{
				case "01":
					$month = 'JAN';
					break;
				case "02":
					$month = 'FEB';
					break;
				case "03":
					$month = 'MAR';
					break;
				case "04":
					$month = 'APR';
					break;
				case "05":
					$month = 'MAY';
					break;
				case "06":
					$month = 'JUN';
					break;
				case "07":
					$month = 'JUL';
					break;
				case "08":
					$month = 'AUG';
					break;
				case "09":
					$month = 'SEP';
					break;
				case "10":
					$month = 'OCT';
					break;
				case "11":
					$month = 'NOV';
					break;
				case "12":
					$month = 'DEC';
					break;
			}
			$final_date = $day.' - '.$month.' - '.$year;
			return $final_date;
		}
	}
	//
	if(!function_exists('date_numeric_format')){
		function date_numeric_format($full_date = Null){
		if($full_date){
			list($year,$month,$day) = explode('-',$full_date);
			//list($hour,$minute,$second) = explode(':',$date);
			$day = $day+1;
			$day = $day-1;
			$final_date = $day.'/'.$month.'/'.$year;
		}else{$final_date="";}
			return $final_date;
		}
	}
	//
	if(!function_exists('convert_number_to_words')){
		function convert_number_to_words($number) {
			$hyphen      = '-';
			$conjunction = ' and ';
			$separator   = ', ';
			$negative    = 'negative ';
			$decimal     = ' point ';
			$dictionary  = array(
				0                   => 'zero',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20                  => 'twenty',
				30                  => 'thirty',
				40                  => 'fourty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety',
				100                 => 'hundred',
				1000                => 'thousand',
				1000000             => 'million',
				1000000000          => 'billion',
				1000000000000       => 'trillion',
				1000000000000000    => 'quadrillion',
				1000000000000000000 => 'quintillion'
			);
			
			if (!is_numeric($number)) {
				return false;
			}
			
			if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
				// overflow
				trigger_error(
					'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
					E_USER_WARNING
				);
				return false;
			}

			if ($number < 0) {
				return $negative . convert_number_to_words(abs($number));
			}
			
			$string = $fraction = null;
			
			if (strpos($number, '.') !== false) {
				list($number, $fraction) = explode('.', $number);
			}
			
			switch (true) {
				case $number < 21:
					$string = $dictionary[$number];
					break;
				case $number < 100:
					$tens   = ((int) ($number / 10)) * 10;
					$units  = $number % 10;
					$string = $dictionary[$tens];
					if ($units) {
						$string .= $hyphen . $dictionary[$units];
					}
					break;
				case $number < 1000:
					$hundreds  = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if ($remainder) {
						$string .= $conjunction . convert_number_to_words($remainder);
					}
					break;
				default:
					$baseUnit = pow(1000, floor(log($number, 1000)));
					$numBaseUnits = (int) ($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
					if ($remainder) {
						$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= convert_number_to_words($remainder);
					}
					break;
			}
			
			if (null !== $fraction && is_numeric($fraction)) {
				$string .= $decimal;
				$words = array();
				foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
				}
				$string .= implode(' ', $words);
			}
			
			return $string;
		}
	}