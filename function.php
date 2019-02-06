<?php

/**
 * @link: http://www.Awcore.com/dev
 */ 
   function pagination($query, $per_page = 2,$p = 1){    
    	$query = "SELECT COUNT(*) as `num` FROM {$query}";
    	$row = mysql_fetch_array(mysql_query($query));
    	$total = $row['num'];
        $adjacents = "3"; 

    	$p = ($p == 0 ? 1 : $p);  
    	$start = ($p - 1) * $per_page;								
		
    	$prev = $p - 1;							
    	$next = $p + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
		
	  if($_GET['page'] == "servers" && $_GET['hostname'] OR $_GET['ip'] OR $_GET['game'] OR $_GET['location'] OR $_GET['mod']){
		  $hostname = addslashes($_GET['hostname']);
		  $ip = addslashes($_GET['ip']);
		  $game = addslashes($_GET['game']);
		  $location = addslashes($_GET['location']);
		  $mod = addslashes($_GET['mod']);
		  
		  $vtid = "/?page=servers&hostname=$hostname&ip=$ip&game=$game&location=$location&mod=$mod";
		} else if($_GET['page'] == "servers"){
		    if($_GET['addedby']){
            $id = addslashes($_GET['addedby']);
			$vtid = "/?page=servers&addedby=$id";				  
		    } else if($_GET['ownedby']){
			$id = addslashes($_GET['ownedby']);
			$vtid = "/?page=servers&ownedby=$id";				
			} else if($_GET['g_name']){
		    $id = addslashes($_GET['g_name']);
			$vtid = "/servers/$id";
			} else {
		    $vtid = "/?page=servers";
			}
		} else if($_GET['page'] == "communities"){
			$vtid = "/?page=communities";	
		} else if($_GET['page'] == "memberlist"){
			
			if($_GET['name']){ 
			$name = addslashes($_GET['name']);
			$vtid = "/?page=memberlist&name=$name";
			} else {
			$vtid = "/?page=memberlist";	
			}
			
		} else {
			die("404");
		}
		 
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    $pagination .= "";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $p)
    					$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='$vtid&p=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($p < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $p)
    						$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$vtid&p=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li><a href='$vtid&p=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$vtid&p=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $p && $p > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='$vtid&p=1'>1</a></li>";
    				$pagination.= "<li><a href='$vtid&p=2'>2</a></li>";
    				for ($counter = $p - $adjacents; $counter <= $p + $adjacents; $counter++)
    				{
    					if ($counter == $p)
    						$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$vtid&p=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li><a href='$vtid&p=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$vtid&p=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='$vtid&p=1'>1</a></li>";
    				$pagination.= "<li><a href='$vtid&p=2'>2</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $p)
    						$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$vtid&p=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($p < $counter - 1){ 
    			$pagination.= "<li><a href='$vtid&p=$next'>Next</a></li>";
                $pagination.= "<li><a href='$vtid&p=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    } 
?>    