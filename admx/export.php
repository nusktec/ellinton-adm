<?php
error_reporting(0);
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 28/10/2020 - export.php
 */
include "includes/Func.php";
//initialize model
if ($_GET['cmd']==="export" && $_GET['ssk'] === $_SESSION['csr']) {
    $m = new Model();
    header('Content-disposition: attachment; filename='.date("Y-M-D").'-rdx-ellington-bkp.json');
    header('Content-type: application/json');
    echo json_encode($m->goExport());
} else {
    header("Content-Type: application/json; charset=utf-8");
    echo "Not allowed !";
}