<?php
//$con = mysql_connect('localhost','root','');
//mysql_select_db('zomato_db',$con);
?>
<html>
<head>
<style>
.hidden {
display:none;
}
.visible {
display:block;
position:absolute;
top:0;left:0;
}
</style>
<script>
document.getElementById("loading").className="visible";var hide=function(){document.getElementById("loading").className="hidden"};var oldLoad=window.onload;var newLoad=oldLoad?function(){hide.call(this);oldLoad.call(this)}:hide;window.onload=newLoad; 
</script>
</head>
<body>
<center><h3>Zomato Restaurant Tracker(For India)</h3>
<form name="search_restaurant" method="POST">
<table>
<tr>
  <td>
    <select name="type">
	   <option>Select Food Type</option>
	   <option value="chinese">Chinese</option> 
       <option value="continental">Continental</option> 
       <option value="mughlai">Mughlai</option> 
       <option value="south-indian">South Indian</option>    	   
	 </select>
  </td>
  <td>
     <select name="place">
	   <option>Select Place</option>
	   <option value="agra">Agra</option>
<option value="ahmedabad">Ahmedabad</option>
<option value="allahabad">Allahabad</option>
<option value="amritsar">Amritsar</option>
<option value="aurangabad">Aurangabad</option>
<option value="bangalore">Bangalore</option>    
<option value="bhubaneswar">Bhubaneswar</option>
<option value="bhopal">Bhopal</option>
<option value="chandigarh">Chandigarh</option>
<option value="chennai">chennai</option>
<option value="coimbatore">coimbatore</option>
<option value="dehradun">dehradun</option>
<option value="ncr">ncr</option>
<option value="goa">goa</option>
<option value="guwahati">guwahati</option>    
<option value="hyderabad">hyderabad</option>
<option value="indore">indore</option>
<option value="jaipur">jaipur</option>	
<option value="kanpur">kanpur</option>
<option value="kochi">kochi</option>
<option value="kolkata">kolkata</option>
<option value="lucknow">lucknow</option>
<option value="ludhiana">ludhiana</option>    
<option value="mangalore">mangalore</option>
<option value="mumbai">mumbai</option>
<option value="mysore">mysore</option>  
<option value="nagpur">nagpur</option>	
<option value="nashik">nashik</option>
<option value="patna">patna</option>
<option value="puducherry">puducherry</option>
<option value="pune">pune</option>
<option value="ranchi">ranchi</option>    
<option value="surat">surat</option>
<option value="vadodara">vadodara</option>
<option value="varanasi">varanasi</option> 
<option value="visakhapatnam">visakhapatnam</option>
	 </select>	 
  </td>
  <td>
  <select name="country">
    <option value="india">India</option>
  </select>
  </td>
  <td><input type="submit" name="search" /></td>
  <td><img src="ajax-loader.gif" id="loading" class="hidden"></td> 
</tr>
</table>
</form>
</center>

<?php
 /* ---------------- Developed by Algobasket ------------- */
 
 /* --------- Visit us on algobasket.us or algobasket.com ----------- */
 if(isset($_POST['search'])) 
 {  
    set_time_limit(0); 
	$place      = $_POST['place'];
	$food_type  = $_POST['type'];
	$country    = $_POST['country'];  
	$url = "https://www.zomato.com/".$place."/restaurants/".$food_type."?sort=best"; 
    $content = file_get_contents($url,true);
	$start = '<ol>';
	$end   = '</ol>';
    $result = extract_section($content,$start,$end,$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
    $start2 = '<ul data-only_page_str="" class="pagination-control res-menu-paginator"><li class="disabled prev" >&lt;</li>';
	$end2   = '<li class="active next">';
	$result2 = extract_section($content,$start2,$end2,$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);  
    $array2   = explode('<li class=" active">',$result2);
	
	if(is_array($array2))
   {
      //--- Some data found ------
	  $i = 1;
	  foreach($array2 as $r)
	  {
	    $url2 = "https://www.zomato.com/".$place."/restaurants/".$food_type."?sort=best&page=".$i; 
        $content2 = file_get_contents($url2,true);
        $result3 = extract_section($content2,$start,$end,$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0); 
		//----- Extract Hotel Name ------
		$x = explode('<li',$result3);
		$count_hotel = 1;
		$total_hotels = count($x);
		foreach($x as $y)
		{
		      $result4 = extract_section($y,'<h3 class="top-res-box-name ln24 left">','</h3>',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
		      
			  
			  $result5 = extract_section($result4,'"ResCard_Name" >','</a>',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
		      
			    		
				
			  if($result5!==0)
			  {
			    $count_hotel_array[] = $count_hotel;
			    echo $result5;
				echo '</br>';
				$start3  = '<div class="search-result-links pt5 pb5 box-sizing-content">';
			    $end3    = '<div class="clear"></div>';
				$result6 = extract_section($y,$start3,$end3,$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0); 
                if($result6!==0){
				$array3 = explode('<div class="left mr10 mb5">',$result6);			
			    $menu   = @$array3[1];
				$photo  = @$array3[2];
				$review = @$array3[3];
				if(strpos($menu,'menu#tabtop') !== false)
				{
				   $m = extract_section($menu,'<a href="https://www.zomato.com/'.$place.'/','/menu#tabtop',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
				   $m_type="menu#tabtop";
				}
				elseif(strpos($menu,'photos#tabtop') !== false)
				{
				   $m = extract_section($menu,'<a href="https://www.zomato.com/'.$place.'/','/photos#tabtop',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
				   $m_type="photos#tabtop";
				}
				elseif(strpos($menu,'reviews#tabtop') !== false)
				{
				   $m = extract_section($menu,'<a href="https://www.zomato.com/'.$place.'/','/reviews#tabtop',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
				   $m_type="reviews#tabtop"; 
				}
				
				
				$p = extract_section($photo,'<a href="https://www.zomato.com/'.$place.'/','/photos#tabtop',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
				$n = extract_section($review,'<a href="https://www.zomato.com/'.$place.'/','/reviews#tabtop',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
			    
				echo '<table border="1">';    
				echo '<tr>';
				echo '<td>'.strip_tags($m).'</td>';
				echo '<td>'.strip_tags($photo).'</td>';
				echo '<td>'.strip_tags($review).'</td>';
				
			    
                //----- New Page code ------- //
                $page_url          = 'https://www.zomato.com/'.$place.'/'.$m.'/'.$m_type;  
               	$page_content      = file_get_contents($page_url,true);
                $page_extract      = extract_section($page_content,'<div class="wrapper container" id="mainframe">','<div class="col-l-4 pl15 pt15 hide-on-mobile no-obp-col"',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);				
			    $page_extract_ph   = extract_section($page_extract,'<span class="tel">','</span>',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
				$page_extract_json = extract_section($page_content,'zomato.menuPages =','zomato.menuTypes = ["DEFAULT","FOOD","BAR","DELIVERY","SPECIAL"];',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
				$menus              = json_decode(str_replace(';','',$page_extract_json),true);
				echo '<td>';
				if(is_array($menus)){
				 foreach($menus as $menu)
				{
				  echo '<li>'.$menu['url'].'</li>';
				}
				}
				echo '</td>';
				$page_extract_location = extract_section($page_content,'itemtype="http://schema.org/PostalAddress">','<span class="hidden" itemprop="addressCountry">India</span>',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);
				//$page_array = explode('<span class="tel">',$page_extract);
			    //$number = explode('<br>',$page_array[1]); 
				echo $number[0];
			   echo '<td>'.strip_tags($page_extract_ph).'</td>';
			   //echo '<td>'.$page_extract_json.'</td>';
			   echo '<td>'.strip_tags($page_extract_location).'</td>';
			   echo '</tr>';
			   echo '</table>';
			   //mysql_query("insert into zomato set restaurant_name='".$result5."',phone_number='".$page_extract_ph."',address = '".$page_extract_location."',menu = '".str_replace(';','',$page_extract_json)."',place='".$place."',speciality='".$food_type."',country='".$country."'");
			   }
			  }
		  $count_hotel++; 
		}
		//echo $hotel_name = extract_section($result3,'<>','</a>',$includestart=0,$includeend=0,$returnarray=0,$separator = "",$leave_start_elements = 0,$leave_end_elements = 0,$striphtml = 0,$search_arr = 0,$replace_arr = 0);  
	   $i++;
	  }
   }	
 }
  
?>
</body>
</html>









<?php

    // -------------- Don't edit below this line --------------- //

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