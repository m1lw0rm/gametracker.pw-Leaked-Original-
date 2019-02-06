    <?php
	defined("access") or die("Nedozvoljen pristup");
	
	if($_COOKIE['userid'] == ""){
	?>
	
	
		  <div class="section-title">
		  <h1> <i class="fa fa-key" aria-hidden="true"></i> Prijavi se </h1>
		  <p>Prijavite se na vas nalog.</p>
		  </div>
		  
		  
<form action="/process.php?task=login" class="form-m" method="POST">
				<div class="form-group">
				<label><?php echo $lang['username']; ?></label>
				<input name="username" class="form-control" type="text" required />
				</div>
				<div class="form-group">
				<label><?php echo $lang['password']; ?></label>
				<input name="password" class="form-control"  type="password" required /> 
				</div>
				<div class="form-group">
				<span class="remember"><?php echo $lang['zapamti_nalog']; ?></span>
				<input type="checkbox" class="form-control"  style="width:15px;" name="remember" value="1" checked="checked"> 
				</div>
				<div class="form-group">
				
				<div class="space"></div>
				
				<button type="submit" name="login" class="btn btn-success addnbtn"> <?php echo $lang['login']; ?> </button>
				<a data-toggle="modal" data-target="#lostpw" class="btn btn-default lostpwbtn pull-right"><?php echo $lang['zaboravljena_sifra']; ?></a>
				</div>
			</form>
		</div>
		
<div class="modal fade" id="lostpw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['zaboravljena_sifra']; ?></h4>
      </div>
      <div class="modal-body">
	  
<form action="/process.php?task=reset_password" class="form-m" method="POST">
			
            <div class="modal-body">
              <input type="text" name="email" placeholder="<?php echo $lang['email']; ?>" class="form-control" required="required">			
              <br /><small style="color:#FFF"><?php echo $lang['email_sa_nalogom']; ?></small>	  
            </div>
            <div class="modal-footer">
             <button class="btn btn-primary sendpwback"><?php echo $lang['posalji']; ?></button>
            </div>
			
			</form> 

    </div>
  </div>
</div>			

		  
	<?php 
	} else { 
	die("<script> alert('$lang[prijavljeniste]'); document.location.href='/'; </script>");
	}
	?>