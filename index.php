<?php
session_start();
include_once("connect_db.php");

  //** Vazno
  if (empty($_COOKIE['sesija'])) {} else {
  $check = mysql_query("SELECT * FROM users WHERE sesija = '$_COOKIE[sesija]' AND userid = '$_COOKIE[userid]' AND username = '$_COOKIE[username]'");
  if (mysql_num_rows($check) == 0) { 
      header("location:/logout.php");
	  die();
  }
  $check = mysql_fetch_assoc($check);
  $user = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE userid = '$check[userid]'"));
  mysql_query("UPDATE users SET activity = '".time()."' WHERE userid = '$check[userid]'");
  }
 

$serversq = mysql_query("SELECT * FROM `servers`");
$serversnum = mysql_num_rows($serversq);

$communitiesq = mysql_query("SELECT * FROM `community`");
$communitiesnum = mysql_num_rows($communitiesq);

$usersq = mysql_query("SELECT * FROM `users`");
$usersnum = mysql_num_rows($usersq);

$playersq = mysql_query("SELECT * FROM `players`");
$playersnum = mysql_num_rows($playersq);

// stats
$br_zajednica = mysql_query("SELECT * FROM community WHERE ownerid='$_COOKIE[userid]'");
$br_zahteva = mysql_num_rows(mysql_query("SELECT * FROM zahtevi WHERE za='$_COOKIE[userid]' AND status='0'"));
$br_poruka = mysql_num_rows(mysql_query("SELECT * FROM poruke WHERE nza='$_COOKIE[userid]' AND status='0'"));
$br_obv = mysql_num_rows(mysql_query("SELECT * FROM obavestenja WHERE nza='$_COOKIE[userid]' AND status='0'"));
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="Statistika game servera, baneri, merenje kvaliteta game servera">
<meta name="keywords" content="gameservers, cs, counter-strike, cs banners, statistika servers, fpsmeter">
<meta name="author" content="Demir Izdirovic (morphe_uS@live.com)">	

<link href="/ime/bootstrap.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="/slick/slick-theme.css"/>
				
<title><?echo $title;?> - GameTracker</title>
</head>

<?php
if(isset($_SESSION['ok'])){
	$ok = $_SESSION['ok'];
	echo "<div class='alert alert-success fade in' role='alert'><button type='button' class='close' data-dismiss='alert'> x </button> <b> Uspesno! </b> <div class='space10px'></div> <span> $ok </span> </div>";
	unset($_SESSION['ok']);
} else if(isset($_SESSION['error'])){
	$greske = $_SESSION['error'];
	echo "<div class='alert alert-danger fade in' role='alert'><button type='button' class='close' data-dismiss='alert'> x </button> <b> Greska! </b> <div class='space10px'></div> <span> $greske </span> </div>";
	unset($_SESSION['error']);
} else {}
?>

<body style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" class="frost">
    
   <nav class="navbar -dark navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/index.php">
		     <img class="logo" style="margin-top:-60px" src="">
		  </a>
		  
        </div>
        <div id="navbar" class="collapse navbar-collapse">
		  
          <ul class="nav navbar-nav pull-right">
               <li><a href="/index.php" class="<?php echo $h_active; ?>"> <div class="icnn"> <i class="fa fa-home"></i> </div> <span> <?php echo $lang['pocetna']; ?> <div class="space5px"></div> <small><?php echo $lang['pocetna_add']; ?></small> </span> </a></li>
               <li><a href="/servers/" class="<?php echo $s_active; ?>"> <div class="icnn"> <i class="fa fa-list"></i> </div> <span><?php echo $lang['serveri']; ?>  <div class="space5px"></div> <small><?php echo $lang['serveri_add']; ?></small> </span> </a></li>
               <li><a href="/communities" class="<?php echo $c_active; ?>"> <div class="icnn"> <i class="fa fa-cog" aria-hidden="true"></i> </div> <span><?php echo $lang['zajednice']; ?>  <div class="space5px"></div> <small><?php echo $lang['zajednice_add']; ?></small> </span> </a></li>
               <li><a href="/memberlist" class="<?php echo $u_active; ?>"> <div class="icnn"> <i class="fa fa-users"></i> </div> <span><?php echo $lang['korisnici']; ?>  <div class="space5px"></div> <small><?php echo $lang['korisnici_add']; ?></small> </span> </a></li>
               <li><a href="#"> <div class="icnn"> <i class="fa fa-table"></i> </div> <span><?php echo $lang['forum']; ?>  <div class="space5px"></div> <small><?php echo $lang['forum_add']; ?></small> </span> </a></li>
          </ul>
		  
        </div>
      </div>
    </nav>

<div class="row">
<div class="sidebar-lang pull-right">
  <ul>
     
    <li <?php if($_COOKIE['language'] == "srb"){ ?> class="active" <?php } ?>>
            <a href="/process.php?task=lang&lang=srb">
                <img src="/ime/flags/RS.png" alt="" width="16" height="11" />
                Serbian 
			</a>
     </li>
    <li <?php if($_COOKIE['language'] == "en"){ ?> class="active" <?php } ?>>
            <a href="/process.php?task=lang&lang=en">
                <img src="/ime/flags/EN.png" alt="" width="16" height="11" />
                English
		    </a>
     </li>
	 
 </ul>
</div>
    
    <ol class="breadcrumb breadcrumb-arrow">
		<?php echo $breadcrumb; ?>
	</ol>
	
	<div class="vip-background"> 
	
<div class="center">
<?php
$gv = mysql_query("SELECT * FROM `servers` WHERE vip='1' ORDER BY rank DESC LIMIT 20");
while($v = mysql_fetch_array($gv)){
	
  $vnaziv = $v['hostname'];
  if(strlen($vnaziv) > 20){ 
          $vnaziv = substr($vnaziv,0,20); 
          $vnaziv .= "..."; 
     }
	 
	 if (file_exists("ime/maps/".$v['mapname'].".jpg")){ 
	 $mapimg = "<img class='st_mapimg' src='/ime/maps/$v[mapname].jpg'>"; 
	 } else {
	 $mapimg = "<img class='st_mapimg' src='/ime/mapbg.png'>";	 
	 } 
	 
	 if($v['online'] == 0){
		 $addclass = 'vipoff';
	 } else {
		 $addclass = '';
	 }
	 
	 
	echo "
	<div> 
	
	<div class='vipbox-bg $addclass'> 
	 <a href='/server_info/$v[ip]'>$vnaziv</a> <span class='vip-ip pull-right'>$v[ip]</span>
	  
	  <div class='space5px'></div>
	  
	  <div class='row'>
	    <div class='col-md-3'> <div style='margin-left:-10px'>$mapimg</div> <div class='space10px'></div> <a style='margin-left:-10px' href='steam://connect/$v[ip]'> <button class='btn btn-success btn-xs'> Connect </button> </a> </div>
		<div class='col-md-9'> <div class='vipbox-row'> <span>Rank:</span> <b>$v[rank]</b> </div> <div class='vipbox-row'> <span>$lang[mapa]:</span> <b>$v[mapname]</b> </div> <div class='vipbox-row'> <span>$lang[igraci_s]:</span> <b>$v[num_players]/$v[max_players]</b> </div> </div>
	  </div>
	</div> 
	
	</div>";
}
?>

</div>
			
	</div>
</div>	
	
	<div class="space5px"></div>
 
      <div class="container">
 
      <div class="row">
	  
	  <?php
	  define("access", 1);

	  if($_GET['page'] == "server_info"){
		  include("server_info.php");
	  } else {
	  ?>
	  
	      <div class="col-md-3">
    		 <div class="sidebar">
			 <ul>
			     <div class="sidebar-cclear"> <span class="frozen-icon"> <i class="fa fa-list"></i> </span> <?php echo $lang['glavni_meni']; ?></div>
				 <div class="space10px"></div>

					   <?php 
						if(empty($_COOKIE['userid'])){} else { 
						
						    if(mysql_num_rows($br_zajednica) > 0){
								 $comm_info = mysql_fetch_array($br_zajednica);
								 echo "<a href='/community_info/$comm_info[id]'><li> <h1> <i class='fa fa-plus'></i> </h1> $lang[dodaj_zajednicu] <div class='space5px'></div> <small>$lang[dodaj_zajednicuadd]</small> </li></a>";
							} else {
						?>
			                  <a data-toggle="modal" href="#add-comm"> <li> <h1> <i class="fa fa-plus"></i> </h1> <?php echo $lang['dodaj_zajednicu']; ?> <div class="space5px"></div> <small><?php echo $lang['dodaj_zajednicuadd']; ?></small> </li> </a>
						
				<?php } ?> 
							
			   <a href="/dodaj"> <li class="<?php echo $d_active; ?>"> <h1> <i class="fa fa-plus"></i> </h1> <?php echo $lang['dodajserver']; ?> <div class="space5px"></div> <small><?php echo $lang['dodajserver_add']; ?></small> </li> </a>

			   <?php } ?>				 
			   <a data-toggle="modal" href="#search-server"> <li> <h1> <i class="fa fa-search"></i> </h1> <?php echo $lang['pretraziservere']; ?> <div class="space5px"></div> <small><?php echo $lang['pretraziservere_add']; ?></small> </li> </a>
			   <a href="/servers/games"> <li class="<?php echo $g_active; ?>"> <h1> <i class="fa fa-gamepad"></i> </h1> <?php echo $lang['igre']; ?> <div class="space5px"></div> <small><?php echo $lang['igre_add']; ?></small> </li> </a>
                       
							
			     <div class="sidebar-cclear"> <span class="frozen-icon"> <i class="fa fa-key"></i> </span> <?php echo $lang['korisnickipanel']; ?> </div>
				 <div class="space10px"></div>
			
			   <?php if(empty($user['username'])){ ?>
			   <a href="/login"> <li class="<?php echo $l_active; ?>"> <h1> <i class="fa fa-key"></i> </h1> <?php echo $lang['login']; ?> <div class="space5px"></div> <small><?php echo $lang['login_add']; ?></small> </li> </a>
			   <a href="/register"> <li class="<?php echo $r_active; ?>"> <h1> <i class="fa fa-user"></i> </h1> <?php echo $lang['register']; ?> <div class="space5px"></div> <small><?php echo $lang['register_add']; ?></small> </li> </a>
               <?php } else { ?>
			   <a href="/member/<?php echo $user['username']; ?>"> <li class="<?php echo $u_active; ?>"> <h1> <i class="fa fa-user"></i> </h1> <?php echo $user['username']; ?> <div class="space5px"></div> <small><?php echo $lang['profil_add']; ?></small> </li> </a>			   
			   <a href="/logout.php"> <li> <h1> <i class="fa fa-times"></i> </h1> <?php echo $lang['logout']; ?> <div class="space5px"></div> <small><?php echo $lang['logout_add']; ?></small> </li> </a>
			   
			   <a href="/panel/obavestenja"> <li class="<?php echo $ann_active; ?>"> <h1> <i class="fa fa-globe"></i> </h1> <?php echo $lang['obavestenja']; ?> <?php if($br_obv > 0){ ?> <span class="badge"><?php echo $br_obv; ?></span> <?php } ?> <div class="space5px"></div> <small><?php echo $lang['obavestenja_addd']; ?></small> </li> </a>
			   <a href="/panel/poruke"> <li class="<?php echo $msg_active; ?>"> <h1> <i class="fa fa-send"></i> </h1> <?php echo $lang['inbox']; ?> <?php if($br_poruka > 0){ ?> <span class="badge"><?php echo $br_poruka; ?></span> <?php } ?>  <div class="space5px"></div> <small><?php echo $lang['inbox_add']; ?></small> </li> </a>
			   <a href="/panel/zahtevi"> <li class="<?php echo $fr_active; ?>"> <h1> <i class="fa fa-users"></i> </h1> <?php echo $lang['zahtevi']; ?> <?php if($br_zahteva > 0){ ?> <span class="badge"><?php echo $br_zahteva; ?></span> <?php } ?> <div class="space5px"></div> <small><?php echo $lang['zahtevi_add']; ?></small> </li> </a>

			   <?php } ?>
			   
			     <div class="sidebar-cclear"> <span class="frozen-icon"> <i class="fa fa-plus"></i> </span> <?php echo $lang['dodatni_meni']; ?></div>
				 <div class="space10px"></div>
				 
			   <a href="#"> <li> <h1> <i class="fa fa-inbox"></i> </h1> Kontakt <div class="space5px"></div> <small>Posaljite nam poruku..</small> </li> </a>
			   <a href="#"> <li> <h1> <i class="fa fa-question"></i> </h1> FAQ <div class="space5px"></div> <small>Odgovori na najcesca pitanja korisnika.</small> </li> </a>
			 </ul>
			 </div>
		  </div>
		  
		  <div class="col-md-9">
		  
		  <!-- obavestenja -->
          <div class="row">
		  
          
<?php   
   if($_GET['page'] == "login"){
	   include("login.php");
   } else if($_GET['page'] == "register"){
	   include("register.php");
   } else if($_GET['page'] == "dodaj"){
	   include("dodaj.php");
   } else if($_GET['page'] == "games"){
	   include("games.php");
   } else if($_GET['page'] == "servers"){
	   include("servers.php");
   } else if($_GET['page'] == "community_info"){
	   include("community_info.php");
   } else if($_GET['page'] == "communities"){
	   include("communities.php");
   } else if($_GET['page'] == "memberlist"){
	   include("memberlist.php");
   } else if($_GET['page'] == "member"){
	   include("member.php");
   } else if($_GET['page'] == "guestbook"){
	   include("guestbook.php");
   } else if($_GET['page'] == "panel"){
	   include("panel.php");
   } else if($_GET['page'] == "boost"){
	   include("boost.php");
   } else {
	   include("main.php");
   }
   ?>

		  
		  </div>
	   </div>
	   
	   
	  <?php } ?>
	  
	   </div>
	   
	   </div>
	   
	          <div class="space20px"></div>
			  
	   <div class="dark-back">
	   <h1> <i class="fa fa-star"></i> TOP 10 </h1>
	   <p> <?php echo $lang['top10_text']; ?> </p>
	   
	   <div class="space10px"></div>
	   
	          <div class="container">

			  <div class="row">
			    <div class="col-md-4">
				
 <table style="width:100%;" class="table-striped">
 <tr>
  <th><?php echo $lang['najpopularniji']; ?></th>
 </tr>
   <?php
  $vreme = time() + 500;
  $topid = 0;
  $topq = mysql_query("SELECT * FROM servers WHERE game='cs16' AND last_update > '".date("Y-m-d", $vreme)."' ORDER BY rank ASC LIMIT 10");
  while($tq = mysql_fetch_assoc($topq)){
    $topid++;
	
	$naziv = $tq['hostname'];
    if(strlen($naziv) > 25){ 
          $naziv = substr($naziv,0,25); 
          $naziv .= "..."; 
     }
	 
    echo "<tr> <td> <span class='topid'>$topid</span> <img style='height:15px;' src='/ime/games/game-$tq[game].png'> <img style='height:15px;width:15px;' src='/ime/flags/$tq[location].png'> <a href='/server_info/$tq[ip]'>$naziv</a> <div class='space5px'></div> <div class='badge blueeee pull-right'># $tq[rank]</div> <small>$tq[ip]</small> <small class='top-players'>$tq[num_players]/$tq[max_players]</small> </td> </tr>";
  }
  ?>
 </table>	
 
				</div>
				
				
			    <div class="col-md-4">
				
 <table style="width:100%" class="table-striped">
 <tr>
  <th><?php echo $lang['random_s']; ?></th>
 </tr>
  <?php
  $vreme = time() + 60;
  $topid = 0;
  $topq = mysql_query("SELECT * FROM servers WHERE last_update > '".date("Y-m-d", $vreme)."' ORDER BY rand() DESC LIMIT 10");
  while($tq = mysql_fetch_assoc($topq)){
    $topid++;
	
	$naziv = $tq['hostname'];
    if(strlen($naziv) > 25){ 
          $naziv = substr($naziv,0,25); 
          $naziv .= "..."; 
     }
	 
    echo "<tr> <td> <span class='topid'>$topid</span> <img style='height:15px;' src='/ime/games/game-$tq[game].png'> <img style='height:15px;width:15px;' src='/ime/flags/$tq[location].png'> <a href='/server_info/$tq[ip]'>$naziv</a> <div class='space5px'></div> <div class='badge blueeee pull-right'># $tq[rank]</div> <small>$tq[ip]</small> <small class='top-players'>$tq[num_players]/$tq[max_players]</small> </td> </tr>";
  }
  ?>
 </table>
 
				</div>
				
				
			    <div class="col-md-4">
				
   <table style="width:100%" class="table-striped">
   <tr>
   <th><?php echo $lang['poslednjidodati']; ?></th>
   </tr>
  <?php
  $vreme = time() + 60;
  $topid = 0;
  $topq = mysql_query("SELECT * FROM servers WHERE last_update > '".date("Y-m-d", $vreme)."'ORDER BY id DESC LIMIT 10");
  while($tq = mysql_fetch_assoc($topq)){
    $topid++;
	
	$naziv = $tq['hostname'];
    if(strlen($naziv) > 25){ 
          $naziv = substr($naziv,0,25); 
          $naziv .= "..."; 
     }
	 
    echo "<tr> <td> <span class='topid'>$topid</span> <img style='height:15px;' src='/ime/games/game-$tq[game].png'> <img style='height:15px;width:15px;' src='/ime/flags/$tq[location].png'> <a href='/server_info/$tq[ip]'>$naziv</a> <div class='space5px'></div> <div class='badge blueeee pull-right'># $tq[rank]</div> <small>$tq[ip]</small> <small class='top-players'>$tq[num_players]/$tq[max_players]</small> </td> </tr>";
  }
  ?>
  </table>
  
				</div>			  
			  </div>
			  
			  </div>
	   
	   </div>
	   </div>
	   
	   <footer>
	     &copy; Copyright <b>Gametracker</b> 2017. <?php echo $lang['cr_text']; ?>. <span class="pull-right"> <?php echo $lang['cr_text1']; ?>: <a href="#"> MORPH Projects </a> </span>
	   </footer>
	
</body>


<div class="modal fade" id="search-server" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:800px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-search"></i> <?php echo $lang['pretraziservere']; ?></h4>
      </div>
<div class="mirror">		        <div class="modal-body">
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
	</div>
	</div>
	</div>
	</div>
	
	
<?php
if(empty($_COOKIE['username'])){} else {
?>

<div class="modal fade" id="add-comm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['dodaj_zajednicu']; ?></h4>
      </div>
      <div class="modal-body">
			
			<form action="/process.php?task=add_community" method="POST">
			
            <div class="modal-body">
               <label><?php echo $lang['ime_zajednice']; ?>:</label> <input class="form-control" type="text" name="naziv" placeholder="<?php echo $lang['ime_zajednice']; ?>" required="required"> <div class="space"></div><br />
               <label><?php echo $lang['sajt_forum']; ?>:</label> <input class="form-control" type="text" name="forum" placeholder="www.link.com" required="required"> <div class="space"></div><br />
               <label><?php echo $lang['o_zajednici'];?>:</label> <textarea class="form-control" name="opis" placeholder="<?php echo $lang['o_zajednici'];?>" required="required"></textarea> <div class="space"></div><br />
            </div>
            <div class="modal-footer">
             <button class="btn btn-primary sendpwback"><?php echo $lang['posalji']; ?></button>
            </div>
			
			</form>
</div>	
</div>
</div>
</div>
<?php } ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="/slick/slick.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
	<script>
	window.setTimeout(function() {
		$(".alert").fadeTo(500,0).slideUp(500, function(){
			$(this).remove();
		});
	}, 5000);
	</script>
	<script>
		$('.center').slick('setPosition');
	</script>
	<script>
$('.center').slick({
  centerMode: true,
  centerPadding: '40px',
  slidesToShow: 4,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '20px',
        slidesToShow: 4
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '20px',
        slidesToShow: 1
      }
    }
  ]
});
	</script>
</html>