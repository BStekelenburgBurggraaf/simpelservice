	<form class="log" action="?controller=login&action=login" method="post">
      	<div class="container">
        	<label><b>Username</b></label>
        	<input type="text" placeholder="Enter Username" name="uname" required="required" <?php if(isset($uname)) { echo "value=\"". $uname."\""; }  ?>h>
    
        	<label><b>Password</b></label>
        	<input type="password" placeholder="Enter Password" name="psw" required="required">
    
        	<button type="submit">Login</button>
        	<!--<input type="checkbox" checked="checked"> Remember me-->
      	</div>
    
      	<div class="container" style="background-color:#f1f1f1">
        	<span class="psw">Forgot <a href="#">password?</a></span>
      	</div>
	</form>