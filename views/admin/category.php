	<form class="log" action="/simpelservice/admin/createCategory" method="post">
      	<div class="container">
        	<label><b>Naam categorie</b></label>
        	<input type="text" placeholder="Naam..." name="naam" required="required">
    		<select name="type">
            	<option value="0">Tickets</option>
                <option value="1">Projecten</option>
            </select>
        	<button type="submit">Submit</button>
      	</div>
	</form>