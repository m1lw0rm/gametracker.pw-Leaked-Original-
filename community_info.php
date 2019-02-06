<?php
$id = addslashes($_GET['id']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));

$br_srv = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
$broj_servera = mysql_num_rows($br_srv);

// Prosek
$players = $info['playercount'];
  
$niz24 = explode(',' , $players);

$suma = array_sum( $niz24 );

$prosek = round($suma / count( $niz24 ), 2);

if($info['id'] == ""){
    die("<script> alert('$lang[zajednicanepostoji].'); document.location.href='/'; </script>");
} else {

?>

<div class="row">

		  <div class="section-title">
		  
		  <h1> <?php echo $info['naziv']; ?> </h1>
		  <p> <?php echo $info['forum']; ?> </p>
		  </div>


		  <div class="row server-generalinfo">

		  <div class="col-md-7">
			  <div class="brand_morph"><?php echo $lang['opste_i']; ?></div>
			  
			  <div class="si-bgshow"> <label><?php echo $lang['ime_zajednice']; ?> </label> <div class="space5px"></div> <span><?php echo $info['naziv']; ?></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo $lang['sajt_forum']; ?> </label> <div class="space5px"></div> <span><a target="_blank" href="http://<?php echo $info['forum']; ?>"><?php echo $info['forum']; ?></a></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo $lang['vlasnik']; ?> </label> <div class="space5px"></div> <span><?php echo "<a href='/member/$info[owner]'>$info[owner]</a>"; ?></span> </div>  <div class="space10px"></div>
			
  			  <div class="si-bgshow"> <label><?php echo $lang['br_servera_z']; ?> </label> <div class="space5px"></div> <span><?php echo $broj_servera; ?></span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo $lang['ukupno_igraca_z']; ?> </label> <div class="space5px"></div> 
			  <span>
<?php
 $sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `servers`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$id}')";

 $tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 if(empty($info['maxslots'])){
	 $numtest = $tmp['max_igraca'];
 } else {
	 $numtest = $info['maxslots'];
 }
 echo "$tmp[suma_igraca]/$numtest";
 ?> 			  
			  </span> </div>  <div class="space10px"></div>
			  <div class="si-bgshow"> <label><?php echo $lang['o_zajednici']; ?> </label> <div class="space5px"></div> <span> <?php echo nl2br($info['opis']); ?> </span> </div>  <div class="space10px"></div>
			  
		  </div>
		  <div class="col-md-5">
			  <div class="brand_morph"><?php echo $lang['info_igraci']; ?></div>
			 
<?php
$chart_x_fields		= $info['chart_updates'];
$chart_x_replace	= "0,2,4,6,8,10,12,14,16,18,20,22,24";
$chart_x_max		= $numtest;
$chart_data			= $info['playercount'];
$chart_url          = "http://chart.apis.google.com/chart?chf=bg,s,044d00,18&chxl=0:$chart_x_fields&chxr=0,0,24|1,0,$chart_x_max&chxs=0,FF7300,13,0,lt|1,FF7300,13,1,lt&chxt=x,y&chs=280x170&cht=lc&chco=FF7300&chds=0,$chart_x_max&chd=t:$chart_data&chdlp=l&chg=0,-1,0,0&chls=1&chm=o,FF7300,0,-1,3";
?>

<center> <img class="server-cha" src="<?php echo $chart_url; ?>"> </center>
<div class="space15px"></div>

			  <div class="si-bgshow"> <label><?php echo $lang['prosek_24']; ?> </label> <div class="space5px"></div> <span><?php echo $prosek; ?></span> </div>  <div class="space10px"></div>
			  
<?php
if($info['owner'] == "$_COOKIE[username]"){
?>
			  <div class="space15px"></div>

  <a data-toggle="modal" href="#community_add"><button class='btn btn-success sibtn'><?php echo $lang['dodaj_server_uz']; ?></button></a>
  <a data-toggle="modal" href="#community_edit"><button class='btn btn-success sibtn'><?php echo $lang['izmeni_z']; ?></button></a>
  <br /><br />
  
<?php } else {} ?>


		  </div>
		  
		  </div>

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
$kte2 = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
$br_kt = mysql_num_rows($kte2);
 
 if($br_kt < 1){ 
   echo "<tr> <td>$lang[nema_servera_z]</td> <td></td> <td></td> <td></td> <td></td> <td></td> </tr>";
 } else {

$kte = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
while($te = mysql_fetch_array($kte)){
$res = mysql_query("SELECT * FROM servers WHERE id='$te[srvid]' ORDER BY rank_pts DESC");
		 $check_q = mysql_num_rows($res);
		 if($check_q < 1){ 
		   echo "<tr> <td> Nema rezultata </td> <td></td> <td> </td> <td> </td> <td></td> <td></td> </tr>";
		 
		 } else {
		 
		 while($k = mysql_Fetch_array($res)){
			
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
}
 
 }
  ?>
  </table>
  
</div>

<!-- Modals -->	
<?php
}

if($info['owner'] == "$_COOKIE[username]"){
?>
<div class="modal fade" id="community_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['dodaj_server_uz']; ?></h4>
      </div>
      <div class="modal-body">
  	<?php
	$mk = mysql_query("SELECT * FROM servers WHERE owner='$info[owner]' AND game='cs16'");
	$br1 = mysql_num_rows($mk);
	
	if($br1 < 1){
	echo "<div style='width:95%;color:#FFF;' class='nemap'>$lang[niste_vlasnik].</div>";
	} else {
	?>
	
    <table width="100%" class="morpht">
    <tr>
    <th>Rank</th>
    <th><?php echo $lang['ime_s']; ?></th>
    <th>Actions</th>
	<?php
	$kveri = mysql_query("SELECT * FROM servers WHERE owner='$info[owner]' ORDER by rank_pts DESC");
	while($k = mysql_fetch_array($kveri)){
	  $naziv = $k['hostname'];
      if(strlen($naziv) > 40){ 
          $naziv = substr($naziv,0,40); 
          $naziv .= "..."; 
	  }
	  echo "<tr> <td>$k[rank].</td> <td><a target='_blank' href='/server_info/$k[ip]'>$naziv</a></td>";
	  
	$tk = mysql_query("SELECT * FROM community_servers WHERE srvid='$k[id]'");
    $brtk = mysql_num_rows($tk);
    if($brtk > 0){
    ?>
	<td><a style='color:#FF0000;' href="/process.php?task=remove_comm&comid=<?php echo $id;  ?>&srvid=<?php echo $k['id']; ?>"><?php echo $lang['izbaci']; ?></a></td> </tr>
	<?php
    } else {	
	?>
	<td><a style='color:green;' href="/process.php?task=add_comm&comid=<?php echo $id;  ?>&srvid=<?php echo $k['id']; ?>"><?php echo $lang['ubaci']; ?></a></td> </tr>
	<?php
	}
	}
	?>
    </table>
	<?php } ?>
	
            </div>
			
            <div class="modal-footer">
             <button class="btn btn-primary sendpwback"><?php echo $lang['posalji']; ?></button>
            </div>
			
</div>	
</div>
</div>
</div>	


	

<div class="modal fade" id="community_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['izmeni_z']; ?></h4>
      </div>
      <div class="modal-body">
			
			<form action="/process.php?task=edit_community" class="form-m" method="POST">
			
            <div class="modal-body">
    <input class="form-control" type="text" name="naziv" value="<?php echo $info['naziv']; ?>" required="required"> <div style="height:10px;"></div>
	<input class="form-control" type="text" name="forum" value="<?php echo $info['forum']; ?>" required="required"> <div style="height:10px;"></div>
	<textarea name="opis" class="form-control" required="required"><?php echo $info['opis']; ?></textarea> <div style="height:10px;"></div>
	<input type="hidden" name="id" value="<?php echo $id; ?>">
            </div>
            <div class="modal-footer">
             <button class="btn btn-primary sendpwback"><?php echo $lang['posalji']; ?></button>
            </div>
			
			</form>
</div>	
</div>
</div>
</div>
<?php } else {} ?>	