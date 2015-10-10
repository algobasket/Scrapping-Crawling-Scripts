<?php
  $category = array('bailey blue');
  
  set_time_limit(0); 
  require 'scrap-function.php';
  $base_url = "http://www.xvideos.com/";
  $page = (@$_GET['p']) ? str_replace('"','',$_GET['p']) : 0; 
 
 /*
  foreach($category as $keywords){
        $content        =    content($keywords,$page,$base_url);  
		$get_paging     =    get_paging($content);
        foreach($get_paging as $r){
			//echo $r;
		};	
      echo '<br>';		
	  $get_scrap_data =    get_scrap_data($content);
  } 
  */
  
        $content        =    content_recent($page,$base_url);
        //print_r($content); 		
		$get_paging     =    get_paging($content);
        foreach($get_paging as $r){
			echo $r;
		};	
      echo '<br>';		
	  $get_scrap_data =    get_scrap_data_recent($content);
      print_r($get_scrap_data);
  
  
  function content($keywords,$flag,$base_url){
	  $search            = $keywords; 
	  $search_query_link = $base_url.'?k='.str_replace(' ','+',$search).'&p='.$flag; 
      $base_content      = curl_get_contents($search_query_link);
	  return $base_content;
  }
  
 
  
  function get_paging($base_content){
	  $paging            = extract_section($base_content,$start_node='<!-- PAGINATION -->',$end_node='<!-- END PAGINATION -->',0,0,0,"",0,0,0,0,0); 	  
      $paging            = str_replace('</ul>','',str_replace('<ul>','',$paging));
	  $paging            = str_replace('</div>','',str_replace('<div class="pagination small top">','',$paging));
	  $page_count        = explode('<li>',$paging);
	  //$count             =  count($page_count) - 2;
	  foreach($page_count as $key =>$value){
		  if($key!==0){
			 $data[] = str_replace('"/','xvideos.php',str_replace('</li>','',$value)); 
		  }
	  }
      return $data;  	  
  }
  
  
  function get_scrap_data($base_content){
	  global $base_url;
	  $section           = extract_section($base_content,$start_node='<!-- END PAGINATION -->',$end_node='<!-- #content -->',0,0,0,"",0,0,0,0,0); 
	  $array2 = explode('<div class="thumbBlock"',$section);
	  foreach($array2 as $key => $value){
		  if($key!==0){
	  $href1         = extract_section($value,$start_node='<div class="thumb">',$end_node='<p><a href="',0,0,0,"",0,0,0,0,0);
	  $href2         = extract_section($value,$start_node='<p><a href="',$end_node='</a></p>',0,0,0,"",0,0,0,0,0);
	  $redirect_link = extract_section($value,$start_node='<p><a href="',$end_node='" title="',0,0,0,"",0,0,0,0,0); 
	  $redirect_link_array = explode('/',$redirect_link);
	  $videoid       = str_replace('video','',$redirect_link_array[1]);
	  $redirect_link = $base_url.$redirect_link;
	  $title         = strip_tags($href2);
      $title         = explode('">',$title);
      $title         = $title[1];	  
	  $image_link    = extract_section($value,$start_node='<img src="',$end_node='" id="pic_',0,0,0,"",0,0,0,0,0);
	  $video_content = curl_get_contents($redirect_link);
	  $embed_section = extract_section($video_content,$start_node='<!-- PLAYER FLASH -->',$end_node='<!-- END PLAYER FLASH -->',0,0,0,"",0,0,0,0,0);
	  $tag_section   = extract_section($video_content,$start_node='<li><em>Tagged: </em></li>',$end_node='<li>more <a href="/tags/">',0,0,0,"",0,0,0,0,0);
	 
	  $scrap_array[] = array(
	     'title' => $title,
		 'link'  => $redirect_link,
		 'videoid' => $videoid,
		 'image' => $image_link,
		 'embed' => base64_encode($embed_section),
		 'tags'  => strip_tags($tag_section) 
	  );
	       
		  }
	
	  } 
	  return $scrap_array;
  }
  
  function content_recent($page,$base_url){
	  if($_GET['p']==null){
		  $url = $base_url;
	  }else{
		  $url = $base_url.'new/'.$_GET['p']; 
	  }
	  $base_content      = curl_get_contents($url);  
	  return $base_content;
  }
  
  function get_scrap_data_recent($base_content){
	 global $base_url;
	  $section           = extract_section($base_content,$start_node='<!-- END PAGINATION -->',$end_node='<!-- #content -->',0,0,0,"",0,0,0,0,0); 
	  $array2 = explode('<div class="thumbBlock"',$section);
	  foreach($array2 as $key => $value){
		  if($key!==0){
	  $href1         = extract_section($value,$start_node='<div class="thumb">',$end_node='<p><a href="',0,0,0,"",0,0,0,0,0);
	  $href2         = extract_section($value,$start_node='<p><a href="',$end_node='</a></p>',0,0,0,"",0,0,0,0,0);
	  $redirect_link = extract_section($value,$start_node='<p><a href="',$end_node='" title="',0,0,0,"",0,0,0,0,0); 
	  $redirect_link_array = explode('/',$redirect_link);
	  $videoid       = str_replace('video','',$redirect_link_array[1]);
	  $redirect_link = $base_url.$redirect_link;
	  $title         = strip_tags($href2);
      $title         = explode('">',$title);
      $title         = $title[1];	  
	  $image_link    = extract_section($value,$start_node='<img src="',$end_node='" id="pic_',0,0,0,"",0,0,0,0,0);
	  $video_content = curl_get_contents($redirect_link);
	  $embed_section = extract_section($video_content,$start_node='<!-- PLAYER FLASH -->',$end_node='<!-- END PLAYER FLASH -->',0,0,0,"",0,0,0,0,0);
	  $tag_section   = extract_section($video_content,$start_node='<li><em>Tagged: </em></li>',$end_node='<li>more <a href="/tags/">',0,0,0,"",0,0,0,0,0);
	 
	  $scrap_array[] = array(
	     'title' => $title,
		 'link'  => $redirect_link,
		 'videoid' => $videoid,
		 'image' => $image_link,
		 'embed' => base64_encode($embed_section),
		 'tags'  => strip_tags($tag_section) 
	  );
	       
		  }
	
	  } 
	  return $scrap_array;
 }
  
  function get_paging_recent($base_content){
	  $section           = extract_section($base_content,$start_node='<div class="pagination',$end_node='<!-- #content -->',0,0,0,"",0,0,0,0,0);
      $content           = extract_section($section,$start_node='<ul>',$end_node='</ul>',0,0,0,"",0,0,0,0,0);
  }
 
?>
