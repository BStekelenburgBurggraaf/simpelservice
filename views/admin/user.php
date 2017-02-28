	<form class="log" action="/simpelservice/admin/createUser" method="post">
      	<div class="container">
        	<label><b>Naam gebruiker</b></label>
        	<input type="text" placeholder="Naam..." name="naam" required>
            <label><b>Wachtwoord</b></label>
            <input type="password" placeholder="Wachtwoord..." name="password" required="required" >
            <label><b>Email</b></label>
            <input type="text" placeholder="Email..." name="email" required >
            <label><b>Bedrijf</b></label>
            <select name="bedrijf" required="required">
            	<option value="">Maak een keuze...</option>
                <?php foreach($companies as $company) { ?>
                <option value="<?php echo $company[0]; ?>"><?php echo $company[1]; ?></option>
                <?php } ?>
            </select>
            <select name="role" required="required">
            	<option value="admin">Admin</option>
                <option value="personeel">Personeel</option>
                <option value="klant" selected="selected">Klant</option>
            </select>
            
        	<button type="submit">Submit</button>
      	</div>
	</form>