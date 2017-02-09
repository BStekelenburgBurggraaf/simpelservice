<?php
foreach($boards as $board) {
?>
	<h1><?php echo $board->boardName; ?></h1>
    <?php
		for ($i = 0; $i < count($board->ticketTitle); $i++) {
			?>
            <p><?php echo $board->ticketTitle[$i]; ?><br/><?php echo $board->ticketContent[$i] ?><br/><?php echo $board->ticketAuthor[$i]; ?><br/><?php echo $board->ticketPriority[$i]; ?></p>
            <?php
		}
	?>
<?php
}
?>
		