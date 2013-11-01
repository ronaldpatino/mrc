<?php
$offset = 60 * 60 * 24; // Cache for a day
header('Content-type: text/css');
header ('Cache-Control: max-age=' . $offset . ', must-revalidate');
header ('Expires: ' . gmdate ("D, d M Y H:i:s", time() + $offset) . ' GMT');

ob_start("compress");
function compress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
}

include('bootstrap.css');
include('bootstrap-responsive.css');
include('custom.css');
include('font.css');
ob_end_flush();