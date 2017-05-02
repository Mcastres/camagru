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
