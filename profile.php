<?php

session_start();
/*********************************************
* Include_once
*/
include_once('Class/class.bdd.php');

/*********************************************
* Class
*/
$Database = Database::get_Instance();

if (!$_SESSION['auth'])
	header('location: index.php?page=1');


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - <?php echo $_SESSION['auth']['username']; ?></title>
		<script type="text/javascript" src="webcam.js"></script>
		<script type="text/javascript"><!--
    document.write( webcam.get_html(320, 240) );
// --></script>
		<script type="text/javascript"><!--

		    webcam.set_api_url( 'action.php' );
		    webcam.set_quality( 100 ); // JPEG quality (1 - 100)
		    webcam.set_shutter_sound( true ); // play shutter click sound
		    webcam.set_hook( 'onComplete', 'my_completion_handler' );

		    function take_snapshot() {
		        $('#showresult').html('<h1>Uploading...</h1>');
		        webcam.snap();
		    }

		    function configure(){
		        webcam.configure();
		    }

		    function my_completion_handler(msg) {
		        // msg will give you the url of the saved image using webcamClass
		        $('#showresult').html("<img src='"+msg+"'> <br>"+msg+"");
		        return false;
		    }

// --></script>
	</head>
	<body>
		<a href="index.php?page=1">Home</a>
		<a href="logout.php">Se deconnecter</a>
		<script type="text/javascript">
    		document.write( webcam.get_html(320, 240) );
		</script>
		<form>
			<input type="button" value="Configure..." onClick = "webcam.configure()">
			<input type="button" value="Take Snapshot" onClick="take_snapshot()">
		</form>

	</body>
</html>
