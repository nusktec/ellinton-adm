<?php

/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 27/10/2020 - Model.php
 */
class Model
{
    function doLogin($d)
    {
        if ($d && isset($d)) {
            $arr = getDummy();
            if ($arr['user'] === $d['usr'] && $arr['pass'] === sha1($d['psw'])) {
                //success
                setUser($d);
            } else {
                setAlert(array("msg" => "Wrong login details", "type" => "alert-primary"));
            }
        }
    }

    function fileImport($array = null)
    {
        if (!$array || count($array) < 1)
            return false;
        DB::insert("quotes", $array);
        return true;
    }

    function getQuotes()
    {
        return DB::query("select * from quotes");
    }

    function addQuotes($d)
    {
        if (!isset($d['image']) || !isset($d['quote']) || !isset($d['author'])) {
            return false;
        }
        //do insert in db
        DB::insert("quotes", $d);
        return true;
    }

    function delQuote($d)
    {
        if (!isset($d['target']) || empty($d['target'])) {
            return false;
        }
        //check if available
        $rd = DB::query("select * from quotes where image=" . $d['target']);
        if ($rd) {
            //delete from db
            DB::delete('quotes', 'image=%i', $d['target']);
            return true;
        } else {
            return false;
        }
    }

    function goLive($d)
    {
        if (!isset($d['target']) || empty($d['target'])) {
            return false;
        }
        //do updates
        //DB::query("UPDATE quotes SET status=0");
        DB::update("quotes", ["status" => 0], "status=%i", 1);
        DB::update("quotes", ["status" => 1], "image=%i", $d['target']);
        return true;
    }

    function getDaily()
    {
        return DB::queryOneRow("select q.*, (null) as id, CONCAT('https://ellingtonelectric.com/api/reedax/images/',q.image,'.jpg') as fullpath from quotes q where status=1");
    }

    function getAllQuotesFullPath()
    {
        return DB::query("select q.*, (null) as id, CONCAT('https://ellingtonelectric.com/api/reedax/images/',q.image,'.jpg') as fullpath from quotes q where status=0");
    }

    function goExport()
    {
        $rd = DB::query("select * from quotes");
        return $rd;
    }

    function shuffleDaily()
    {
        //start shuffling
        $rdFirst = DB::queryFirstRow("select * from quotes");
        $rdCurrent = DB::queryOneRow("select * from quotes where status=1");
        var_dump($rdCurrent);
        $rdNextInt = DB::queryFirstRow("select * from quotes where id>" . $rdCurrent['id']);
        //check if that post will exist
        $chk = DB::queryOneRow("select * from quotes where id=" . ($rdNextInt['id'] ? $rdNextInt['id'] : 0));
        //compare current id
        if ($chk) {
            //update the current...
            echo $rdNextInt['id'];
            $this->goLive(['target' => $chk['image']]);
        } else {
            $this->goLive(['target' => $rdFirst['image']]);
            $chk = $rdFirst;
        }
        return $chk;
    }
}