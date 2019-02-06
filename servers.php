 <?php
defined("access") or die("Nedozvoljen pristup");

$g_name = addslashes($_GET['g_name']);
$vreme = time() + 60;

// vazno
			include_once ('function.php');

        	$p_id = (int) (!isset($_GET["p"]) ? 1 : $_GET["p"]);
    	    $limit = 20;
    	    $startpoint = ($p_id * $limit) - $limit;
			
            //to make pagination
		    if($_GET['hostname'] OR $_GET['ip'] OR $_GET['game'] OR $_GET['location'] OR $_GET['mod']){
			$hostname = htmlspecialchars(addslashes(mysql_real_escape_string($_GET['hostname'])));
			$ip = htmlspecialchars(addslashes(mysql_real_escape_string($_GET['ip'])));
			$game = htmlspecialchars(addslashes(mysql_real_escape_string($_GET['game'])));
			$location = htmlspecialchars(addslashes(mysql_real_escape_string($_GET['location'])));
			$mod = htmlspecialchars(addslashes(mysql_real_escape_string($_GET['mod'])));
			
	        $statement = "`servers` WHERE hostname LIKE '%$hostname%' AND ip LIKE '%$ip%' AND game LIKE '%$game%' AND location LIKE '%$location%' AND gamemod LIKE '%$mod%' AND last_update > '".date("Y-m-d", $vreme)."'";
	        } else if($_GET['addedby']){
			$addedby = addslashes($_GET['addedby']);
	        $statement = "`servers` WHERE added='$addedby' AND last_update > '".date("Y-m-d", $vreme)."'";
            } else if($_GET['ownedby']){
			$ownedby = addslashes($_GET['ownedby']);
	        $statement = "`servers` WHERE owner='$ownedby' AND last_update > '".date("Y-m-d", $vreme)."'";
            } else if($g_name == ""){
	        $statement = "`servers` WHERE last_update > '".date("Y-m-d", $vreme)."'";
            } else if($g_name == "cs16" OR $g_name == "css" OR $g_name == "csgo" OR $g_name == "minecraft" OR $g_name == "samp" OR $g_name == "cod2" OR $g_name == "cod4" OR $g_name == "tf2" OR $g_name == "teamspeak3"){
	           $statement = "`servers` WHERE game='$g_name' AND last_update > '".date("Y-m-d", $vreme)."'";
            } else {
	              die("<script> alert('Error'); document.location.href='/servers/'; </script>");
            }
?>


		  <div class="section-title">
		  <h1> <i class="fa fa-gamepad" aria-hidden="true"></i> <?php echo $lang['serveri']; ?> </h1>
		  <p><?php echo $lang['serveri_add']; ?>.</p>
		  </div>

<div class="mirror">		  
<form method="post" class="form-m" action="/process.php?task=search_s">
        
    <div class="col-md-6"> <div class="form-group">
    <label><?php echo $lang['ime_s']; ?>:</label>
	<input class="form-control" type="search" value="<?php echo $_GET['hostname']; ?>" size="20" results="5" name="hostname">
    </div> </div>
	
	
	<div class="col-md-6">
    <div class="form-group">
    <label>IP:</label>
	<input type="search" class="form-control" value="<?php echo $_GET['ip']; ?>" size="20" name="ip">
    </div>
	</div>
	    
    <div class="col-md-3"><div class="form-group">
	<label><?php echo $lang['igra']; ?>:</label>
	<select class="form-control" name="game" id="game">
	<option value="" > <?php echo $lang['sve']; ?> </option>
						<?php foreach ($gt_allowed_games as $gamefull => $gamesafe): ?>
						<option <?php if($gamesafe == $_GET['game'] OR $gamesafe == $g_name){ echo "selected"; } ?> value="<?php echo $gamesafe; ?>"><?php echo $gamefull; ?></option>
						<?php endforeach; ?>
	</select>
	</div></div>
	
<div class="col-md-3"><div class="form-group">
<label><?php echo $lang['lokacija']; ?>:</label>
					<select name="location" class="form-control" id="location">
					<option value="" > <?php echo $lang['sve']; ?> </option>
						<?php foreach ($gt_allowed_countries as $locationfull => $locationsafe): ?>
						<option <?php if($locationsafe == $_GET['location']){ echo "selected"; } ?> value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
						<?php endforeach; ?>
					</select>
					</div> </div>

 <div class="col-md-3">    <div class="form-group">
<label> <?php echo $lang['mod']; ?>: </label>
                 <select class="form-control" class="form-control" name="mod">
				 <option value="" > <?php echo $lang['sve']; ?> </option>
						  <optgroup label="Counter Strike 1.6">
                                    <option <?php if($_GET['mod'] == "PUB"){ echo "selected"; } ?> value="PUB" >Public</option>
                                    <option <?php if($_GET['mod'] == "DM"){ echo "selected"; } ?> value="DM" >DeathMatch</option>
                                    <option <?php if($_GET['mod'] == "DR"){ echo "selected"; } ?> value="DR" >DeathRun</option>
                                    <option <?php if($_GET['mod'] == "GG"){ echo "selected"; } ?> value="GG" >GunGame</option>
                                    <option <?php if($_GET['mod'] == "HNS"){ echo "selected"; } ?> value="HNS" >Hide 'n Seek</option>
                                    <option <?php if($_GET['mod'] == "KZ"){ echo "selected"; } ?> value="KZ" >KreedZ</option>
                                    <option <?php if($_GET['mod'] == "SJ"){ echo "selected"; } ?> value="SJ" >SoccerJam</option>
                                    <option <?php if($_GET['mod'] == "KA"){ echo "selected"; } ?> value="KA" >Knife Arena</option>
                                    <option <?php if($_GET['mod'] == "SH"){ echo "selected"; } ?> value="SH" >Super Hero</option>
                                    <option <?php if($_GET['mod'] == "SURF"){ echo "selected"; } ?> value="SURF" >Surf</option>
                                    <option <?php if($_GET['mod'] == "WC3"){ echo "selected"; } ?> value="WC3" >Warcraft3</option>
                                    <option <?php if($_GET['mod'] == "PB"){ echo "selected"; } ?> value="PB" >PaintBall</option>
                                    <option <?php if($_GET['mod'] == "ZM"){ echo "selected"; } ?> value="ZM" >Zombie mod</option>
                                    <option <?php if($_GET['mod'] == "ZMRK"){ echo "selected"; } ?> value="ZMRK" >Zmurka</option>
                                    <option <?php if($_GET['mod'] == "CTF"){ echo "selected"; } ?> value="CTF" >Capture the flag</option>
                                    <option <?php if($_GET['mod'] == "CW"){ echo "selected"; } ?> value="CW" >ClanWar</option>
                                    <option <?php if($_GET['mod'] == "OSTALO"){ echo "selected"; } ?> value="OSTALO" >Ostalo</option>
                                    <option <?php if($_GET['mod'] == "AWP"){ echo "selected"; } ?> value="AWP" >AWP</option>
                                    <option <?php if($_GET['mod'] == "DD2"){ echo "selected"; } ?> value="DD2" >de_dust2 only</option>
                                    <option <?php if($_GET['mod'] == "FUN"){ echo "selected"; } ?> value="FUN" >Fun, Fy, Aim</option>
                                    <option <?php if($_GET['mod'] == "COD"){ echo "selected"; } ?> value="COD" >CoD</option>
                                    <option <?php if($_GET['mod'] == "BB"){ echo "selected"; } ?> value="BB" >BaseBuilder</option>
                                    <option <?php if($_GET['mod'] == "JB"){ echo "selected"; } ?> value="JB" >JailBreak</option>
                                    <option <?php if($_GET['mod'] == "BF2"){ echo "selected"; } ?> value="BF2" >Battlefield2</option>
                            </optgroup>
                        <optgroup label="Counter Strike Source">
                                    <option <?php if($_GET['mod'] == "PUB"){ echo "selected"; } ?> value="PUB" >Public</option>
                                    <option <?php if($_GET['mod'] == "DM"){ echo "selected"; } ?> value="DM" >DeathMatch</option>
                                    <option <?php if($_GET['mod'] == "DR"){ echo "selected"; } ?> value="DR" >DeathRun</option>
                                    <option <?php if($_GET['mod'] == "GG"){ echo "selected"; } ?> value="GG" >GunGame</option>
                                    <option <?php if($_GET['mod'] == "ZM"){ echo "selected"; } ?> value="ZM" >Zombie Mod</option>
                                    <option <?php if($_GET['mod'] == "CW"){ echo "selected"; } ?> value="CW" >Clan War</option>
                            </optgroup>
                        <optgroup label="Call of Duty 2">
                                    <option <?php if($_GET['mod'] == "PAM"){ echo "selected"; } ?> value="PAM" >Pam mod</option>
                                    <option <?php if($_GET['mod'] == "PM4"){ echo "selected"; } ?> value="PM4" >Promod 4</option>
                                    <option <?php if($_GET['mod'] == "AWE"){ echo "selected"; } ?> value="AWE" >Additional War Effects</option>
                            </optgroup>
                        <optgroup label="Call of Duty 4">
                                    <option <?php if($_GET['mod'] == "PAM"){ echo "selected"; } ?> value="PAM" >Pam mod</option>
                                    <option <?php if($_GET['mod'] == "PM4"){ echo "selected"; } ?> value="PM4" >Promod 4</option>
                                    <option <?php if($_GET['mod'] == "BSF"){ echo "selected"; } ?> value="BSF" >Balkan Special Forces</option>
                                    <option <?php if($_GET['mod'] == "PROMODLIVE204"){ echo "selected"; } ?> value="PROMODLIVE204" >Promodlive204</option>
                                    <option <?php if($_GET['mod'] == "EXTREME2.6"){ echo "selected"; } ?> value="EXTREME2.6" >Extreme 2.6</option>
                                    <option <?php if($_GET['mod'] == "ROTU"){ echo "selected"; } ?> value="ROTU" >Reign of the undeath</option>
                         </optgroup>
						 <optgroup label="Ostalo">
						           <option <?php if($_GET['mod'] == "DEFAULT"){ echo "selected"; } ?> value="DEFAULT" >DEFAULT</option>
						 </optgroup>
					</select>
    </div>
	
	</div>

	<input type="submit" name="pretrazi" class="btn btn-success sendpwback" style="margin-left:25px;margin-top:22px" value="<?php echo $lang['pretrazi']; ?>">
		
</form>
</div>


<br />

	  <table class="morpht" style="width:100%">
	  <tr>
	  <th>Rank</th>
	  <th><?php echo $lang['ime_s']; ?></th>
	  <th></th>
	  <th></th>
	  <th><?php echo $lang['mapa']; ?></th>
	  <th></th>
	  </tr>
	     <?php
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY rank ASC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
		 $check_q = mysql_num_rows($s_q);
		 if($check_q < 1){ 
		   echo "<tr> <td> Nema rezultata </td> <td></td> <td> </td> <td> </td> <td></td> <td></td> </tr>";
		 
		 } else {
		 
		 while($k = mysql_Fetch_array($s_q)){
			
	$naziv = $k['hostname'];
    if(strlen($naziv) > 35){ 
          $naziv = substr($naziv,0,35); 
          $naziv .= "..."; 
     }
	 
	 if (file_exists("ime/maps/".$k['mapname'].".jpg")){ 
	 $mapimg = "<div class='st_mapimg'> <img style='width:45px;height:45px;border:solid 3px rgba(0,0,0,0.15)' src='/ime/maps/$k[mapname].jpg'> </div>"; 
	 } else {
	 $mapimg = "<div class='st_mapimg'> <img style='width:45px;height:45px;' src='/ime/mapbg.png'> </div>";	 
	 } 
	 
// online
$online = $k['online'];
if($online == "1"){
	$online = "<span class='badge-online pull-right'>ON</span>";
} else {
	$online = "<span class='badge-offline pull-right'>OFF</span>";
}
	 
	 $chart_url = "http://chart.apis.google.com/chart?chf=bg,s,044d00,0&chs=90x40&cht=ls&chco=FF7300&chds=0,$k[max_players]&chd=t:$k[playercount]&chls=1&chma=4,4,4,4";
	 
		   echo "<tr> <td class='st_rank'>$k[rank].</td> <td><a href='/server_info/$k[ip]' class='st_naziv'>$naziv</a> <div class='space5px'></div> <small>$k[ip]</small> $online </td> <td class='st_addest'> <label>$lang[igra]</label> <span><img style='width:15px;height:15px;' src='/ime/games/game-$k[game].png'> </span> <div class='space5px'></div> <label>$lang[igraci_s]</label> <span>$k[num_players]/$k[max_players]</span> </td> <td class='st_addest'>  <label>$lang[lokacija]</label> <span><img style='width:20px;height:15px;' src='/ime/flags/$k[location].png'> </span> <div class='space5px'></div> <label>$lang[mod]</label> <span>$k[gamemod]</span>  </td> <td>$mapimg</td> <td class='st_rank'><img src='$chart_url'></td> </tr>";
		 }
		 
		 }
		 ?>
	   </table>
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>