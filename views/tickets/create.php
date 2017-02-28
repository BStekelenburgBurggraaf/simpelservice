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
            	<option value="1">1</option>
                <option value="2">2</option>
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
                <label><b>Onzichtbaar voor klant</b></label><br/>
                <input type="checkbox" name="visible" value="onzichtbaar" />
                <?php
			}
			?>
        	<button type="submit">Versturen</button>
      	</div>
    
      	<div class="container" style="background-color:#f1f1f1">
      	</div>
	</form>