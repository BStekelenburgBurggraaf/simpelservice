<?php
foreach($options as $option){ 
	$display = $option->displayOptions;
	$id = $option->id;
}
?>
<div class="wrapper">
    <div class="menu">
    <!--&#8981;-->
    	<ul>
         	<li class="dropdown">
          		<?php if(isset($boards) AND count($boards) > 1) { ?>
            	<a href="/simpelservice/boards/home" class="dropbtn">Projecten &#9660;</a>
            	<div class="dropdown-content">
              		<?php 
			  		foreach ($boards as $board) {
			  		?>
              		<a href="/simpelservice/boards/home/<?php echo $board->boardId; ?>"><?php echo $board->boardName; ?></a>
             		 <?php  
			  		} 
			  		?>
           		 </div>
          		<?php } else { ?>
          			<a href="/simpelservice/boards/home">Terug &#9664;</a>
          		<?php } ?>
          	</li>
          	<li>
          		<a href="#">Bedrijven</a>
          	</li>
          	<li class="dropdown">
            	<a href="/simpelservice/admin/home" class="dropbtn">Admin &#9660;</a>
            	<div class="dropdown-content">
              		<a href="/simpelservice/admin/createProject">Nieuw project</a>
             		 <a href="/simpelservice/admin/createCompany">Nieuw bedrijf</a>
             		 <a href="/simpelservice/admin/createCategory">Nieuwe cateogrie</a>
              		<a href="/simpelservice/admin/createUser">Nieuwe gebruiker</a>
            	</div>
         	</li>
          	<li>
          		<a href="/simpelservice/options/home">Opties</a>
          	</li>
        </ul>
    </div>
    <div class="content">
    	<div class="contentWrapper">
            <h1>Opties</h1>
            <form  class="log" enctype="multipart/form-data" action="/simpelservice/options/home" method="post">
            	<div class="container">
                    <label><b>Weergave projecten bij login</b></label>
                    <select name="displayOptions">
                        <option value="show all" <?php if($display == "show all") { echo "selected"; } ?>>Alles</option>
                        <option value="subscribed" <?php if($display == "subscribed") { echo "selected"; }?>>Alleen gevolgde tickets en projecten</option>
                    </select>
                    <input name="id" type="hidden" value="<?php echo $id; ?>" />
                    <button type="submit">Versturen</button>
                </div>
            </form>
        </div>
    </div>
    <div class="news">
    	
    </div>
</div>