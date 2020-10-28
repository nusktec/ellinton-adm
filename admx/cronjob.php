<?php
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 28/10/2020 - cronjob.php
 */
header("content-type: application/json");
include "includes/Func.php";
if (isset($_GET['next'])) {
    $m = new Model();
    echo json_encode($m->shuffleDaily());
} else {
    echo "Wrong Command !";
}