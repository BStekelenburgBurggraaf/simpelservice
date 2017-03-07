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
            <h1>Categorieën</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                </tr>
                <?php foreach($categories as $category) {?>
                <tr>
                    <td><?php echo $category[0]; ?></td>
                    <td><?php echo $category[1]; ?></td>
                </tr>
                <?php } ?>
            </table>
            <h1>Bedrijven</h1>
            <table>
            	<tr>
                	<th>ID</th>
                    <th>Naam</th>
                </tr>
                <?php foreach($companies as $company) { ?>
                <tr>
                	<td><?php echo $company[0]; ?></td>
                    <td><?php echo $company[1]; ?></td>
                </tr>
                <?php } ?>
            </table>
            <h1>Projecten</h1>
            <table>
            	<tr>
                	<th>ID</th>
                    <th>Titel</th>
                    <th>Bedrijf</th>
                    <th>Categorie</th>
                </tr>
                <?php foreach($projects as $project) { ?>
                <tr>
                	<td><?php echo $project[0]; ?></td>
                    <td><?php echo $project[1]; ?></td>
                    <td><?php echo $project[2]; ?></td>
                    <td><?php echo $project[3]; ?></td>
                </tr>
                <?php } ?>
            </table>
            <h1>Users</h1>
            <table>
            	<tr>
                	<th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Bedrijf</th>
                </tr>
                <?php foreach($users as $user) { ?>
                <tr>
                	<td><?php echo $user[0]; ?></td>
                    <td><?php echo $user[1]; ?></td>
                    <td><?php echo $user[2]; ?></td>
                    <td><?php echo $user[3]; ?></td>
                    <td><?php echo $user[4]; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="news">
    	
    </div>
</div>