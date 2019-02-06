    <?php
	defined("access") or die("Nedozvoljen pristup");
	
	if($_COOKIE['userid'] == ""){
	?>
	
		  <div class="section-title">
		  <h1> <i class="fa fa-user" aria-hidden="true"></i> Napravi novi racun </h1>
		  <p>Ukoliko jos uvek nemate nalog kod nas, sada je pravo vreme da kreirate jedan.</p>
		  </div>
		  
		  
<form action="/process.php?task=register" class="form-m" method="POST">
  <div class="form-group">
		<label><?php echo $lang['username']; ?></label>
		<input name="username" type="text" placeholder="<?php echo $lang['username']; ?>" class="form-control" required>
  </div>
  <div class="form-group">
		<label><?php echo $lang['ime']; ?></label>
		<input type="text" name="ime" class="form-control" placeholder="<?php echo $lang['ime']; ?>"  required="required">
	</div>
  <div class="form-group">
	    <label><?php echo $lang['prezime']; ?></label>
		<input type="text"  class="form-control" name="prezime" placeholder="<?php echo $lang['prezime']; ?>"  required="required">
	</div>
	<div class="form-group">
		<label><?php echo $lang['password']; ?></label>
		<input name="password"  class="form-control" type="password" placeholder="<?php echo $lang['password']; ?>" required />
	</div>
	<div class="form-group">
	    <label><?php echo $lang['ponovi_sifru']; ?></label>
		<input type="password" class="form-control" name="password2" placeholder="<?php echo $lang['ponovi_sifru']; ?>" required="required">
	</div>
	<div class="form-group">
		<label><?php echo $lang['email']; ?></label>
        	<input name="email" class="form-control" type="email" placeholder="<?php echo $lang['email']; ?>" required />
    </div>
	
	<div class="space"></div>
	
	<div class="form-group">
  <center> <button type="submit"class="btn btn-success addnbtn"> <?php echo $lang['register']; ?> </button> <span class="betw_space"> ili </span> <a href="/login" class="btn btn-default lostpwbtn" style="margin-left:5px"> <?php echo $lang['login']; ?> </a> </center>
	</div>
</table>
</form>
</div>
</div>
	<?php 
	} else { 
	die("<script> alert('$lang[prijavljeniste]'); document.location.href='/'; </script>");
	}
	?>