	<form class="log" action="?controller=tickets&action=create" method="post">
      	<div class="container">
        	<label><b>Titel</b></label>
        	<input type="text" placeholder="Enter Title" name="title" required>
    
        	<label><b>Omschrijving</b></label>
        	<textarea name="content" required></textarea>
            
            <label><b>Prioriteit</b></label>
            <select name="priority">
            	<option value="urgent">Urgent</option>
                <option value="normaal" selected>Normaal</option>
                <option value="kan wachten">Kan Wachten</option>
            </select>
    
        	<button type="submit">Versturen</button>
      	</div>
    
      	<div class="container" style="background-color:#f1f1f1">
      	</div>
	</form>