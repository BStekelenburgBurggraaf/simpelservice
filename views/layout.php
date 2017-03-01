<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/simpelservice/css/form.css">
    <?php if ($_GET["controller"] != "tickets") { ?>
    <link rel="stylesheet" type="text/css" href="/simpelservice/css/board.css">
    <?php } ?>
	<title>Untitled Document</title>
</head>

<body>
	<!--<header>
    	<h1>Header</h1>
    </header>-->
    
    <?php require_once("/routes.php"); ?>
    
    <!--<footer>
    	<i>Copyright</i>
    </footer>-->
</body>
</html>