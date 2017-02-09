	<form class="log" action="/simpelservice/tickets/create/<?php echo $board_id; ?>" method="post">
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
    		<input type="hidden" name="board_id" value="<?php echo $board_id; ?>"/>
        	<button type="submit">Versturen</button>
      	</div>
    
      	<div class="container" style="background-color:#f1f1f1">
      	</div>
	</form>