	<form class="log" action="/simpelservice/admin/createProject" method="post">
      	<div class="container">
        	<label><b>Naam project</b></label>
        	<input type="text" placeholder="Naam..." name="title" required="required">
    		<select required="required" name="bedrijf">
            	<option value="">Maak een keuze...</option>
            <?php foreach($companies as $company) { ?>
            	<option value="<?php echo $company[0]; ?>"><?php echo $company[1]; ?></option>
            <?php } ?>
            </select>
            <select required="required" name="category">
            	<option value="">Maak een keuze...</option>
            <?php foreach($categories as $category) { ?>
            	<option value="<?php echo $category[0]; ?>"><?php echo $category[1]; ?></option>
            <?php } ?>
            </select>
            
        	<button type="submit">Submit</button>
      	</div>
	</form>