<?php
defined("access") or die("Nedozvoljen pristup");

$numcs = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cs16'"));
$numcson = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cs16' AND online='1'"));
$numcsoff = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cs16' AND online='0'"));

$numcss = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='css'"));
$numcsson = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='css' AND online='1'"));
$numcssoff = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='css' AND online='0'"));

$numcsgo = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='csgo'"));
$numcsgoon = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='csgo' AND online='1'"));
$numcsgooff = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='csgo' AND online='0'"));

$nummc = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='minecraft'"));
$nummcon = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='minecraft' AND online='1'"));
$nummcoff = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='minecraft' AND online='0'"));

$numsamp = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='samp'"));
$numsampon = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='samp' AND online='1'"));
$numsampoff = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='samp' AND online='0'"));

$numcod2 = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cod2'"));
$numcod2on = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cod2' AND online='1'"));
$numcod2off = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cod2' AND online='0'"));

$numcod4 = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cod4'"));
$numcod4on = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cod4' AND online='1'"));
$numcod4off = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='cod4' AND online='0'"));

$numtf2 = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='tf2'"));
$numtf2on = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='tf2' AND online='1'"));
$numtf2off = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='tf2' AND online='0'"));

$numts3 = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='teamspeak3'"));
$numts3on = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='teamspeak3' AND online='1'"));
$numts3off = mysql_num_rows(mysql_query("SELECT * FROM `servers` WHERE game='teamspeak3' AND online='0'"));
?>

		  <div class="section-title">
		  <h1> <i class="fa fa-gamepad" aria-hidden="true"></i> <?php echo $lang['igre']; ?> </h1>
		  <p><?php echo $lang['igre_add']; ?>.</p>
		  </div>
		  
		  <div class="space20px"></div>
		  
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/cs16"> Counter-Strike 1.6 </a> </div> <div class="center_stats"> <?php echo $numcs; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $numcson; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $numcsoff; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" src="/img/csheader.jpg"> <a href="/servers/cs16"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>	
		  
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/css"> Counter-Strike Source </a> </div> <div class="center_stats"> <?php echo $numcss; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $numcsson; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $numcssoff; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" src="/img/cssheader.jpg"> <a href="/servers/css"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>			  

		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/csgo"> Counter-Strike GO </a> </div> <div class="center_stats"> <?php echo $numcsgo; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $numcsgoon; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $numcsgooff; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" src="/img/csgoheader.jpg"> <a href="/servers/csgo"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>	
		  
		  
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/minecraft"> Minecraft </a> </div> <div class="center_stats"> <?php echo $nummc; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $nummcon; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $nummcoff; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" src="/img/mcheader.jpg"> <a href="/servers/minecraft"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>
		  
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/samp"> San Andreas MP </a> </div> <div class="center_stats"> <?php echo $numsamp; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $numsampon; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $numsampoff; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" src="/img/sampheader.jpg"> <a href="/servers/samp"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>
		  
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/cod2"> Call Of Duty 2 </a> </div> <div class="center_stats"> <?php echo $numcod2; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $numcod2on; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $numcod2off; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" src="/img/cod2header.jpg"> <a href="/servers/cod2"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>
		  
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/cod4"> Call Of Duty 4 </a> </div> <div class="center_stats"> <?php echo $numcod4; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $numcod4on; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $numcod4off; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" src="/img/cod4header.jpg"> <a href="/servers/cod4"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>
		  
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/tf2"> TeamFortress 2 </a> </div> <div class="center_stats"> <?php echo $numtf2; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $numtf2on; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $numtf2off; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" style="height:142px;" src="/img/tf2header.jpg"> <a href="/servers/tf2"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>
		  
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
          <div class="panel-body"> 
			 <div class="newgame-info"> <div class="center-gamename"> <a href="/servers/teamspeak3"> TeamSpeak 3 </a> </div> <div class="center_stats"> <?php echo $numts3; ?> <br /> <small> <?php echo $lang['br_servera_z']; ?> </small> </div> <div class="center_stats_add"> <label><?php echo $lang['games_o']; ?>:</label> <b><?php echo $numts3on; ?></b> </div> <div class="center_stats_add"> <label><?php echo $lang['games_off']; ?>:</label> <b><?php echo $numts3off; ?></b> </div>  </div>
   		     <div class="newgame-image"> <img class="newgame-styled" style="height:142px;" src="/img/ts3header.jpg"> <a href="/servers/teamspeak3"> <button class="games-open"> <i class="fa fa-link" aria-hidden="true"></i> </button> </a> </div>
		  </div>
		  </div>
		  
		  </div>