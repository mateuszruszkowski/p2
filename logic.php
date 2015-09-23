<?php

// all without add_number and add_symbol
$wn  = isset($_GET['words_number']) ? $_GET['words_number']  : '5';
$num = isset($_GET['numbers']) ? $_GET['numbers'] : '0';
$sym = isset($_GET['symbols']) ? $_GET['symbols'] : '0';
$ml  = isset($_GET['max_length']) ? $_GET['max_length'] : '30';
$sep = isset($_GET['separator']) ? $_GET['separator'] : '-';
$case = isset($_GET['cases']) ? $_GET['cases'] : 0;

$addN =  ( (int)$num > 0 ) ? 1: 0;
$addS =  ( (int)$sym > 0 ) ? 1: 0;

// define variables
$error = 0;
$passArray = Array();
$passString = '';
$x = 0;

// for testing polish words
//$words = Array( 0 => 'dom', 1=>'but', 2=>'szafa', 3=>'franek', 4=>'pidzama', 5=>'szklanaka', 6=>'kubek', 7=>'biurko', 8=>'krzesło', 9=>'laptop');

// get wordlist
$matches = Array();
$words = Array();

for($i=1;$i<30;$i+=2){  // 30
	
	if( $i<10 ){	$no_page = '0'.$i;	}else{ $no_page = $i; }
	if( ($i+1) <10 ){ $no_page_plus1 = '0'.($i+1); }else{ $no_page_plus1 = $i+1; }
	$page = file_get_contents('http://www.paulnoll.com/Books/Clear-English/words-'.$no_page.'-'.$no_page_plus1.'-hundred.html');
	
	preg_match_all('#<li>.+?</li>#is',$page,$matches);
	foreach($matches[0] as $match)
	{
		$match = trim(preg_replace('/\s\s+/', ' ', $match));
		preg_match_all('/<li>(.*?)<\/li>/s', $match, $m);
		$words[] = trim($m[1][0]);
	}

}

// special chars array
$specials_chars = Array( 0=>'!', 1=>'@', 2=> '#', 3=>'$', 4=>'%', 5=>'^', 6=>'&', 7=>'*');

// validate vars
$valid = ValidateVars($wn, $num, $sym, $ml, $sep);

if (  $valid != 1 ) { 
	$error = $valid; 
}else{

	// 5 attempts to generate password with length smaller than max length
	while($x <= 5) {

		// if vars are ok let's generate password
		for($i=0;$i<$wn;$i++){
			$randValue = rand(0, count($words)-1 );
			$passArray[$i] = $words[$randValue];

			// add numbers and symbols if index is lower than number of them
			if ($i < $num && $addN){	$passArray[$i] .= rand(0, 9);	}
			if ($i < $sym && $addS){	$passArray[$i] .= $specials_chars[ rand(0, 7)];	}

			// add custom cases 
			switch ($case) {
			    case 0:
			        $passArray[$i] = ucfirst(strtolower($passArray[$i]));
			        break;
			    case 1:
			        $passArray[$i] = strtoupper($passArray[$i]);
			        break;
			    case 2:
			        $passArray[$i] = strtolower($passArray[$i]);
			        break;
			}

		}

		// add missing numbers and symbols in needed
		if($num > $wn && $addN){
			for($i=0; $i<($num-$wn);$i++){ $passArray[$wn-1].= rand(0, 9); }
		}
		
		if($sym > $wn && $addS){
			for($i=0; $i<($sym-$wn);$i++){ $passArray[$wn-1].= $specials_chars[ rand(0, 7)]; }
		}

		$passString = implode($sep, $passArray);

		# check if password length is smaller than max length, if we find suited password set $x as 10 else end loop as a 5
		if( strlen($passString) <= $ml) { 
			$x = 10; 
		}else{
    		$x++;	
		}
	    
	}
	if($x!=10) {
		$error = "Sorry, we can't find good words to generate password shorter than max length";
	}

}



/**
	validate all variables with comment
**/
function ValidateVars($words_number, $numbers, $symbols, $max_length, $separator){

	#words_number
	if( strlen($words_number)<2 && strlen($words_number)>0 && is_numeric($words_number) ){
		#numbers
		if( strlen($numbers)<2 && strlen($numbers)>0 && is_numeric($numbers) ){
			#symbols
			if( strlen($symbols)<2 && strlen($symbols)>0 && is_numeric($symbols) ){
				#max_length
				if( strlen($max_length)<3 && strlen($max_length)>0 && is_numeric($max_length) ){
					#separator
					if( strlen($separator)<2 && strlen($separator)>0 && is_string($symbols) ){
						return 1;
					}else{
						return "Separator value isn't valid";
					}

				}else{
					return "Max length value isn't valid";
				}

			}else{
				return "Symbols value isn't valid";
			}

		}else{
			return "Numbers value isn't valid";
		}

	}else{
		return "Words number value isn't valid";
	}

}


?>