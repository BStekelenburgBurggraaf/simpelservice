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
        	<form class="log" action="/simpelservice/boards/addUsers/<?php echo $_GET["id"]; ?>" method="post">
            	<h1>Users toevoegen</h1>
                <hr />
                    <table>
                        <tr>
                            <th>Toevoegen</th>
                            <th>Id</th>
                            <th>Naam</th>
                            <th>Rol</th>
                            <th>Bedrijf</th>
                        </tr>
                        <?php foreach($users as $user) {?>
                        <tr>
                            <td id="userCheckbox<?php echo $user[0]; ?>"><input type="hidden" name="result[id][]" value="<?php echo $user[0] ?>" /><input id="<?php echo $user[0]; ?>" style="width: 100% !important;" type="checkbox" name="result[checked][]" value="true"<?php if(strpos($user[4], " ".$_GET["id"].",") !== false) { echo "checked=checked"; }  ?>/><input id="hidden<?php echo $user[0]; ?>" type="hidden" name="result[checked][]" value="false"/></td>
                            <td><?php echo $user[0]; ?></td>
                            <td><?php echo $user[1]; ?></td>
                            <td><?php echo $user[2]; ?></td>
                            <td><?php echo $user[3]; ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                    <button type="submit">Opslaan</button>
        	</form>
        </div>
    </div>
    <div class="news">
    	
    </div>
</div>
<script>
$( document ).ready(function() {
	$.each($(':checkbox'), function() {
		checkIfChecked(this.id);
	});
});

function checkIfChecked(id) {
	var check = document.getElementById(id).checked;
	if(check == true) {
		var frm = document.getElementById("userCheckbox"+id);
		var inp = document.getElementById("hidden"+id);
		frm.removeChild(inp);
	}
}

$(":checkbox").change(function() {
	toggleChecked(this.id);
});

function toggleChecked(id) {
	var check = document.getElementById(id).checked;
	if(check == true) {
		console.log("hidden"+id);
		var frm = document.getElementById("userCheckbox"+id);
		var inp = document.getElementById("hidden"+id);
		
		frm.removeChild(inp);
	}
	if (check == false) {
		var frm = document.getElementById("userCheckbox"+id);	
		var inp = document.createElement("input");
		inp.setAttribute("id", "hidden"+id);
		inp.setAttribute("type", "hidden");
		inp.setAttribute("name", "result[checked][]");
		inp.setAttribute("value", "false");
		
		frm.appendChild(inp);	
	}
}
</script>