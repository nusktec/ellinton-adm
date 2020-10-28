<?php
session_start();
//place error reporting
include "Dummy.php";
include "db.class.php";
include "Model.php";
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 27/10/2020 - Func.php
 */
const _USER = "reedax.io.ell";

function isLogged()
{
    return $_SESSION[_USER];
}

function restrictedZone()
{
    if (empty(isLogged()) || !isLogged()) {
        //redirect
        header("location: login");
    }
}

function setUser($data)
{
    $_SESSION[_USER] = $data;
    header("location: dash");
}

function setAlert($d)
{
    $_SESSION['x-alert'] = $d;
}

function flashAlert()
{
    $d = @$_SESSION['x-alert'];
    if ($d) {
        ?>
        <div class="alert <?php echo $d['type'] ?>" role="alert">
            <i class="icon-help"></i><?php echo $d['msg'] ?>
        </div>
        <?php
        $_SESSION['x-alert'] = null;
    }
}