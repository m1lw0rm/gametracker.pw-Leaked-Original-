    <?php
	defined("access") or die("Nedozvoljen pristup");
	
	if($_COOKIE['userid'] == ""){
	   die("<script> alert('$lang[prijavitese]'); document.location.href='/login'; </script>");
	} else {
	?>
	
		  <div class="section-title">
		  <h1> <i class="fa fa-plus" aria-hidden="true"></i> <?php echo $lang['dodajserver']; ?> </h1>
		  <p><?php echo $lang['dodajserver_custom']; ?>.</p>
		  </div>
		  
		  
<form action="/process.php?task=add_server" class="form-m" method="POST">
  <div class="form-group">
    <label><?php echo $lang['igra']; ?></label>
                    <select class="form-control" name="game" id="game">
						<?php foreach ($gt_allowed_games as $gamefull => $gamesafe): ?>
						<option value="<?php echo $gamesafe; ?>"><?php echo $gamefull; ?></option>
						<?php endforeach; ?>
					</select>  
  </div>
  <div class="form-group">
  <label><?php echo $lang['lokacija']; ?></label>
<select class="form-control" name="location" id="location">
						<?php foreach ($gt_allowed_countries as $locationfull => $locationsafe): ?>
						<option value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
						<?php endforeach; ?>
					</select>
  </div>
  
  <div class="form-group">
  <label><?php echo $lang['mod']; ?></label>  
   <select class="form-control" name="mod">
						  <optgroup label="Counter Strike 1.6">
                                    <option value="PUB" >Public</option>
                                    <option value="DM" >DeathMatch</option>
                                    <option value="DR" >DeathRun</option>
                                    <option value="GG" >GunGame</option>
                                    <option value="HNS" >Hide 'n Seek</option>
                                    <option value="KZ" >KreedZ</option>
                                    <option value="SJ" >SoccerJam</option>
                                    <option value="KA" >Knife Arena</option>
                                    <option value="SH" >Super Hero</option>
                                    <option value="SURF" >Surf</option>
                                    <option value="WC3" >Warcraft3</option>
                                    <option value="PB" >PaintBall</option>
                                    <option value="ZM" >Zombie mod</option>
                                    <option value="ZMRK" >Zmurka</option>
                                    <option value="CTF" >Capture the flag</option>
                                    <option value="CW" >ClanWar</option>
                                    <option value="OSTALO" >Ostalo</option>
                                    <option value="AWP" >AWP</option>
                                    <option value="DD2" >de_dust2 only</option>
                                    <option value="FUN" >Fun, Fy, Aim</option>
                                    <option value="COD" >CoD</option>
                                    <option value="BB" >BaseBuilder</option>
                                    <option value="JB" >JailBreak</option>
                                    <option value="BF2" >Battlefield2</option>
                            </optgroup>
                        <optgroup label="Counter Strike Source">
                                    <option value="PUB" >Public</option>
                                    <option value="DM" >DeathMatch</option>
                                    <option value="DR" >DeathRun</option>
                                    <option value="GG" >GunGame</option>
                                    <option value="ZM" >Zombie Mod</option>
                                    <option value="CW" >Clan War</option>
                            </optgroup>
                        <optgroup label="Call of Duty 2">
                                    <option value="PAM" >Pam mod</option>
                                    <option value="PM4" >Promod 4</option>
                                    <option value="AWE" >Additional War Effects</option>
                            </optgroup>
                        <optgroup label="Call of Duty 4">
                                    <option value="PAM" >Pam mod</option>
                                    <option value="PM4" >Promod 4</option>
                                    <option value="BSF" >Balkan Special Forces</option>
                                    <option value="PROMODLIVE204" >Promodlive204</option>
                                    <option value="EXTREME2.6" >Extreme 2.6</option>
                                    <option value="ROTU" >Reign of the undeath</option>
                         </optgroup>
						 <optgroup label="Ostalo">
						           <option value="DEFAULT" >DEFAULT</option>
						 </optgroup>
					</select>
	</div>
  <div class="form-group">
  <label>IP</label>  
  <input type="text" class="form-control" class="decimal" name="ip" id="ip" placeholder="IP adresa" value="<?php echo htmlspecialchars($_POST['ip']); ?>" />
  </div>
  
  <div class="space"></div>
  
  <center> <button type="submit" id="blockButton" class="btn btn-success addnbtn"> <i class="fa fa-plus"></i> <?php echo $lang['dodajserver']; ?></button> </center>
</form>
		  
	<?php } ?>