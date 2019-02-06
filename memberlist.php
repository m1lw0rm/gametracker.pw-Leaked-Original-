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
	        $statement = "`users` WHERE username LIKE '%$name%'";
	        } else {
	        $statement = "`users`";
			}
?>

		  <div class="section-title">
		  <h1> <i class="fa fa-users" aria-hidden="true"></i> <?php echo $lang['korisnici']; ?> </h1>
		  <p><?php echo $lang['korisnici_add']; ?>.</p>
		  </div>
		  
<div class="mirror">		  
<form method="post" class="form-m" action="/process.php?task=search_u">
    <div class="form-group">
    <label><?php echo $lang['username']; ?>:</label>
	<input class="form-control" type="search" value="<?php echo $_GET['name']; ?>" size="20" results="5" name="name">
	</div>

	<input type="submit" name="pretrazi" class="btn btn-success sendpwback" value="<?php echo $lang['pretrazi']; ?>">
</form>
</div>

<div class="space15px"></div>

	     <?php
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY activity DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
		 while($k = mysql_Fetch_array($s_q)){
			 
		   $last_activity = time_ago($k['activity']);
		   if($last_activity == "45 years ago"){
			   $last_activity = "$lang[nema]";
		   }
		   
	$status = $k['activity'];
	$diff =  time() - $status;
	if($diff < 300){
	   $border = "<span style='color:green;'>Online</span>";
	} else { 
	   $border = "<span style='color:#780200;text-shadow:none'>Offline</span>";
	}	

if($k['hidemail'] == "on"){
	$email = "$lang[skriven_e]";
} else {
	$email = "$k[email]";
}	

			if($k['rank'] == "1"){
			    $rank = "<span style='color:#780200;text-shadow:none'>Admin</span>";
			} else if($k['rank'] == "2"){
				$rank = "<span style='color:yellow;'>Moderator</span>";
			} else if($k['rank'] == "4"){
				$rank = "<span style='color:black;text-decoration: line-through;'>Banned</span>";
			} else {
				$rank = "Member";
			}		   

                
				echo "
		  <div class='col-md-6'>
		  
		  <div class='panel -dark'>
          <div class='panel-body'> 
			 <div class='newuser-info'> <div class='center-gamename'> <a href='/member/$k[username]'> $k[username] </a> <br /> <div class='center_stats_add'> <b>$k[ime] $k[prezime]</b> </div>  </div> <div class='center_stats_add'> <label>Status:</label> $border </div>  <div class='center_stats_add'> <label>Rank:</label> $rank </div> </div> 

		     <img style='width:120px;height:120px;' class='memberlist-photo' src='/avatars/$k[avatar]'>
		  </div>
		  </div>
		  
		  </div>
				  ";
				  }
		 ?>
	   </table>
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>