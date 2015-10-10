<?php

/*
 scrap function
*/


function curl_get_contents($url)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

 function extract_section($inputstring,$start,$end,$includestart,$includeend,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0)
 {
       // ---------------- extract_section v 2.0 -------------------- // 
   
$final_result_arr = array();   
if($returnarray == 1) 
{      
	$result_arr = explode(($separator)? $result : $start.$result, $inputstring);
	//print_r($result_arr);
	foreach($result_arr as $result)
	{
		
		$temp = extract_section(($separator)? $result : $start.$result, $start, $end,$includestart,$includeend,0,"", 0, 0, $striphtml, $search_arr, $replace_arr);
		
		//echo "$result<br>***************<br>$temp"; break;
		
		array_push($final_result_arr, $temp);
		
	}
	$arr_count = count($final_result_arr);
	//print_r($final_result_arr);
	if($leave_start_elements>0  || $leave_end_elements>0)
	{
	if(($leave_end_elements > $arr_count) || ($leave_start_elements > $arr_count)) 
		{  return $final_result_arr;  }
	elseif(($leave_start_elements + $leave_end_elements) > $arr_count)  
		{  return array_slice($final_result_arr, $leave_start_elements);  }
	else
		{  return array_slice($final_result_arr, $leave_start_elements, $arr_count - $leave_start_elements - $leave_end_elements);  }
	}
	return $final_result_arr;
}
//echo "$inputstring,$start,$end,$includestart,$includeend";
$startpos=strpos($inputstring,$start);
if($startpos === false) return 0;
$startlength=strlen($start);
$endpos=$startpos+strpos(strstr($inputstring,$start),$end);
$endlength=strlen($end);
if($includestart==0)
  {
  if($includeend==0)
    {
	$outputstring=substr($inputstring,$startpos+$startlength,$endpos-$startpos-$startlength);
	}
  else
    {
	$outputstring=substr($inputstring,$startpos+$startlength,$endpos-$startpos-$startlength+$endlength);	
	}
  }
else
  {
  if($includeend==0)
    {
	$outputstring=substr($inputstring,$startpos,$endpos-$startpos);	
	}
  else
    { 
	$outputstring=substr($inputstring,$startpos,$endpos-$startpos+$endlength);	
	}
  } 
//echo "<br><br><br>$outputstring";
if($search_arr && $replace_arr)  
$outputstring = str_replace($search_arr, $replace_arr, trim($outputstring));
if($striphtml == 1) $outputstring = strip_tags($outputstring);
$outputstring = trim($outputstring);
return $outputstring;
}

?>