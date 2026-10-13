<?php

include "connection.php";

Database::iud("UPDATE `order` SET `history_status`='0'");
echo ("success");

?>