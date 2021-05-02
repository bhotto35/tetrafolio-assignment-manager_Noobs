<?php
    include '../dbconn.php';
    $tablename = $_POST['tablename'];
    $id = $_POST['id'];
    if(strcmp($tablename,"notes")!=0)
    {
        $q = "select submitted from ".$tablename." where id = ".$id.";";
        $r = mysqli_query($link,$q);
        $ra = mysqli_fetch_assoc($r);
        $sub_stat = $ra['submitted'];
        echo "sub_stat: ".$sub_stat;
        if($sub_stat==1)
        $sub_stat = 0;
        else
        $sub_stat = 1;
        $q = "update ".$tablename." set submitted = ".$sub_stat." where id = ".$id.";";
        $r = mysqli_query($link,$q);
        if($r)
        echo "<script>alert('done')</script>";
        else
        echo "<script>alert('error')</script>";
        }
    
?>