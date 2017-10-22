<?php

if ($_GET['retry'] == '1') {
    http_response_code(503);
}

var_dump(getallheaders());

var_dump(file_get_contents("php://input"));
