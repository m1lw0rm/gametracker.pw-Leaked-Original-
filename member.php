<?php
defined("access") or die("Nedozvoljen pristup");

$username			=  htmlspecialchars($_GET['username'], ENT_QUOTES);

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$username'"));
$status = (time() - $info['activity']) < 300 ? '<font color="#27a600">Online</font>' : '<font color="red">Offline</font>';

$dodatih_s = mysql_num_rows(mysql_query("SELECT * FROM servers WHERE addedid='$info[userid]'"));
$vlasnik_s = mysql_num_rows(mysql_query("SELECT * FROM servers WHERE ownerid='$info[userid]'"));
$posete = mysql_num_rows(mysql_query("SELECT * FROM profile_visits WHERE userid='$info[userid]'"));
$zajednice = mysql_num_rows(mysql_query("SELECT * FROM community WHERE ownerid='$info[userid]'"));

$poslednja_aktivnost = time_ago($info['activity']);
if($poslednja_aktivnost == "45 years ago"){
	$poslednja_aktivnost = "$lang[nema]";
}

if($info['hidemail'] == "on"){
	$email = "$lang[skriven_e]";
} else {
	$email = "$info[email]";
}

			if($info['rank'] == "1"){
			    $rank = "<span style='color:red;'>Administrator</span>";
			} else if($info['rank'] == "2"){
				$rank = "<span style='color:yellow;'>Moderator</span>";
			} else if($info['rank'] == "4"){
				$rank = "<span style='color:black;text-decoration: line-through;'>Banned</span>";
			} else {
				$rank = "Member";
			}

if($info['username'] == ""){
die("<script> alert('$lang[korisniknepostoji]'); document.location.href='/'; </script>");
} else {

?>


		  <div class="section-title">
		  
<?php
if(empty($_COOKIE['userid'])){} else {
	
	if($info['userid'] == $_COOKIE['userid']){
?>	 
<div class="pull-right">
<a  data-toggle="modal" class="btn btn-success sibtn-new" href="#change-profile"><?php echo $lang['izmeni_profil']; ?></a>
<a  data-toggle="modal" class="btn btn-success sibtn-new" href="#change-avatar"><?php echo $lang['izmeni_avatar']; ?></a>
</div>
<?php
	} else {
?>
<div class="pull-right">

			  <?php
			  $kt = mysql_query("SELECT COUNT(*) AS nums,id,status FROM zahtevi WHERE od='$_COOKIE[userid]' AND za='$info[userid]' OR od='$info[userid]' AND za='$_COOKIE[userid]'");
			   while($fetch = mysql_fetch_array($kt)){
			     if($_COOKIE['userid'] == ""){} else {
				 if($fetch['nums'] == "0"){
                   echo "<a href='/friend/add/$info[userid]'> <button class='btn btn-success sibtn-new'> $lang[dodaj_prijatelja] </button> </a> ";
                 } else	if($fetch['nums'] == "1" && $fetch['status'] == "1"){
				   echo "<a href='/friend/decline/$fetch[id]'> <button class='btn btn-danger sibtn-new'>  $lang[izbrisi_iz_prijatelja] </button> </a>";
				 }
			  }
			   }
			  ?>

<a data-toggle="modal" href="#send-message" class="btn btn-default sibtn-new"><?php echo $lang['posalji_poruku']; ?></a>
</div>
<?php		
	}
	
} 
?>
		  
		  <h1> <?php echo $info['username']; ?> </h1>
		  <p> <?php echo $info['email']; ?> </p>
		  </div>
		  
		  
	 
<div class="row server-generalinfo">

     <div class="col-md-5">
		<div class="brand_morph"><?php echo $lang['p_slika']; ?></div>
		
		<div class="st_mapimg" style="width:215px">
		<img style="width:200px;height:200px;" src="/avatars/<?php echo $info['avatar']; ?>">		
	    </div>
		
		<div class="space15px"></div>
		
	    <div class="brand_morph">COMMUNITY</div>
			  <div class="si-bgshow"> <label><?php echo $lang['dodatih_s']; ?> </label> <div class="space5px"></div> <span><?php echo $dodatih_s; ?> <a href="/?page=servers&addedby=<?php echo $info['username']; ?>">[ <?php echo $lang['lista_m']; ?> ]</a></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo $lang['vlasnik_s']; ?> </label> <div class="space5px"></div> <span><?php echo $vlasnik_s; ?> <a href="/?page=servers&ownedby=<?php echo $info['username']; ?>">[ <?php echo $lang['lista_m']; ?> ]</a></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo $lang['zajednica_p']; ?> </label> <div class="space5px"></div> <span><?php echo $zajednice; ?> <a href="/?page=communities&author=<?php echo $info['username']; ?>">[ <?php echo $lang['lista_m']; ?> ]</a></span> </div>  <div class="space10px"></div>
		
	 </div>
	 
	 <div class="col-md-7">
			  <div class="brand_morph">USERINFO</div>
			  
			  <div class="si-bgshow"> <label><?php echo $lang['username']; ?> </label> <div class="space5px"></div> <span><?php echo $info['username']; ?></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo $lang['email']; ?> </label> <div class="space5px"></div> <span><?php echo $email; ?></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo "$lang[ime] $lang[prezime]"; ?> </label> <div class="space5px"></div> <span><?php echo "$info[ime] $info[prezime]"; ?></span> </div>  <div class="space10px"></div>
			
  			  <div class="si-bgshow"> <label><?php echo $lang['registrovan']; ?> </label> <div class="space5px"></div> <span><?php echo $info['register_time']; ?></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo $lang['poslednja_aktivnost']; ?> </label> <div class="space5px"></div> 	<span><?php echo $poslednja_aktivnost; ?></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label>Rank</label> <div class="space5px"></div> 	<span><?php echo $rank; ?></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label>Status</label> <div class="space5px"></div> 	<span><?php echo $status; ?></span> </div>  <div class="space10px"></div>
	 </div>
</div>
<div class="row graphstats">
  <div class="col-md-3">
   	  <div class="si-bgshow"> <label><?php echo $lang['p_posete']; ?> </label> <div class="space5px"></div> <span style="color:#FFF;font-weight:bold"><?php echo $posete; ?></span> </div>  <div class="space10px"></div>

	  <div class="space10px"></div>
	  
		   <?php
		   $zadnje_p = mysql_query("SELECT * FROM profile_visits WHERE userid='$info[userid]' ORDER BY id DESC LIMIT 25");
		   while($zadnje = mysql_fetch_array($zadnje_p)){
			   $slika_i = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$zadnje[visitorid]'"));
			   $time = time_ago($zadnje['time']);
			   echo " <a title='$slika_i[username] - $time' href='/member/$slika_i[username]'><img class='newgimg' style='width:40px;height:40px;' src='/avatars/$slika_i[avatar]'></a> ";
		   }
		   ?>
  </div>
  <div class="col-md-4">
	 <?php
	 $l_p = mysql_query("SELECT * FROM zahtevi WHERE status='1' AND od='$info[userid]' OR status='1' AND za='$info[userid]'");
	 ?>
	 <div class="si-bgshow"> <label><?php echo $lang['prijatelji']; ?></label> <div class="space5px"></div> <span style="color:#FFF;font-weight:bold"><?php echo mysql_num_rows($l_p); ?></span></div>
	 
	 <div class="space15px"></div>
	 <?php
	 if(mysql_num_rows($l_p) < 1){
		 echo "$lang[nema]";
	 } else {
	 $l_pp = mysql_query("SELECT * FROM zahtevi WHERE status='1' AND od='$info[userid]' OR status='1' AND za='$info[userid]' ORDER BY id DESC LIMIT 25");
	 while($l = mysql_fetch_array($l_pp)){
		 if($l['od'] == $info['userid']){
		 $ui = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$l[za]'"));
		 } else if($l['za'] == $info['userid']){
		 $ui = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$l[od]'"));	 
		 }
		 		 
		 echo " <a href='/member/$ui[username]'><img title='$ui[username]' class='newgimg' style='width:40px;height:40px;' src='/avatars/$ui[avatar]'></a>";
	 }	 
		 
	 }
	 ?>  
  </div>
  <div class="col-md-5">
			  <div class="brand_morph"><?php echo $lang['aktivnosti_m']; ?></div>
			  
		<?php
		 $p_l = mysql_query("SELECT * FROM profile_log WHERE userid='$info[userid]' ORDER BY time DESC LIMIT 6");
		 if(mysql_num_rows($p_l) < 1){
			 
			 echo "<div class='si-bgshow arrrr'>$lang[nema]</div>";
			 
		 } else {
		 while($pl = mysql_fetch_array($p_l)){
			 $time = time_ago($pl['time']);
			 $type = $pl['type'];
			 
			 if($type == "1"){
				 echo "<div class='si-bgshow arrrr'>$lang[korisnik] <a href='/member/$pl[var2]'>$pl[var2]</a> $lang[pl_profil] <a href='/member/$pl[var3]'>$pl[var3]</a> <br /> <small>$time</small></div> <div style='height:3px;'></div>";
			 } else if($type == "2"){
				  $server = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$pl[var3]'"));
				  	
		  $naziv = $server['hostname'];
          if(strlen($naziv) > 30){ 
          $naziv = substr($naziv,0,30); 
          $naziv .= "..."; 
          }
				  echo "<div class='si-bgshow arrrr'>$lang[korisnik] <a href='/member/$pl[var2]'>$pl[var2]</a> $lang[pl_server] <a href='/server_info/$server[ip]'> <img style='height:10px;' src='/ime/games/game-$server[game].png'> $naziv</a> <br /> <small>$time</small></div> <div style='height:3px;'></div>";
			 }
			 
		   }			 
		 }
		?>
  </div>
</div>
<div class="row server-generalinfo">
			  <div class="brand_morph">GUESTBOOK <a class="btn btn-warning sibtn-new pull-right" style="color:#FFF;margin-top:-5px;" href="/guestbook/<?php echo $info['username']; ?>"><?php echo $lang['pogledaj_vise']; ?></a></span> </div>

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
	
<!-- Posete -->
<?php
if(empty($_COOKIE['userid'])){} else {
	
if($_COOKIE['userid'] == $info['userid']){} else {
	
	$check = mysql_fetch_array(mysql_query("SELECT * FROM profile_visits WHERE userid='$info[userid]' ORDER BY id DESC LIMIT 1"));
	if($check['visitorid'] == $_COOKIE['userid']){} else {
	
	$time = time();
	mysql_query("INSERT INTO profile_visits (userid,username,visitorid,visitorname,time) VALUES ('$info[userid]','$info[username]','$_COOKIE[userid]','$_COOKIE[username]','$time')");
	
	}
	
}

}
?>

<?php } ?>


<!-- Modal -->
<?php
if(empty($_COOKIE['userid'])){} else {
?>

<div class="modal fade" id="send-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['posalji_poruku']; ?></h4>
      </div>
      <div class="modal-body">
			
	          <form action="/process.php?task=send_message" class="form-m" method="POST">
  
  <label><?php echo $lang['title_m']; ?>:</label>  <input class="form-control" type="text" name="title" required="required"> <br />
  <label><?php echo $lang['message_m']; ?>:</label> <textarea class="form-control"name="message" required="required" placeholder="<?php echo $lang['message_m']; ?>"></textarea> <br />
  <input type="hidden" name="userid" value="<?php echo $info['userid']; ?>">
  
			
            <div class="modal-footer">
             <button class="btn btn-success sendpwback"><?php echo $lang['posalji']; ?></button>
            </div>
			
		  </form>
		  
</div>
</div>
</div>
</div>

<?php	
}
?>

<?php if($_COOKIE['username'] == $username){ ?>
<div class="modal fade" id="change-avatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['izmeni_avatar']; ?></h4>
      </div>
      <div class="modal-body">
			
		
			
			
			<form class="form-m" action="/process.php?task=upload_avatar" method="POST" enctype="multipart/form-data">
			<input type="file" name="photoimg" required="required" id="photoimg" class="form-control"> <div style="height:5px;"></div>
			<small style="font-family:arial;font-size:10px;"><?php echo $lang['avatar_izmenite_sliku']; ?></small> <div style="height:15px;"></div>
			
			<?php
			$avatar_info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_COOKIE[userid]' "));
			?>
			<center>
			<div class="st_mapimg" style="width:165px">
			<img style="max-width:150px;max-height:150px;" src="/avatars/<?php echo $avatar_info['avatar']; ?>"> <br />
			</div>
			</center>
			
            <div class="modal-footer">
             <button class="btn btn-success sendpwback"><?php echo $lang['posalji']; ?></button>
            </div>
			
		  </form>
		  
</div>
</div>
</div>
</div>

<div class="modal fade" id="change-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['izmeni_profil']; ?></h4>
      </div>
      <div class="modal-body">
			<?php
			$user_infot = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$info[userid]' "));
			?>
				 <form action="/process.php?task=profil" class="form-m" method="POST">
	 
	 <input type="text" class="form-control" name="ime" value="<?php echo $user_infot['ime']; ?>" required="required"> <div style="height:5px;"></div>
	 <input type="text" class="form-control" name="prezime" value="<?php echo $user_infot['prezime']; ?>" required="required"> <div style="height:5px;"></div>
	 <input type="text" class="form-control" name="email" value="<?php echo $user_infot['email']; ?>" required="required"> <div style="height:15px;"></div>
	 <label><?php echo $lang['hidemail']; ?></label> <input <?php if($user_infot['hidemail'] == "on"){ echo "checked"; } ?> type="checkbox" name="hidemail"> <div style="height:18px;"></div>
	 <input type="password" class="form-control" name="oldpass" placeholder="<?php echo $lang['stara_lozinka']; ?>"> <div style="height:5px;"></div>
	 <input type="password" class="form-control" name="password" placeholder="<?php echo $lang['nova_lozinka']; ?>"> <div style="height:5px;"></div>
	 
			

            <div class="modal-footer">
             <button class="btn btn-success sendpwback"><?php echo $lang['posalji']; ?></button>
            </div>
			
		  </form>
		  
</div>
</div>
</div>
</div>

<?php } else {} ?>