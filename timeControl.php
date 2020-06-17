<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['time']) && time() > $_SESSION['time']) {
 
    header('Location:../SessionEnded/SessionEnded.php');
} else {
    $_SESSION['time'] = time() + 100;
}
 
