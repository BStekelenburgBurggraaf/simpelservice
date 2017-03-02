	<script>
	var counter = 1;
	var limit = 5;
	function addInput(divName){
		 if (counter == limit)  {
			  alert(counter + " is het maximum aantal images dat je kan toevoegen.");
		 }
		 else {
			  var newdiv = document.createElement('div');
			  newdiv.innerHTML = "<br><input type='file' name='images[]'>";
			  document.getElementById(divName).appendChild(newdiv);
			  counter++;
		 }
	}
	</script>
    <form class="log" enctype="multipart/form-data" action="/simpelservice/tickets/create/<?php echo $board_id; ?>" method="post">
      	<div class="container">
        	<label><b>Titel</b></label>
        	<input type="text" placeholder="Enter Title" name="title" required>
    
        	<label><b>Omschrijving</b></label>
        	<textarea name="content" required></textarea>
            
            <label><b>Categorie</b></label>
            <select name="category">
            	<?php foreach($categories as $category) { ?>
            	<option value="<?php echo $category[0]; ?>"><?php echo $category[1]; ?></option>
            	<?php } ?>            
            </select>
            
            <label><b>Prioriteit</b></label>
            <select name="priority">
            	<option value="urgent">Urgent</option>
                <option value="normaal" selected>Normaal</option>
                <option value="kan wachten">Kan Wachten</option>
            </select>
            <label><b>Images:</b></label>
            <div id="dynamicInput">
            	<input type="file" name="images[]">
            </div>
            <input type="button" value="Extra image toevoegen" onClick="addInput('dynamicInput');">
    		<br /><input type="hidden" name="board_id" value="<?php echo $board_id; ?>"/>
            <?php
			if($role == "personeel" || $role == "admin") {
				?>
                <label><b>Zichtbaarheid voor klant</b></label><br/>
                <select name="visible">
                	<option value="zichtbaar">Zichtbaar voor iedereen</option>
                    <option value="onzichtbaar-klant">Onzichtbaar voor klanten</option>
                    <?php if($role == "admin") { ?><option value="onzichtbaar">Onzichtbaar voor iedereen behalve admins</option><?php } ?>
                </select>
                <?php
			}
			?>
        	<button type="submit">Versturen</button>
      	</div>
    
      	<div class="container" style="background-color:#f1f1f1">
      	</div>
	</form>