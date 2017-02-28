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
                </tr>
                <?php
                }
                ?>
            </table>
		<?php
		}
		?>
        </div>
    </div>
    <div class="news">
    	
    </div>
</div>