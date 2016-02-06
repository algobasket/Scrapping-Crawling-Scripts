<?php
session_start(); 
error_reporting(0);
set_time_limit(0);
 require 'scrap-function.php'; 
 $url = "http://www.paginasamarillas.es/";
 $content = file_get_contents($url);     
 $select  = extract_section($content,$start='<label for="department" data-label-hide class="has-hidden-label">Zoek in afdelingen</label>',$end='<div class="select-distance">',0,0,0,"",0,0,0,0,0);
 $select  = str_replace('</div>','',$select);
 ?>
 <h2 style="color:#FF0000">Premium Scrapper(www.paginasamarillas.es)</h2>
 <form method="POST">
   <input type="text" name="search" />  
   <input type="submit" name="submit" value="Hack" />
 </form> 
<a href='javascript:popitup("http://localhost/action.php","add")'>Copy to CSV</a><br>;
 <?php
   if(isset($_REQUEST)) 
   { 
     $search     = isset($_POST['search']) ? $_POST['search'] : $_GET['search'];
     echo '<h3 style="color:#00FF00">Scrapping : '.$search.'</h3>';
     	 
     $counter    = isset($_GET['counter']) ? $_GET['counter'] : 1;  
	 $search_url = $url.$search.'/all-ma/all-pr/all-is/all-ci/all-ba/all-pu/all-nc/'.$counter;      
     $content    = file_get_contents($search_url);
     $extract    = extract_section($content,$start='<ul class="l-plain m-results-businesses adverts-ul">',$end='</script></ul>',0,0,0,"",0,0,0,0,0);	 
     $extract_c = explode('<script type="text/javascript">',$extract);
	 if(is_array($extract_c))
	  {
		  foreach($extract_c as $key_c => $val_c)
		  {
			 if($key_c!==0) 
             {
				 $extract_link = extract_section($val_c,$start='storagePaginationData.push("',$end='");',0,0,0,"",0,0,0,0,0);  
			     // Go to the subpage 
				 $sub_content      = file_get_contents($extract_link);
			     $sub_extract_link = str_replace("'>",'',extract_section($sub_content,$start="data-business='",$end='<div class="container"><section',0,0,0,"",0,0,0,0,0));
			     $array = (array)json_decode($sub_extract_link); 
				 if(isset($array['customerMail']))
                 {
					 echo 'Email='.$array['customerMail']; 
                     echo '<br>';
                     $emails[] = $array['customerMail'];  					 
				 }					 
				 
			}				 
		  }
	  }
	  // Pagination
	  $pagination     = extract_section($content,$start='<ul class="m-results-pagination">',$end='<li class="last">',0,0,0,"",0,0,0,0,0);	  
      $pagination     = str_replace('</li>','',str_replace('<li>','',str_replace('<li class="is-active">','',$pagination))); 
      $pagination_exp = explode('</a>',$pagination);
	  //print_r($pagination_exp); 
	  if(is_array($pagination_exp))
	  {   echo '<br>';
		  foreach($pagination_exp as $key => $val)
		  {
			 if($key!==10)
             {    
				  echo '<a href="?search='.str_replace(' ','-',$search).'&counter='.strip_tags($val).'">'.strip_tags($val).'</a>';
				  echo ' | ';
			 }				 
		  }
	  }
	  $pagination  = extract_section($pagination,$start='>',$end='<',0,0,0,"",0,0,0,0,0); 
   }
   //echo array2csv($emails);
   $_SESSION['emails'] = $emails;
 ?>
<script>
function copy_to_csv()
{
  var data = '<?php echo json_encode($emails);?>';
  alert(data);   
}
function popitup(url,windowName) {
       newwindow=window.open(url,windowName,'height=300,width=500');
       if (window.focus) {newwindow.focus()}
       return false;
     }
</script>