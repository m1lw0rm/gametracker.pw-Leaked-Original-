<?php
        session_start();
        include('connect_db.php'); 
		
        $ip			= addslashes($_GET['ip']);
		$color      = addslashes($_GET['color']);
		
       $colors = array(
						'blue'				=> 'blue',
						'gray'			    => 'gray',
						'green' => 'green',
						'orange'         => 'orange',
						'red'           => 'red',
						'yellow'  => 'yellow',
	   );	
	   
		$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));
		
		$name = $info['hostname'];

        if(strlen($name) > 50){ 
          $name = substr($name,0,50); 
          $name .= "..."; 
        }         
		
		$status = $info['online'];
		if($status == "1"){
		  $status = "Online";
		} else {
		  $status = "Offline";
		}
		
		$mapa = $info['mapname'];
        if(strlen($mapa) > 15){ 
          $mapa = substr($mapa,0,15); 
          $mapa .= "..."; 
        }     		

		if($info['ip'] == ""){
	       header('Content-Type: image/png');
	       $image = imagecreatefrompng("ime/no_banner.png");
	       imagepng($image);
           imagedestroy($image);
		} 
				
		if ( in_array ( $color , $colors ) ) {
		
		$server_max_players = $info['max_players'];
		$server_playercount = $info['playercount'];
		$chart_x_fields		= $info['chart_updates'];
        $chart_x_replace	= "0,2,4,6,8,10,12,14,16,18,20,22,24";
		$chart_x_max		= $server_max_players;
	    $chart_data			= $server_playercount;
		
        $chart_url          = imagecreatefrompng("http://chart.apis.google.com/chart?chf=bg,s,67676700&chxp=&chs=131x49&cht=lc&chco=3793f0&chds=0,$chart_x_max&chd=t:$chart_data&chdlp=b&chls=1");
   
		$server_location	= imagecreatefrompng("ime/flags/$info[location].png");
        $logo               = imagecreatefrompng("img/banner_logo.png");
		
        header('Content-type: image/png');
		
        $image = imagecreatefrompng("banners/160x250/$color.png");
		imagecopy($image, $chart_url, 24, 170, 0, 0, 131, 49);
		imagecopy($image, $server_location, 32, 67, 0, 0, 15, 10);
        imagecopy($image, $logo, 53, 247, 0, 0, 40, 40);
	   
        $white = imagecolorallocate($image, 255, 255, 255);
		$green = imagecolorallocate($image, 32, 201, 16);
		$red = imagecolorallocate($image, 199, 31, 16);

		imagettftext($image, 8, 270, 8, 5, $white, 'img/g1.ttf', "$name");
		imagettftext($image, 8, 0, 32, 37, $white, 'img/g1.ttf', "$ip");
		imagettftext($image, 8, 0, 32, 152, $white, 'img/g1.ttf', "$mapa");
        imagettftext($image, 8, 0, 32, 116, $white, 'img/g1.ttf', "$info[num_players]/$info[max_players]");
		imagettftext($image, 8, 0, 105, 78, $white, 'img/g1.ttf', "#$info[rank]");
		if($info['online'] == "1"){
		imagettftext($image, 8, 0, 105, 152, $green, 'img/g1.ttf', "$status");		
		} else {
		imagettftext($image, 8, 0, 105, 152, $red, 'img/g1.ttf', "$status");		
		}
		
        imagepng($image);
        imagedestroy($image);
		
		} else {
	       header('Content-Type: image/png');
	       $image = imagecreatefrompng("ime/no_banner.png");
	       imagepng($image);
           imagedestroy($image);
		}
?>