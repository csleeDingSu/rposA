<?php

if( ! function_exists('unique_random') ){
    /**
     *
     * Generate a unique random string of characters
     * uses str_random() helper for generating the random string
     *
     * @param     $table - name of the table
     * @param     $col - name of the column that needs to be tested
     * @param int $chars - length of the random string
     *
     * @return string
     */
    function unique_random($table, $col, $chars = 16){

        $unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        do{

            // Generate random string of characters
            $random = str_random($chars);

            // Check if it's already testing
            // If so, don't query the database again
            if( in_array($random, $tested) ){
                continue;
            }

            // Check if it is unique in the database
            $count = DB::table($table)->where($col, '=', $random)->count();

            // Store the random character in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if( $count == 0){
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters

        }
        while(!$unique);


        return $random;
    }

}


function generate_random_number ($min,$max)
{
	return mt_rand($min, $max);
}

function check_odd_even ($num)
{
	if ($num % 2 == 0)
	{
		return 'even';
	}
	return 'odd';
}

function get_uni_key($ln)
	{
		for ($randomNumber = mt_rand(1, 9), $i = 1; $i < $ln; $i++) {
			$randomNumber .= mt_rand(0, 9);
		}
		return $randomNumber;
	}
	
    

   function unique_numeric_random($table, $col, $chars = 16){

        $unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        do{

            // Generate random string of characters
            //$random = mt_rand($chars, $chars);
			$random = get_uni_key($chars);

            // Check if it's already testing
            // If so, don't query the database again
            if( in_array($random, $tested) ){
                continue;
            }

            // Check if it is unique in the database
            $count = DB::table($table)->where($col, '=', $random)->count();

            // Store the random character in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if( $count == 0){
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters

        }
        while(!$unique);


        return $random;
    }

function searchForState($id, $array) 
{
	$st = [];
	foreach ($array as $key => $val) 
	{
		if ($val->prefix === $id) {
			$st[] =  $val->state;
	   }
	}

	$id = substr($id, 0, 2);

	foreach ($array as $key => $val) {
		if ($val->prefix === $id) {
			$st[] =  $val->state;
		}
	}	
	return $st;
}
