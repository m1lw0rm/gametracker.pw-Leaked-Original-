<?php
defined("access") or die("Nedozvoljen pristup");

// vazno
			include_once ('function.php');

        	$p_id = (int) (!isset($_GET["p"]) ? 1 : $_GET["p"]);
    	    $limit = 20;
    	    $startpoint = ($p_id * $limit) - $limit;
			
            //to make pagination
		    if($_GET['name']){
            $name = htmlspecialchars(addslashes(mysql_real_escape_string($_GET['name'])));
	        $statement = "`community` WHERE naziv LIKE '%$name%'";
	        } else if($_GET['author']){
			$statement = "`community` WHERE owner='$_GET[author]' ";	
			} else {
	        $statement = "`community`";
			}
?>

		  <div class="section-title">
		  <h1> <i class="fa fa-cog" aria-hidden="true"></i> <?php echo $lang['zajednice']; ?> </h1>
		  <p><?php echo $lang['zajednice_add']; ?>.</p>
		  </div>
		  
<div class="mirror">		  
<form method="post" class="form-m" action="/process.php?task=search_c">
    <div class="form-group">
	
    <label><?php echo $lang['ime_zajednice']; ?>:</label>
	<input type="search" value="<?php echo $_GET['name']; ?>" size="20" results="5" class="form-control" name="name">
	
	</div>

	<input type="submit" name="pretrazi" class="btn btn-success sendpwback" value="<?php echo $lang['pretrazi']; ?>">
</form>
</div>

<br />

	  <table class="morpht" style="width:100%">
	  <tr>
	  <th>Rank</th>
	  <th><?php echo $lang['ime_zajednice']; ?></th>
	  <th></th>
	  <th><?php echo $lang['vlasnik']; ?></th>
	  <th></th>
	  </tr>
	     <?php
		 $i = 0;
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY rank_pts DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
		 while($k = mysql_Fetch_array($s_q)){
		
         $i++;
		 
	$naziv = $k['naziv'];
    if(strlen($naziv) > 50){ 
          $naziv = substr($naziv,0,50); 
          $naziv .= "..."; 
     }
	 
 $sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `servers`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$k[id]}')";

 $tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 
 $sql_new = mysql_query("SELECT * FROM community_servers WHERE comid='{$k[id]}'");
 $sql_num = mysql_num_rows($sql_new);
 $broj_igraca = $tmp['suma_igraca'];
 $max_igraca = $tmp['max_igraca'];
 if($broj_igraca == ""){ $broj_igraca = "0"; } else {} 
 if($max_igraca == ""){ $max_igraca = "0"; } else {} 
 
 if(empty($k['max_slots'])){
	 $max_slots = $tmp['max_igraca'];
 } else {
	  $max_slots = $k['max_slots'];
 }
 
  $chart_url = "http://chart.apis.google.com/chart?chf=bg,s,044d00,0&chs=90x40&cht=ls&chco=FF7300&chds=0,$max_slots&chd=t:$k[playercount]&chls=1&chma=4,4,4,4";
	 	
 if($sql_num > 1){ echo "<tr> <td class='st_rank'>$i.</td> <td><a href='/community_info/$k[id]'>$naziv</a> <div class='space5px'></div> <small><a target='_blank' href='http://$k[forum]'>$k[forum]</a></small> </td> <td class='st_addest'> <label>$lang[br_servera_z123]</label> <span>$sql_num</span> <div class='space5px'></div>  <label>$lang[igraci_s]</label> <span>$broj_igraca/$max_slots</span> </td> <td><a href='/member/$k[owner]'>$k[owner]</a></td> <td class='st_rank'><img src='$chart_url'></td> </tr>"; } else { $i = $i-1; }
		 }
		 ?>
	   </table>
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>