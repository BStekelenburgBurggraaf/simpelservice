<div class="wrapper">
    <div class="menu">
    <!--&#8981;-->
    	<ul>
          <li class="dropdown">
          <?php if(count($boards) > 1) { ?>
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
    	<?php
		foreach($boards as $board) {
		?>
            <h1 class="boardTitle"><?php echo $board->boardName; ?></h1>
            <hr />
            <table>
                <tr>
                    <th>Titel</th> 
                    <th>Content</th>
                    <th>Categorie</th>
                    <th>Prioriteit</th>
                    <th>Status</th>
                    <th>Auteur</th>
                    <th></th>
                    <?php if($role == "admin" || $role == "personeel") { ?>
						<th></th>
					<?php } ?>
                </tr>
            <?php
                for ($i = 0; $i < count($board->ticketTitle); $i++) {
                ?>
                <tr class="draw meet">
                    <td class="ticketTitle"><?php echo $board->ticketTitle[$i]; ?></td>
                    <td class="ticketContent"><?php echo $board->ticketContent[$i]; ?></td>
                    <td class="ticketCategory"><?php echo $board->ticketCategory[$i]; ?></td>
                    <td class="ticketPriority"><?php echo $board->ticketPriority[$i]; ?></td>
                    <td class="ticketStatus"><?php echo $board->ticketStatus[$i]; ?></td>
                    <td class="ticketAuthor"><?php echo $board->ticketAuthor[$i]; ?></td>
                    <td><a href="/simpelservice/tickets/show/<?php echo $board->ticketId[$i]; ?>">Details</a></td>
                    <?php if ($role == "admin" || "personeel") { ?>
                    <td><a href="/simpelservice/tickets/edit/<?php echo $board->ticketId[$i]; ?>">Aanpassen</a></td>
                    <?php } ?>
                </tr>
                <?php
                }
                ?>
            </table>
		<?php
		}
		if(isset($role) && $role == "admin" && !empty($subscribedUsers)) { ?>
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
            <?php } ?>
        </div>
    </div>
    <div class="news">
    	
    </div>
</div>