<?php
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 27/10/2020 - index.php
 */
include "includes/Func.php";

if (isLogged()) {
    header("location: dash");
} else {
    header("location: login");
}