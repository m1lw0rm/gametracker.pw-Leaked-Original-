<?php
defined("access") or die("Nedozvoljen pristup");

$username			= addslashes($_GET['username']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$username'"));

if($info['username'] == ""){
die("<script> alert('$lang[korisniknepostoji]'); document.location.href='/'; </script>");
} else {
?>

		  <div class="section-title">
		  
		  <h1> <?php echo $info['username']; ?> </h1>
		  <p> <?php echo $info['email']; ?> </p>
		  </div>
<div class="row server-generalinfo">

			  <div class="brand_morph">GUESTBOOK <a class="btn btn-warning sibtn-new pull-right" style="color:#FFF;margin-top:-5px;" href="/member/<?php echo $info['username']; ?>"><?php echo $lang['nazad_naprofil']; ?></a></span> </div>

			  <div class="space10px"></div>
			  
         <?php
		 $p_f = mysql_query("SELECT * FROM profile_feed WHERE userid='$info[userid]' ORDER BY id DESC LIMIT 5");
		 if(mysql_num_rows($p_f) < 1){
			 
			 echo "<div class='si-bgshow pfff'>$lang[nema]</div>";
			 
		 } else {
		 while($p = mysql_fetch_array($p_f)){
			 $ainf = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$p[authorid]'"));
			 $before = time_ago($p['time']);
			 
			if($p['userid'] == $_COOKIE['userid']){
	        $delete = "<span style='float:right;'><a style='font-size:9px;' class='press' href='/process/feed_delete/$info[username]/$p[id]'>DELETE</a></span>";	 
	        }
			 
			 echo "
			 <div class='si-bgshow pfff'>
		<div class='st_mapimg' style='width:55px'>
			 <img style='width:40px;height:40px;' src='/avatars/$ainf[avatar]'>
	    </div>
		
			 <div class='profile_feed_look'>
			 <a href='/member/$p[author]'>$p[author]</a> $delete <div style='height:10px;'></div>
			 $p[message]  <span style='float:right'> <small>$before</small> </span>
			 </div>
			 </div> <div style='height:5px;'></div>";
		 }
			 
		 }
		 ?>
		 
		 <div class="space10px"></div>
		 
		 <?php
		 if(empty($_COOKIE['userid'])){} else {
		 ?>
		 <form action="/process.php?task=profile_feed" class="form-m" method="POST">
		 <textarea class="form-control" name="message" placeholder="Message" required="required"></textarea>
		 <input type="hidden" name="userid" value="<?php echo $info['userid']; ?>">
		 
		 <div class="space10px"></div>
		 
		 <button class="btn btn-success addnbtn"><?php echo $lang['posalji']; ?></button>
		 </form>
		 <?php } ?>
</div>
<?php } ?>