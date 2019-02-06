<?php
defined("access") or die("Nedozvoljen pristup");

$ip			= addslashes($_GET['ip']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));

if($info['id'] == ""){
die("<script> alert('$lang[servernepostoji]'); document.location.href='/servers/'; </script>");
}

// igra
$igra = $info['game'];
if($igra == "cs16"){
	$igra = "Counter Strike 1.6";
} else if($igra == "css"){
	$igra = "Counter Strike Source";
} else if($igra == "csgo"){
	$igra = "Counter Strike Global Offensive";
} else if($igra == "cod2"){
	$igra = "Call Of Duty 2";
} else if($igra == "cod4"){
	$igra = "Call Of Duty 4";
} else if($igra == "minecraft"){
	$igra = "MineCraft";
} else if($igra == "samp"){
	$igra = "San Andreas Multiplayer";
} else if($igra == "tf2"){
	$igra = "Team Fortress 2";
} else if($igra == "teamspeak3"){
	$igra = "TeamSpeak 3";
}

// online
$online = $info['online'];
if($online == "1"){
	$online = "<span style='color:#00cc03'>Online</span>";
} else {
	$online = "<span style='color:#cc0014'>Offline</span>";
}

// Vlasnik
$owner = $info['owner'];
if($owner == ""){
  $owner = "$lang[nema] <a href='/process/ownership/$ip'>[ $lang[potvrdi_v] ]</a>";
} else {
  $owner = "<a href='/member/$info[owner]'>$info[owner]</a> <a href='/process/ownership/$ip'>[ $lang[potvrdi_v] ]</a>";
}

// Forum
$forum = $info['forum'];

if($forum == "Nema"){
  $forum = "$lang[nema]";
} else {
  $forum = "<a href='http://$forum' target='_blank'>$info[forum]</a>";
}

// Prosek
$players = $info['playercount'];
  
$niz24 = explode(',' , $players);

$niz1 = substr($players , 12);
$niz12 = explode(',' , $niz1);

$suma = array_sum( $niz24 );
$suma1 = array_sum( $niz12 );

$prosek = round($suma / count( $niz24 ), 2);
$prosek12 = round($suma1 / count( $niz12 ), 2);

// Naziv
$naziv = $info['hostname'];
  if(strlen($naziv) > 42){ 
          $naziv = substr($naziv,0,42); 
          $naziv .= "..."; 
     }
	 
	 
// mapimg
	 if (file_exists("ime/maps/".$info['mapname'].".jpg")){ 
	 $mapimg = "<img class='si_mapimg' src='/ime/maps/$info[mapname].jpg'>"; 
	 } else {
	 $mapimg = "<img class='si_mapimg' src='/ime/mapbg.png'>";	 
	 } 
	 
?>

		  <div class="section-title">
		  <div class="serverinfo-<?php echo $info['game']; ?>"></div>
		  
		  <div class="infod-first">
		  <h1> <?php echo $naziv; ?> </h1>
		  <p><img style='width:15px;height:15px;' src='/ime/games/game-<?php echo $info['game']; ?>.png'> <img style='width:15px;height:15px;' src='/ime/flags/<?php echo $info['location']; ?>.png'> <span class="mininfo-g"><?php echo $ip; ?></span> <small class="lastupdate pull-right"><?php echo $lang['poslednji_update']; ?>: <em><?php echo time_ago($info['last_update']); ?></em></small></p>
		  </div>
		  
		  </div>
		  
<?php
if($_GET['p'] == "banners"){
	$color = addslashes($_GET['color']);
	
	    $colors = array(
						'blue'				=> 'blue',
						'gray'			    => 'gray',
						'green' => 'green',
						'orange'         => 'orange',
						'red'           => 'red',
						'yellow'  => 'yellow',
	   );	
	   
	   if ( in_array ( $color , $colors ) ) {
?>
		  <div class="row server-generalinfo">
		  
   <a href="/server_info/<?php echo $ip; ?>"><button class="btn btn-primary"><?php echo $lang['back_serveri']; ?></button></a>
                          
					   <form class="pull-right">
					    <div class="form-group" style="width:150px">
                        <select class="form-control" name="color" onChange="window.location.href=this.value">
                            <option <?php if($color == "orange"){ echo "selected"; } ?> value="orange" ><?php echo $lang['c_orange']; ?></option>
							<option <?php if($color == "red"){ echo "selected"; } ?> value="red" ><?php echo $lang['c_red']; ?></option>
							<option <?php if($color == "green"){ echo "selected"; } ?> value="green" ><?php echo $lang['c_green']; ?></option>
							<option <?php if($color == "yellow"){ echo "selected"; } ?> value="yellow" ><?php echo $lang['c_yellow']; ?></option>
							<option <?php if($color == "gray"){ echo "selected"; } ?> value="gray" ><?php echo $lang['c_gray']; ?></option>
							<option <?php if($color == "blue"){ echo "selected"; } ?> value="blue" ><?php echo $lang['c_blue']; ?></option>
                        </select>
						</div>
					   </form>
						
	<div style="height:15px;"></div>

    <center>
             <div style="height:20px;"></div>
			
			 <img src="/banner_normal/<?php echo $ip; ?>/<?php echo $color; ?>">
			 
			 <div class="space10px"></div>
			 
               <textarea style="width:560px;" rows="1" class="form-control" onclick="this.select()" readonly="readonly"><a href="http://www.mygame.rs/server_info/<?php echo $ip; ?>" target="_blank"><img src="http://mygame.rs/banner_normal/<?php echo $ip; ?>/<?php echo $color; ?>" border="0"></a></textarea>
               <textarea style="width:560px;" rows="1" class="form-control" onclick="this.select()" readonly="readonly">[url=http://www.mygame.rs/server_info/<?php echo $ip; ?>][img]http://mygame.rs/banner_normal/<?php echo $ip; ?>/<?php echo $color; ?>[/img][/url]</textarea>
           
		     <div style="height:20px;"></div>
	
		     <div style="height:20px;"></div>
			 
			 <img src="/banner_medium/<?php echo $ip; ?>/<?php echo $color; ?>">
			 
			 			 <div class="space10px"></div>

               <textarea style="width:560px;" rows="1" class="form-control" onclick="this.select()" readonly="readonly"><a href="http://www.mygame.rs/server_info/<?php echo $ip; ?>" target="_blank"><img src="http://mygame.rs/banner_medium/<?php echo $ip; ?>/<?php echo $color; ?>" border="0"></a></textarea>
               <textarea style="width:560px;" rows="1" class="form-control" onclick="this.select()" readonly="readonly">[url=http://www.mygame.rs/server_info/<?php echo $ip; ?>][img]http://mygame.rs/banner_medium/<?php echo $ip; ?>/<?php echo $color; ?>[/img][/url]</textarea>
     			 
			 <div style="height:20px;"></div>
	
			 <img src="/banner_small/<?php echo $ip; ?>/<?php echo $color; ?>">
			 
			 			 <div class="space10px"></div>

               <textarea style="width:560px;" rows="1" class="form-control" onclick="this.select()" readonly="readonly"><a href="http://www.mygame.rs/server_info/<?php echo $ip; ?>" target="_blank"><img src="http://mygame.rs/banner_small/<?php echo $ip; ?>/<?php echo $color; ?>" border="0"></a></textarea>
               <textarea style="width:560px;" rows="1" class="form-control" onclick="this.select()" readonly="readonly">[url=http://www.mygame.rs/server_info/<?php echo $ip; ?>][img]http://mygame.rs/banner_small/<?php echo $ip; ?>/<?php echo $color; ?>[/img][/url]</textarea>			 
	
	</center>
	
</div>
<?php
	   } else {
             die("<script> alert('Error'); document.location.href='/server_info/$ip'; </script>");
	   }

} else {
?>
		  
 <div class="serv_sb">
 <div class="brand_morph">ShoutBox</div> 
   
  <?php
  $sm = mysql_query("SELECT * FROM shoutbox_s WHERE sid='$info[id]' ORDER BY id DESC LIMIT 8");
  if(mysql_num_rows($sm) < 1){
	  echo "<div class='message_shout'><span>$lang[nemarezultata]</span><br /></div>";
  } else {
	 while($s = mysql_fetch_array($sm)){
     $time = time_ago($s['time']);
	 if($info['ownerid'] == $_COOKIE['userid']){
	        $delete = "<span style='float:right;'><a href='/process/s_delete/$info[ip]/$s[id]'>[Delete]</a></span>";	 
	 }
	 
	 $s_user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$s[author]'"));
	 
	  echo " <div class='message_shout'>
	  <img style='float:left;width:30px;height:30px;' src='/avatars/$s_user[avatar]'>
	  <div style='text-align:left;margin-left:40px;padding:1px;'>
	  <a href='/member/$s[author]'>$s[author]</a> $delete <div style='height:5px;'></div>
	  <span>$s[message]</span>
	  <div style='height:5px;'></div>
	  <small>$time</small>
	  </div>
	  </div> ";	 
	 } 
	  
  }
  ?>
  
  
  <?php
	if(empty($user['userid'])){} else {
  ?>
            <br />
  			<form method="post" action="/process.php?task=shoutbox_s">
				<input name="message" class="form-control" type="text" required />
				<input type="hidden" value="<?php echo $info['id']; ?>" name="id">
				
				<div class="space10px"></div>
				
				<button type="submit" class="btn btn-primary btn-sm"> <?php echo $lang['posalji']; ?> </button>
			</form>
			<br />
  <?php } ?>
	 </div>
	 
		  
		  <div class="mirror-serverinfo"></div>		  
		  <div class="row server-generalinfo">

		  <div class="col-md-7">

			  <div class="brand_morph"><?php echo $lang['opste_i']; ?></div>

			  <div class="si-bgshow"> <label><?php echo $lang['igra']; ?> </label> <div class="space5px"></div> <span style="font-weight:bold"><?php echo $igra; ?></span> </div>  <div class="space10px"></div>
              <div class="si-bgshow"> <label><?php echo $lang['ime_s']; ?> </label> <div class="space5px"></div> <span><?php echo $info['hostname']; ?></span> </div> <div class="space10px"></div>
              <div class="si-bgshow"> <label><?php echo $lang['mod']; ?> </label> <div class="space5px"></div> <span><?php echo $info['gamemod']; ?></span> </div> <div class="space10px"></div>
              <div class="si-bgshow"> <label>Status </label> <div class="space5px"></div> <span><?php echo $online; ?></span> </div> <div class="space10px"></div>

              <div class="si-bgshow"> <label>IP </label> <div class="space5px"></div> <span><?php echo $info['ip']; ?></span> </div> <div class="space10px"></div>
              <div class="si-bgshow"> <label><?php echo $lang['dodao']; ?> </label> <div class="space5px"></div> <span><a href="/member/<?php echo $info['added']; ?>"><?php echo $info['added']; ?></a></span> </div> <div class="space10px"></div>
              <div class="si-bgshow"> <label><?php echo $lang['vlasnik']; ?> </label> <div class="space5px"></div> <span><?php echo $owner; ?></span> </div> <div class="space10px"></div>
              <div class="si-bgshow"> <label><?php echo $lang['forum']; ?> </label> <div class="space5px"></div> <span><?php echo $forum; ?></span> </div> <div class="space10px"></div>
			  
			  <div class="space20px"></div>
			 
  <div class="brand_morph"><?php echo $lang['server_banneri']; ?></div>
  
  <center>
  <a href="/server_banners/<?php echo $ip; ?>/green">
     <img src="/banner_normal/<?php echo $ip; ?>/green" style="max-width:600px"> <div style="height:15px;"></div>
	 <small style="text-transform:uppercase;"> <?php echo $lang['pogledaj_sve_b']; ?> </small>
  </a>
  
  <div class="space10px"></div>
  
  <div class="form-group">
               <textarea class="form-control" rows="1" onclick="this.select()" readonly="readonly"><a href="<?php echo $link; ?>/sserver_info/<?php echo $ip; ?>" target="_blank"><img src="<?php echo $link; ?>/banner_normal/<?php echo $ip; ?>/<?php echo $color; ?>" border="0"></a></textarea>
               <textarea class="form-control" rows="1" onclick="this.select()" readonly="readonly">[url=<?php echo $link; ?>/server_info/<?php echo $ip; ?>][img]<?php echo $link; ?>/banner_normal/<?php echo $ip; ?>/<?php echo $color; ?>[/img][/url]</textarea>
  </div>
  
  </center>

			</div>
			  
			<div class="col-md-5">
			  
              <div class="brand_morph"><?php echo $lang['mapa']; ?></div>
			   
			   <div class="space10px"></div>
			   
               <center class="map-center"><?php echo $mapimg; ?> <div class="mapname"><?php echo $info['mapname']; ?></div></center>	

               <div class="space10px"></div>

  <a href="/process/ownership/<?php echo $ip; ?>"><button class="btn btn-success sibtn"><img style="width:11px;height:11px;" src="/ime/neutral-dicision-16.png"> <?php echo $lang['potvrdi_v']; ?></button></a> <br />
  <a href="steam://connect/<?php echo $ip; ?>"><button class="btn btn-success sibtn"><img style="width:11px;height:11px;" src="/ime/steam-16.png"> Steam Connect</button></a>
  <?php if(empty($user['userid'])){} else if($info['ownerid'] == $user['userid']){ ?> <a data-toggle="modal" href="#edit-set"><button class="btn btn-success sibtn"><img style="width:11px;height:11px;" src="/ime/settings-4-16.png"> <?php echo $lang['izmeni_info']; ?></button></a> <?php } else {} ?>
  <?php if(empty($user['userid'])){} else { ?> <a data-toggle="modal" href="#server-report"><button class="btn btn-success sibtn"> <?php echo $lang['prijavi_server']; ?></button></a> <?php } ?>
	
  <div class="space10px"></div>
   
 <div class="brand_morph"><?php echo $lang['rank_servera_t']; ?></div>
  <?php
  if($info['rank'] == "99999"){
  ?>
  <div class="brand_text"><span>Rank:</span> <?php echo $lang['rank_zamrznut']; ?></div>
  <?php
  } else {
  ?>  
  <div class="si-bgshow"> <label>Rank</label> <div class="space5px"></div> <span><?php echo $info['rank']; ?></span> </div>  <div class="space10px"></div>
  <div class="si-bgshow"> <label><?php echo $lang['best_rank']; ?></label> <div class="space5px"></div> <span><?php echo $info['best_rank']; ?></span> </div>  <div class="space10px"></div>
  <div class="si-bgshow"> <label><?php echo $lang['worst_rank']; ?></label> <div class="space5px"></div> <span><?php echo $info['worst_rank']; ?></span> </div>  <div class="space10px"></div>	

  <?php } ?>
  
				<div class="space10px"></div>
  
  <div class="brand_morph"><?php echo $lang['info_igraci']; ?></div>

  <div class="si-bgshow"> <label><?php echo $lang['igraci_s']; ?></label> <div class="space5px"></div> <span><?php echo "$info[num_players]/$info[max_players]"; ?></span> </div>  <div class="space10px"></div>
  <div class="si-bgshow"> <label><?php echo $lang['prosek_12']; ?></label> <div class="space5px"></div> <span><?php echo $prosek12; ?></span> </div>  <div class="space10px"></div>
  <div class="si-bgshow"> <label><?php echo $lang['prosek_24']; ?></label> <div class="space5px"></div> <span><?php echo $prosek; ?></span> </div>  <div class="space10px"></div>
 
  
			</div>
		 
		  </div>
		
		
		
		  <!-- grafici -->
   		  <div class="row graphstats">
		  
<div>

  <center> <div class="brand_morph"><?php echo $lang['adm_statistika']; ?></div> </center>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#dnevni_graph" aria-controls="dnevni" role="tab" data-toggle="tab"><?php echo $lang['dnevni']; ?></a></li>
    <li role="presentation" ><a href="#nedeljni_graph" aria-controls="nedeljni" role="tab" data-toggle="tab"><?php echo $lang['nedeljni']; ?></a></li>
    <li role="presentation" ><a href="#mesecni_graph" aria-controls="mesecni" role="tab" data-toggle="tab"><?php echo $lang['mesecni']; ?></a></li>
    <li role="presentation" class="pull-right"><a href="#rank_servera" aria-controls="rank" role="tab" data-toggle="tab"><?php echo $lang['rank_servera_t']; ?></a></li>
    <li role="presentation" class="pull-right"><a href="#mape" aria-controls="mape" role="tab" data-toggle="tab"><?php echo $lang['maps_stats']; ?></a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="dnevni_graph">
<?php
$d_chart_x_fields		= $info['chart_updates'];
$d_chart_x_replace	= "0,2,4,6,8,10,12,14,16,18,20,22,24";
$d_chart_x_max		= $info['max_players'];
$d_chart_data			= $info['playercount'];
$d_chart_url          = "http://chart.apis.google.com/chart?chf=bg,s,044d00,18&chxl=0:$d_chart_x_fields&chxr=0,0,24|1,0,$d_chart_x_max&chxs=0,FF7300,18,0,lt|1,FF7300,18,1,lt&chxt=x,y&chs=1000x300&cht=lc&chco=FF7300&chds=0,$d_chart_x_max&chd=t:$d_chart_data&chdlp=l&chg=0,-1,0,0&chls=1&chm=o,FF7300,0,-1,8";
?>	

<center> <img class="server-cha" src="<?php echo $d_chart_url; ?>"> </center>
	</div>
    <div role="tabpanel" class="tab-pane fade" id="nedeljni_graph">
<?php
$w_chart_x_fields  = $info['chart_week'];
$w_chart_x_replace = "Mon,Tue,Wed,Thu,Fri,Sat,Sun";
$w_chart_x_max  = $info['max_players'];
$w_chart_data   = $info['playercount_week'];

$w_chart_url          = "http://chart.apis.google.com/chart?chf=bg,s,044d00,18&chxl=0:$w_chart_x_fields&chxr=0,0,24|1,0,$w_chart_x_max&chxs=0,FF7300,18,0,lt|1,FF7300,18,1,lt&chxt=x,y&chs=1000x300&cht=lc&chco=FF7300&chds=0,$w_chart_x_max&chd=t:$w_chart_data&chdlp=l&chg=0,-1,0,0&chls=1&chm=o,FF7300,0,-7,8";
?>	

<center> <img class="server-cha" src="<?php echo $w_chart_url; ?>"> </center>

	</div>
    <div role="tabpanel" class="tab-pane fade" id="mesecni_graph">
<?php
$m_chart_x_fields		= $info['chart_month'];
$m_chart_x_replace	= "";
$m_chart_x_max		= $info['max_players'];
$m_chart_data			= $info['playercount_month'];
$m_chart_url          = "http://chart.apis.google.com/chart?chf=bg,s,044d00,18&chxl=0:$m_chart_x_fields&chxr=0,0,24|1,0,$m_chart_x_max&chxs=0,FF7300,18,0,lt|1,FF7300,18,1,lt&chxt=x,y&chs=1000x300&cht=lc&chco=FF7300&chds=0,$m_chart_x_max&chd=t:$m_chart_data&chdlp=l&chg=0,-1,0,0&chls=1&chm=o,FF7300,0,-15,8";
?>	

<center> <img class="server-cha" src="<?php echo $m_chart_url; ?>"> </center>

	</div>
    <div role="tabpanel" class="tab-pane fade" id="rank_servera">
<?php
$r_chart_x_fields		= $info['rank_chart_updates'];
$r_chart_x_replace	= "";
$r_chart_x_max		= $info['worst_rank'];
$r_chart_data			= $info['rank_chart_count'];

$r_chart_url          = "http://chart.apis.google.com/chart?chf=bg,s,044d00,18&chxl=0:$r_chart_x_fields&chxr=0,0,24|1,0,$r_chart_x_max&chxs=0,FF7300,18,0,lt|1,FF7300,18,1,lt&chxt=x,y&chs=1000x300&cht=lc&chco=FF7300&chds=0,$r_chart_x_max&chd=t:$r_chart_data&chdlp=l&chg=0,-1,0,0&chls=1&chm=o,FF7300,0,-8,8";
?>

<center> <img class="server-cha" src="<?php echo $r_chart_url; ?>"> </center>

	</div>
    <div role="tabpanel" class="tab-pane fade" id="mape">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		['mape', 'br'],
		<?php
		$q = mysql_query("SELECT * FROM maps WHERE sid='$info[id]' ORDER BY num DESC LIMIT 7");
		while($m = mysql_fetch_array($q)){
		?>
		['<?php echo $m['name']; ?>', <?php echo $m['num']; ?>],
		<?php } ?>]);

        var options = {
          pieHole: 0.4,
		  backgroundColor: 'transparent',
		  pieSliceBorderColor: '#292929',
		  titleTextStyle: { color: '#FFF' },
		  tooltip: {textStyle: {color: '#000000'}, showColorCode: true},
		  legend: {textStyle: {color: '#FFFFFF', fontSize: 10}},
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

      <center> <div id="donutchart"></div> </center>
	</div>
  </div>

</div>

		  </div>
		  
		  
<!-- igraci -->
		  <div style="padding:0px" class="row server-generalinfo">
		  
		  <div class="space15px"></div>
		     <div class="brand_morph" style="margin-left:20px"> ONLINE <?php echo $lang['igraci_s']; ?> </div>
		  
			 <div class="space15px"></div>
			 

<?php
 $nk = mysql_query("SELECT * FROM players WHERE sid='$info[id]'");
 $pbr = mysql_num_rows($nk);

 if($pbr < 1){ 
   echo "<div class='noplayers'>$lang[nema_igraca]</div>";
 } else {
?>
	  <table class="table-striped" style="width:100%">
	  <tr>
	  <th style="width:100px">ID</th>
	  <th></th>
	  <th><?php echo $lang['ubistva']; ?></th>
	  </tr>
<?php
 $rand_id = 0;
 $p_q = mysql_query("SELECT * FROM players WHERE sid='$info[id]'");
 while($p = mysql_fetch_array($p_q)){ 
   $playertime = gmdate("H:i:s", $p[time_online]%86400);
   $rand_id++;
   
   echo "<tr> <td> <div class='playerid' style='height:100%'> <b>$rand_id.</b> </div> </td> <td><span class='badge bplayers'>$lang[nick]</span> <b class='playersnick'>$p[nickname]</b> <div class='space5px'></div> <span class='badge bplayers'>$lang[vreme]</span> <small class='playerstime'>$playertime</small> </td> <td class='st_rank'>$p[score]</td> </tr>";
 }
 
 }
  ?>
  </table>
  
		  </div>

<?php
}

if(empty($user['userid'])){} else {
?>
<div class="modal fade" id="server-report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['prijavi_server']; ?></h4>
      </div>
      <div class="modal-body">
			
			<form action="/process.php?task=prijavi_server" class="form-m" method="POST">
			
            <div class="modal-body">

<div class="form-group">			
<label><?php echo $lang['razlog_prijave']; ?>:</label>
<select name="razlog" class="form-control">
<option value="botovi">Botovi</option>
<option value="afk igraci">AFK igraci</option>
<option value="gamemenu">Nedozvoljen gamemenu changer</option>
<option value="ostalo">Ostalo</option>
</select>
</div>

<div class="space15px"></div>

<div class="form-group">			
<label><?php echo $lang['napomena']; ?>:</label>
<textarea class="form-control" rows="3" required="required" cols="30" name="comment"></textarea>	
</div>

<input type="hidden" name="sid" value="<?php echo $info['id']; ?>">
			  
            </div>
            <div class="modal-footer">
             <button class="btn btn-primary sendpwback"><?php echo $lang['posalji']; ?></button>
            </div>
			
			</form>
    </div>
  </div>
</div>	
</div>
<?php
}
?>

<?php
if(empty($user['userid'])) {} else if($info['ownerid'] == $user['userid']){
?>
<div class="modal fade" id="edit-set" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['izmeni_info']; ?></h4>
      </div>
      <div class="modal-body">
			
			<form action="/process.php?task=edit_server" class="form-m" method="POST">
			
            <div class="modal-body">
			

    <label><?php echo $lang['forum']; ?>:</label>
	<input class="form-control" type="text" value="<?php echo $info['forum']; ?>" placeholder="www.link.com" size="20" name="forum">
	
	<div class="space15px"></div>

	<select name="game" class="form-control" id="game" style="display:none">
	<option value="" > <?php echo $lang['sve']; ?> </option>
						<?php foreach ($gt_allowed_games as $gamefull => $gamesafe): ?>
						<option <?php if($gamesafe == $info['game']){ echo "selected"; } ?> value="<?php echo $gamesafe; ?>"><?php echo $gamefull; ?></option>
						<?php endforeach; ?>
	</select>
	
	<div class="space15px"></div>
	
                    <label><?php echo $lang['lokacija']; ?>:</label>
					<select name="location" class="form-control" id="location">
					<option value="" > <?php echo $lang['sve']; ?> </option>
						<?php foreach ($gt_allowed_countries as $locationfull => $locationsafe): ?>
						<option <?php if($locationsafe == $info['location']){ echo "selected"; } ?> value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
						<?php endforeach; ?>
					</select>
					
	<div class="space15px"></div>

                 <label><?php echo $lang['mod']; ?>:</label>
                 <select class="form-control" name="mod">
				 <option value="" > <?php echo $lang['sve']; ?> </option>
				 <?php if($info['game'] == "cs16"){ ?>
						  <optgroup label="Counter Strike 1.6">
                                    <option <?php if($info['gamemod'] == "PUB"){ echo "selected"; } ?> value="PUB" >Public</option>
                                    <option <?php if($info['gamemod'] == "DM"){ echo "selected"; } ?> value="DM" >DeathMatch</option>
                                    <option <?php if($info['gamemod'] == "DR"){ echo "selected"; } ?> value="DR" >DeathRun</option>
                                    <option <?php if($info['gamemod'] == "GG"){ echo "selected"; } ?> value="GG" >GunGame</option>
                                    <option <?php if($info['gamemod'] == "HNS"){ echo "selected"; } ?> value="HNS" >Hide 'n Seek</option>
                                    <option <?php if($info['gamemod'] == "KZ"){ echo "selected"; } ?> value="KZ" >KreedZ</option>
                                    <option <?php if($info['gamemod'] == "SJ"){ echo "selected"; } ?> value="SJ" >SoccerJam</option>
                                    <option <?php if($info['gamemod'] == "KA"){ echo "selected"; } ?> value="KA" >Knife Arena</option>
                                    <option <?php if($info['gamemod'] == "SH"){ echo "selected"; } ?> value="SH" >Super Hero</option>
                                    <option <?php if($info['gamemod'] == "SURF"){ echo "selected"; } ?> value="SURF" >Surf</option>
                                    <option <?php if($info['gamemod'] == "WC3"){ echo "selected"; } ?> value="WC3" >Warcraft3</option>
                                    <option <?php if($info['gamemod'] == "PB"){ echo "selected"; } ?> value="PB" >PaintBall</option>
                                    <option <?php if($info['gamemod'] == "ZM"){ echo "selected"; } ?> value="ZM" >Zombie mod</option>
                                    <option <?php if($info['gamemod'] == "ZMRK"){ echo "selected"; } ?> value="ZMRK" >Zmurka</option>
                                    <option <?php if($info['gamemod'] == "CTF"){ echo "selected"; } ?> value="CTF" >Capture the flag</option>
                                    <option <?php if($info['gamemod'] == "CW"){ echo "selected"; } ?> value="CW" >ClanWar</option>
                                    <option <?php if($info['gamemod'] == "OSTALO"){ echo "selected"; } ?> value="OSTALO" >Ostalo</option>
                                    <option <?php if($info['gamemod'] == "AWP"){ echo "selected"; } ?> value="AWP" >AWP</option>
                                    <option <?php if($info['gamemod'] == "DD2"){ echo "selected"; } ?> value="DD2" >de_dust2 only</option>
                                    <option <?php if($info['gamemod'] == "FUN"){ echo "selected"; } ?> value="FUN" >Fun, Fy, Aim</option>
                                    <option <?php if($info['gamemod'] == "COD"){ echo "selected"; } ?> value="COD" >CoD</option>
                                    <option <?php if($info['gamemod'] == "BB"){ echo "selected"; } ?> value="BB" >BaseBuilder</option>
                                    <option <?php if($info['gamemod'] == "JB"){ echo "selected"; } ?> value="JB" >JailBreak</option>
                                    <option <?php if($info['gamemod'] == "BF2"){ echo "selected"; } ?> value="BF2" >Battlefield2</option>
                            </optgroup>
				 <?php } else if($info['game'] == "css"){ ?>
                        <optgroup label="Counter Strike Source">
                                    <option <?php if($info['gamemod'] == "PUB"){ echo "selected"; } ?> value="PUB" >Public</option>
                                    <option <?php if($info['gamemod'] == "DM"){ echo "selected"; } ?> value="DM" >DeathMatch</option>
                                    <option <?php if($info['gamemod'] == "DR"){ echo "selected"; } ?> value="DR" >DeathRun</option>
                                    <option <?php if($info['gamemod'] == "GG"){ echo "selected"; } ?> value="GG" >GunGame</option>
                                    <option <?php if($info['gamemod'] == "ZM"){ echo "selected"; } ?> value="ZM" >Zombie Mod</option>
                                    <option <?php if($info['gamemod'] == "CW"){ echo "selected"; } ?> value="CW" >Clan War</option>
                            </optgroup>
				  <?php } else if($info['game'] == "cod2"){ ?>
                        <optgroup label="Call of Duty 2">
                                    <option <?php if($info['gamemod'] == "PAM"){ echo "selected"; } ?> value="PAM" >Pam mod</option>
                                    <option <?php if($info['gamemod'] == "PM4"){ echo "selected"; } ?> value="PM4" >Promod 4</option>
                                    <option <?php if($info['gamemod'] == "AWE"){ echo "selected"; } ?> value="AWE" >Additional War Effects</option>
                            </optgroup>
					 <?php } else if($info['game'] == "cod4"){ ?>
                        <optgroup label="Call of Duty 4">
                                    <option <?php if($info['gamemod'] == "PAM"){ echo "selected"; } ?> value="PAM" >Pam mod</option>
                                    <option <?php if($info['gamemod'] == "PM4"){ echo "selected"; } ?> value="PM4" >Promod 4</option>
                                    <option <?php if($info['gamemod'] == "BSF"){ echo "selected"; } ?> value="BSF" >Balkan Special Forces</option>
                                    <option <?php if($info['gamemod'] == "PROMODLIVE204"){ echo "selected"; } ?> value="PROMODLIVE204" >Promodlive204</option>
                                    <option <?php if($info['gamemod'] == "EXTREME2.6"){ echo "selected"; } ?> value="EXTREME2.6" >Extreme 2.6</option>
                                    <option <?php if($info['gamemod'] == "ROTU"){ echo "selected"; } ?> value="ROTU" >Reign of the undeath</option>
                         </optgroup>
					 <?php } else if($info['game'] == "samp" OR $info['game'] == "tf2" OR $info['game'] == "csgo" OR $info['game'] == "minecraft" OR $info['game'] == "teamspeak3"){ ?>
						 <optgroup label="Ostalo">
						           <option <?php if($info['gamemod'] == "DEFAULT"){ echo "selected"; } ?> value="DEFAULT" >DEFAULT</option>
						 </optgroup>
					 <?php } ?>
					</select>         

                    <input type="hidden" name="sid" value="<?php echo $info['id']; ?>">					
			  
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