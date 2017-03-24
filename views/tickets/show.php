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
    		<div class="ticket">
            	<h1><?php echo $ticket->title; ?></h1>
                <hr/><br/>
                <h3>Omschrijving</h3>
                <p><?php echo $ticket->content; ?></p><br/>
                <h3>Categorie</h3>
                <p><?php echo $ticket->category; ?></p><br/>
                <h3>Auteur</h3>
                <p><?php echo $ticket->author; ?> - <?php echo $ticket->company; ?></p><br/>
                <h3>Prioriteit</h3>
                <p><?php echo $ticket->priority; ?></p><br/>
                <h3>Status</h3>
                <p><?php echo $ticket->status; ?></p><br/>
                <?php if(isset($ticket->fileNames) AND $ticket->fileNames != '') { ?>
                    <h3>Images</h3>
                    <p>
                    <?php
                    $images = $ticket->fileNames;
                    $images = rtrim($images, ",");
                    $images = explode(",", $images);
                    
                    foreach($images as $image) { ?>
                        <img src="<?php echo "/simpelservice/". $image; ?>" /><br/>
                    <?php } ?>
                    </p>
                 <?php } ?>
            </div>
            <?php if($role == "admin" && !empty($subscribedUsers)) { ?>
            <div class="ticket">
            	<h1>Users met een subscriptie</h1>
                <hr/><br/>
                <table>
                	<tr>
                    	<th>Id</th>
                        <th>Naam</th>
                        <th>Bedrijf</th>
                        <th>Rol</th>
                    </tr>
                    <?php
					foreach($subscribedUsers as $user) { 
					?>
                    <tr>
                    	<td><?php echo $user[0]; ?></td>
                        <td><?php echo $user[1]; ?></td>
                        <td><?php echo $user[2]; ?></td>
                        <td><?php echo $user[3]; ?></td>
                    </tr>
                    <?php
					}
					?>
                </table>
                <a href="/simpelservice/tickets/addUsers/<?php echo $_GET["id"]; ?>">Voeg een nieuwe user toe</a>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="news">
    	
    </div>
</div>