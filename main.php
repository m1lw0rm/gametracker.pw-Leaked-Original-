    <?php
	defined("access") or die("Nedozvoljen pristup");
	?>
    
	
		  <div class="section-title">
		  <h1> <i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo $lang['obavestenja']; ?> </h1>
		  <p><?php echo $lang['obavestenja_add']; ?></p>
		  </div>
		  
		  <div class="space10px"></div>
		  
	 <?php
	 $go = mysql_query("SELECT * FROM `acp_obavestenja` ORDER BY id DESC LIMIT 4");
	 while($g = mysql_fetch_array($go)){
		 $g_date = date("Y.m.d H:s", $g['time']);
		 $g_text = nl2br($g['text']);
		 
    if(strlen($g_text) > 200){ 
          $g_text = substr($g_text,0,200); 
          $g_text .= "..."; 
     }		 
	 ?>
		  <div class="col-md-6">
		  
		  <div class="panel -dark">
		  <div class="panel-heading"> <span class="panel-time pull-right"> <i class="fa fa-time"></i> <?php echo $g_date; ?> </span> <h4><i class="fa fa-star"></i> <?php echo $g['title']; ?> </h4></div>
          <div class="panel-body"> <?php echo $g_text; ?> </div>
		  </div>
		  
		  </div>	 
	 <?php
	 }
	 ?>


		  </div>
		  
		  <!-- statistika -->
		  <div class="row">

		  <div class="section-title-new">
		  <h2> <i class="fa fa-download"></i> Download </h2>
		  <p><?php echo $lang['cs_dl']; ?></p>
		  </div>

		  <div class="section-title-new">
		  <h2> <i class="fa fa-question"></i> API </h2>
		  <p><?php echo $lang['api_text']; ?> <a href='/api/index.php?ip=176.57.128.40:27056'>176.57.128.40:27056</a> </p>
		  </div>
		  
		  <div class="section-title-new">
		  <h2> <i class="fa fa-phone"></i> Mobilna verzija </h2>
		  <p><?php echo $lang['mobile_text']; ?> <a href='/m/'>link</a></p>
		  </div>
		  
		  </div>
		  
		  <div class="space10px"></div>
		  
          <div class="row">
		  
		  <div class="section-title">
		  <h1> <i class="fa fa-bars" aria-hidden="true"></i> <?php echo $lang['adm_statistika']; ?> </h1>
		  <p><?php echo $lang['stats_add']; ?>.</p>
		  </div>
		  
		  <div class="space10px"></div>
		  
		  <div class="stats-block"> 
		    <h1><?php echo $serversnum; ?></h1> <p><?php echo $lang['br_servera_z']; ?></p> 
			
			<ul>
			  <?php 
			  $serversqlast = mysql_query("SELECT * FROM `servers` WHERE last_update > '".date("Y-m-d", $vreme)."'ORDER BY id DESC LIMIT 5");
			  while($sf = mysql_fetch_array($serversqlast)){
				  
	          $naziv = $sf['hostname'];
              if(strlen($naziv) > 25){ 
                 $naziv = substr($naziv,0,25); 
                 $naziv .= "..."; 
              }
	 
				  echo "<a href='/server_info/$sf[ip]'> <li> <span>$naziv</span> <div class='space5px'></div> $sf[ip] </li> </a> ";
			  }
			  ?>
			</ul>
		  </div>
		  <div class="stats-block"> 
		    <h1><?php echo $communitiesnum; ?></h1> <p><?php echo $lang['br_comm_z']; ?></p> 
		  
			<ul>
			  <?php
			  $communitiesqlast = mysql_query("SELECT * FROM `community` ORDER BY id DESC LIMIT 5");
			  while($cf = mysql_fetch_array($communitiesqlast)){
				  echo "<a href='/community_info/$cf[id]'> <li> <span>$cf[naziv]</span> <div class='space5px'></div> $cf[forum] </li> </a>";
			  }
			  ?>
			</ul>
		  </div>
		  <div class="stats-block"> 
		    <h1><?php echo $usersnum; ?></h1> <p><?php echo $lang['br_users_z']; ?></p> 
			
			<ul>
			  <?php 
			  $usersqlast = mysql_query("SELECT * FROM `users` ORDER BY userid DESC LIMIT 5");
			  while($uf = mysql_fetch_array($usersqlast)){
				  $register_date = $uf['register_time'];
				  echo "<a href='/member/$uf[username]'> <li> <span>$uf[username]</span> <div class='space5px'></div> $register_date </li> </a>";
			  }
			  ?>
			</ul>
		  </div>
		  <div class="stats-block"> 
		    <h1><?php echo $playersnum; ?></h1> <p><?php echo $lang['br_players_z']; ?></p> 
			
			<ul>
			  <?php
			  $playersqlast = mysql_query("SELECT * FROM `players` ORDER BY id DESC LIMIT 5");
			  while($pf = mysql_fetch_array($playersqlast)){
				  echo "<a href='#'> <li> <span>$pf[nickname]</span> <div class='space5px'></div> Kills: <span>$pf[score]</span> </li> </a>";
			  }
			  ?>
			</ul>
		  </div>
		  
		  </div>