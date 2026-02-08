<?php
# SMARTHOME
# - Actions
####################
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");


header('Content-Type: application/json');

# Input validator
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

# Setup Response
$actionresult = 'unknown';

# Double check actually a post first
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputcolour = '';
    if (isset($_POST["colour"])) {
        $inputcolour = test_input($_POST["colour"]);
        $inputcolour = strtolower($inputcolour);
    }

    if ($inputcolour != '') {
        $command = "python /home/pi/gamewatch_robot/directfire.py ".$inputcolour." 2>&1";

        if ($command != '') {
            $pid = popen( $command,"r");
            while( !feof( $pid ) )
            {
                echo fread($pid, 256);
                flush();
                ob_flush();
                usleep(100000);
            }
            pclose($pid);
            $actionresult = true;
        } else
            $actionresult = false;

    }
}

# Return Results
echo json_encode(array('result' => $actionresult));

?>
