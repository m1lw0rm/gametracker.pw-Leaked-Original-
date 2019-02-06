    <?php
	defined("access") or die("Nedozvoljen pristup");
	
	if($_GET['p'] == ""){
		die("<script> alert('Error'); document.location.href='/'; </script>");
	}
	
	if($_COOKIE['userid'] == ""){
	die("<script> alert('$lang[prijavitese]'); document.location.href='/'; </script>");
	} else {
		
	if(addslashes($_GET['p'] == "zahtevi")){
                 $shortdesc = "$lang[zahtevi]";
	} else if(addslashes($_GET['p'] == "poruke")){
                 $shortdesc = "$lang[inbox]";
		
    } else if(addslashes($_GET['p'] == "obavestenja")){ 
                 $shortdesc = "$lang[obavestenja]";
	
    }	
	?>
	
		  <div class="section-title">
		  
		  <h1> USERPANEL <a class="btn btn-warning sibtn-new pull-right" style="color:#FFF;margin-top:10px;margin-left:5px;" href="/panel/obavestenja"><?php echo $lang['obavestenja']; ?></a> <a class="btn btn-warning sibtn-new pull-right" style="color:#FFF;margin-top:10px;margin-left:5px;" href="/panel/poruke"><?php echo $lang['inbox']; ?></a> <a class="btn btn-warning sibtn-new pull-right" style="color:#FFF;margin-top:10px;margin-left:10px;" href="/panel/zahtevi"><?php echo $lang['zahtevi']; ?></a> </h1>
		  <p> <?php echo $shortdesc; ?> </p>
		  </div>
		  
          <div class="row server-generalinfo">
		    <?php
	if(addslashes($_GET['p'] == "zahtevi")){
            ?>
			
             <?php
			   $z_q = mysql_query("SELECT * FROM zahtevi WHERE za='$_COOKIE[userid]' AND status='0' ORDER BY time DESC LIMIT 10");
			   if(mysql_num_rows($z_q) < 1){
				   
				   echo "<div class='si-bgshow pfff'>$lang[nema]</div>";
				   
			   } else {
			   while($z = mysql_fetch_array($z_q)){
               $od = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$z[od]'"));
			       $time = time_ago($z['time']);
				   echo "				   
				   <div class='si-bgshow pfff'>
				   <span style='float:right;'>
				     <a href='/friend/accept/$z[id]'><button class='btn btn-successs sibtn-new'>$lang[prihvati_z]</button></a> <div style='height:3px;'></div>
					 <a href='/friend/decline/$z[id]'><button class='btn btn-danger sibtn-new'>$lang[odbij_z]</button></a>
				   </span>
				   
				   
				   <img style='width:50px;height:50px;' src='/avatars/$od[avatar]'>
				   <div class='zahtevi_look'>
				   <a href='/member/$od[username]'>$od[username]</a> <div style='height:5px;'></div> <em>$od[ime] $od[prezime]</em> <div style='height:3px;'></div> <small>$time</small>
				   </div>
				   
				   <div style='height:5px;'></div>
				   </div>
				   
				   <div style='height:5px;'></div>
				   ";
			   }
				   
			   }
			   ?>			
			
			<?php
	} else if($_GET['page'] == "panel" && $_GET['p'] == "poruke" && $_GET['id']){
		$id = addslashes($_GET['id']);
		
		$info = mysql_fetch_array(mysql_query("SELECT * FROM poruke WHERE id='$id'"));
		
		if($info['id'] == ""){
			die("<script> alert('$lang[poruka_nepostoji]'); document.location.href='/panel/poruke'; </script>");
		}
		
			$check = mysql_num_rows(mysql_query("SELECT * FROM poruke WHERE za='$_COOKIE[userid]' OR od='$_COOKIE[userid]' AND id='$id'"));
			if($check < 1){
			  die("<script> alert('Error'); document.location.href='/panel/poruke'; </script>");	
			} else {
			     $od = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$info[od]'"));
				 $za = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$info[za]'"));
				 $time = time_ago($info['time']);
				 
					 echo "
					 <a href='/panel/poruke'><button class='btn btn-warning sibtn-new'>$lang[nazad_na_poruke]</button></a> <div style='height:10px;'></div>
					 
					 <div class='si-bgshow pfff'>
					 <img style='width:50px;height:50px;' src='/avatars/$od[avatar]'>
				     <div class='zahtevi_look'>
				     <a href='/member/$od[username]'>$od[username]</a> > <a href='/member/$za[username]'>$za[username]</a>  <span style='float:right;'><small>$time</small></span> <div style='height:5px;'></div> <em>$info[title]</em> <div style='height:5px;'></div> <small>$info[message]</small> <div style='height:3px;'></div>
				     </div>
					 </div>
					 
					 <div style='height:5px;'></div>
					 ";
					 
	  $mc = mysql_query("SELECT * FROM messages_answers WHERE mid='$id' ORDER BY time ASC");
	  while($c = mysql_fetch_array($mc)){
	  
			$user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$c[authorid]'"));
			
	        $message = nl2br($c['message']);
			
			$time = time_ago($c['time']);
			
	    echo "
			  <div class='si-bgshow pfff'>
			  <img style='width:50px;height:50px;' src='/avatars/$user[avatar]'>
			  <div class='zahtevi_look'>
			    <a href='/member/$user[username]'>$user[username]</a> <div style='height:10px;'></div> $message  <div style='height:10px;'></div> <small>$time.</small></span>
			  </div>
              </div> <div style='height:5px;'></div>
		";
	    }

            ?>			
	  
	  		 <form class="form-m" action="/process.php?task=answer_m" method="POST">
			 <textarea name="message" class="form-control" rows="1" onclick="this.rows = '3';" required="required" placeholder="<?php echo $lang['message_m']; ?>"></textarea> <div></div>
			 <input type="hidden" name="id" value="<?php echo $id; ?>">
		 <div class="space10px"></div>
		 
		 <button class="btn btn-success addnbtn"><?php echo $lang['posalji']; ?></button>
			 </form>			
			
			<?php
			}
			
		} else if($_GET['p'] == "poruke") {
	?>      
			   <?php
			   $p_q = mysql_query("SELECT * FROM poruke WHERE za='$_COOKIE[userid]' OR od='$_COOKIE[userid]' ORDER BY lastanswer DESC LIMIT 10");
			   if(mysql_num_rows($p_q) < 1){
				   
				   echo "<div class='si-bgshow pfff'>$lang[nema]</div>";
				   
			   } else {
				 while($p = mysql_fetch_array($p_q)){
			     $od = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$p[od]'"));
				 $za = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$p[za]'"));
				 $time = time_ago($p['time']);
				 
	if($p['nza'] == $_COOKIE['userid'] AND $p['status'] == "0"){
	$link = "/read/message/$p[id]";
	} else {
	$link = "/panel/poruke/$p[id]";
    }
	
	$bg = $p['status'];
    if($bg == "0" AND $p['nza'] == $_COOKIE['userid']){
       $bg = "background:#004e92;";
    } else {};	
				 
					 echo "
					 <div style='$bg' class='si-bgshow pfff'>
					 <img style='width:50px;height:50px;' src='/avatars/$od[avatar]'>
				     <div class='zahtevi_look'>
				     <a href='/member/$od[username]'>$od[username]</a> > <a href='/member/$za[username]'>$za[username]</a>  <span style='float:right;'><small>$time</small></span> <div style='height:5px;'></div> <a href='$link'><em>$p[title]</em></a> <div style='height:5px;'></div> <small>$p[message]</small> <div style='height:3px;'></div>
				     </div>
					 </div>
					 
					 <div style='height:5px;'></div>
					 ";
			    }
			   }
			   
			   
	} else if(addslashes($_GET['p'] == "obavestenja")){ 
    ?>

         <?php
						$br_t = mysql_num_rows(mysql_query("SELECT * FROM obavestenja WHERE nza='$_COOKIE[userid]' "));
						if($br_t < 1){
						    echo "<div class='si-bgshow pfff'>$lang[nema]</div>";
							
						} else {
						
						$t = mysql_query("SELECT * FROM obavestenja WHERE nza='$_COOKIE[userid]' ORDER BY id DESC LIMIT 10");
						while($te = mysql_fetch_array($t)){
						$user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$te[nod]' "));
						
						$type = $te['type'];
						$time = time_ago($te['time']);
						
						    $bg = $te['status'];
                            if($bg == "0"){
                                 $bg = "background:#004e92;";
                            } else {}	
						
						if($type == "1"){
						  $server = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$te[var]'"));
						  		echo "			 
					 <div style='$bg' class='si-bgshow pfff'>
					 <img style='width:50px;height:50px;' src='/avatars/$user[avatar]'>
				     <div class='zahtevi_look'>
				     <a href='/member/$user[username]'>$user[username]</a> <span style='float:right;'><a href='/read/notification/$te[id]'> <button class='btn btn-primary sibtn-new pull-right'>$lang[p_read]</button> </a></span>  <div style='height:5px;'></div> $lang[p_korisnik] <a href='/member/$user[username]'>$user[username]</a> $lang[p_server] <a href='/server_info/$server[ip]'>$server[hostname]</a> <div style='height:3px;'></div> <small>$time</small> <div style='height:3px;'></div>
				     </div>
					 </div>
					 
					 <div style='height:5px;'></div>
								";
						} else if($type == "2"){
						       echo "                    
					 <div style='$bg' class='si-bgshow'>
					 <img style='width:50px;height:50px;' src='/avatars/$user[avatar]'>
				     <div class='zahtevi_look'>
				     <a href='/member/$user[username]'>$user[username]</a>  <span style='float:right;'><a href='/read/notification/$te[id]'> <button class='btn btn-primary sibtn-new pull-right'>$lang[p_read]</button> </a></span> <div style='height:5px;'></div> $lang[p_korisnik] <a href='/member/$user[username]'>$user[username]</a> $lang[p_prihvatio]. <div style='height:3px;'></div> <small>$time</small> <div style='height:3px;'></div>
				     </div>
					 </div>
					 
					 <div style='height:5px;'></div>							   
							   ";
					
						} else if($type == "3"){
						       echo "                    
					 <div style='$bg' class='si-bgshow'>
					 <img style='width:50px;height:50px;' src='/avatars/$user[avatar]'>
				     <div class='zahtevi_look'>
				     <a href='/member/$user[username]'>$user[username]</a> <span style='float:right;'><a href='/read/notification/$te[id]'> <button class='btn btn-primary sibtn-new pull-right'>$lang[p_read]</button> </a></span>  <div style='height:5px;'></div> $lang[p_korisnik] <a href='/member/$user[username]'>$user[username]</a> $lang[p_profil] <div style='height:3px;'></div> <small>$time</small> <div style='height:3px;'></div>
				     </div>
					 </div>
					 
					 <div style='height:5px;'></div>					 
							   ";
						} else {}


						}
						}
						?>
						
     <?php   }	?>
		  </div>
			  
	<?php 
	}
	?>