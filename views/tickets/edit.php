<?php foreach($tickets as $ticket) { ?>
    <form class="log" enctype="multipart/form-data" action="/simpelservice/tickets/edit/<?php echo $_GET["id"]; ?>" method="post">
      	<div class="container">
        	<label><b>Titel</b></label>
        	<input type="text" value="<?php echo $ticket[3]; ?>" name="title" disabled required>
    
        	<label><b>Omschrijving</b></label>
        	<textarea name="content" required disabled><?php echo $ticket[4]; ?></textarea>
            
            <label><b>Categorie</b></label>
            <select disabled name="category">
            	<?php foreach($categories as $category) { ?>
            	<option <?php if($ticket[5] == $category[0]) { echo "selected"; } ?> value="<?php echo $category[0]; ?>"><?php echo $category[1]; ?></option>
            	<?php } ?>
            </select>
            
            <label><b>Prioriteit</b></label>
            <select disabled name="priority">
            	<option <?php if($ticket[6] == "urgent"){ echo "selected"; } ?> value="urgent">Urgent</option>
                <option <?php if($ticket[6] == "normaal"){ echo "selected"; } ?> value="normaal" selected>Normaal</option>
                <option <?php if($ticket[6] == "kan wachten"){ echo "selected"; } ?> value="kan wachten">Kan Wachten</option>
            </select>
            <label><b>Status</b></label>
            <select name="status">
            	<option <?php if($ticket[9] == "pending") { echo "selected"; }  ?> value="pending">Pending</option>
                <option <?php if($ticket[9] == "open") { echo "selected"; }  ?> value="open">Open</option>
                <option <?php if($ticket[9] == "mee bezig") { echo "selected"; }  ?> value="mee bezig">Mee bezig</option>
                <option <?php if($ticket[9] == "testen") { echo "selected"; }  ?> value="testen">Testen</option>
                <option <?php if($ticket[9] == "closed") { echo "selected"; }  ?> value="closed">Gesloten</option>
            </select>
            <label><b>Images:</b></label>
            <div id="dynamicInput">
            	<?php
				$images = $ticket[8];
				$images = rtrim($images, ",");
				$images = explode(",", $images);
				
				foreach($images as $image) { ?>
					<img src="<?php echo "/simpelservice/". $image; ?>" />
				<?php } ?>
            </div>
        	<button type="submit">Versturen</button>
      	</div>
    
      	<div class="container" style="background-color:#f1f1f1">
      	</div>
	</form>
<?php } ?>