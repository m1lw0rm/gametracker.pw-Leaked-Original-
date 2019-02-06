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

        if(strlen($name) > 20){ 
          $name = substr($name,0,20); 
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
        $chart_url          = imagecreatefrompng("http://chart.apis.google.com/chart?chf=bg,s,67676700&chxp=&chs=104x16&cht=lc&chco=3793f0&chds=0,$chart_x_max&chd=t:$chart_data&chdlp=b&chls=1");

		$server_location	= imagecreatefrompng("ime/flags/$info[location].png");
		$logo               = imagecreatefrompng("img/banner_logo.png");
		
        header('Content-type: image/png');
		
        $image = imagecreatefrompng("banners/350x22/$color.png");
		imagecopy($image, $chart_url, 243, 2, 0, 0, 104, 16);
 		imagecopy($image, $server_location, 65, 2, 0, 0, 15, 10);
	    imagecopy($image, $logo, 10, -10, 0, 0, 40, 40);
		
        $white = imagecolorallocate($image, 255, 255, 255);
		$green = imagecolorallocate($image, 32, 201, 16);
		$red = imagecolorallocate($image, 199, 31, 16);
		$black = imagecolorallocate($image, 0, 0, 0);
        imagettftext($image, 7, 0, 82, 10, $white, 'img/g1.ttf', "$name");
		imagettftext($image, 7, 0, 64, 20, $white, 'img/g1.ttf', "$ip");
		imagettftext($image, 7, 0, 184, 20, $white, 'img/g1.ttf', "$mapa");
        imagettftext($image, 7, 0, 184, 10, $white, 'img/g1.ttf', "$info[num_players]/$info[max_players]");
		
        imagepng($image);
        imagedestroy($image);
		
		} else {
	       header('Content-Type: image/png');
	       $image = imagecreatefrompng("ime/no_banner.png");
	       imagepng($image);
           imagedestroy($image);
		}
?>