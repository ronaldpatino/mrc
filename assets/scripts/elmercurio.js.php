<?php
$offset = 60 * 60 * 24; // Cache for a day
header('Content-type: application/javascript');
header ('Cache-Control: max-age=' . $offset . ', must-revalidate');
header ('Expires: ' . gmdate ("D, d M Y H:i:s", time() + $offset) . ' GMT');

ob_start("compress");
function compress($buffer) {
    return $buffer;
}

include('jquery-1.9.0.js');
include('bootstrap.min.js');
include('bootstrap-datepicker.js');

ob_end_flush();