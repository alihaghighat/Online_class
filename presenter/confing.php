<?php

@session_start();
$id=0;





function db_connect(){

    $link= @ mysqli_connect("localhost","projec37_haq","Web1253698***@_@","projec37_web") or die(exit('اتصال به دیتا بیس برفرار نشد.'));

    mysqli_query($link, "SET NAMES utf8");

    if($link){

        mysqli_query($link,"SET NAME utf8");

        mysqli_query($link,"SET CHARACTER SET UTF8");

        mysqli_query($link,"SET charactor_set_connection='utf8'");

        return $link;

    }

    return false;



}



function getrecord($tblname,$where=1){

    $link= db_connect();

    $tblname=sqi($tblname);

    $query="select * from $tblname  where $where";

    $r=mysqli_query($link,$query);

    if($r){

        $res=array();

        $i=0;



        while($row=mysqli_fetch_assoc($r)){

            $res[$i]=$row;

            $i++;



        }

        return $res;

    }

    else{

        //echo mysqli_error($link );

        return false;

    }





}

function runsql($query){

    $link= db_connect();



    $r=mysqli_query($link,$query);

    if($r){

        $res=array();

        $i=0;



        while($row=mysqli_fetch_assoc($r)){

            $res[$i]=$row;

            $i++;



        }

        return $res;

    }

    else{

        //echo mysqli_error($link );

        return false;

    }





}





function sqi($value){

    $link=db_connect();

    if(get_magic_quotes_gpc()){

        $value =stripcslashes($value);

    }

    if(function_exists("mysqli_real_escape_string")){

        $value=mysqli_real_escape_string($link,$value);

    }

    else {

        $value=addslashes($value);

    }

    return $value;

}



function addrecored($tblname,$values=NULL){

    $link=db_connect();

    $tblname=sqi($tblname);

    if(is_array($values)){

        $key=array_keys($values);

        $value=array_values($values);

        $i=0;

        foreach($value as $row){

            $value[$i]="'".sqi($row)."'";

            $i++;

        }

        $key=implode(',',$key);

        $value=implode(',',$value);

        $query="INSERT INTO `$tblname` ($key) VALUES ($value) ";

        $r=mysqli_query($link,$query);

        if($r){

            return true;

        }

        else{

            return false;

        }

    }

    return false;

}
function getrecord1($tblname,$where=1,$tkrar){

    $link= db_connect();

    $tblname=sqi($tblname);

    $query="select DISTINCT $tkrar from $tblname  where $where";

    $r=mysqli_query($link,$query);

    if($r){

        $res=array();

        $i=0;



        while($row=mysqli_fetch_assoc($r)){

            $res[$i]=$row;

            $i++;



        }

        return $res;

    }

    else{

        //echo mysqli_error($link );

        return false;

    }





}



function updaterecord($tblname,$values,$where){

    $link=db_connect();

    $tblname=sqi($tblname);

    if(is_array($values)){

        $key=array_keys($values);

        $value=array_values($values);

        $i=0;

        foreach($value as $row){

            $value[$i]="`$key[$i]`  =  '".sqi($row)."'";

            $i++;

        }

        $value=implode(',',$value);



        $query="UPDATE `$tblname` SET $value WHERE $where ";

        $r=mysqli_query($link,$query);

        if($r){

            return true;

        }

        else{
            return mysqli_error($link);
            //return false;

        }

    }

    return mysqli_error($link);

}



function delet_recorc($tblname,$where){

    $link=db_connect();

    $tblname=sqi($tblname);

    $query="DELETE FROM `$tblname` WHERE $where ";

    $r=mysqli_query($link,$query);

    if($r){

        return true;

    }

    else{

        return false;

    }

}




    if(!isset($_SESSION['idpresenter'])){
        $idpresenter=0;



    }else{

        $idpresenter=$_SESSION['idpresenter'];

    }
