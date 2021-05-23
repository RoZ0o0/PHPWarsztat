<?php
if (isset($_POST['submit'])) {
    $str = json_decode($_POST['str'], true);
	echo json_encode($str);
}
