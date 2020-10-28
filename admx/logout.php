<?php
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 27/10/2020 - logout.php
 */
session_start();
session_destroy();
header("location: login");