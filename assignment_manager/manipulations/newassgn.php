<?php
    include '../dbconn.php';
    $name = $_POST['name'];
    $tablename = $_POST['tablename'];
    $subject_id = $_POST['subject_id'];
    $deadline = $_POST['deadline'];
    $query = "insert into ".$tablename."(name,subject_id,deadline) values('".$name."',$subject_id,'".$deadline."');";
    if(strcmp($tablename,"notes")==0)
    $query = "insert into notes(name,subject_id) values('".$name."',$subject_id);";
    $result = mysqli_query($link,$query);
    if($result)
    echo "<script>alert('done')</script>";
    else
    echo "<script>alert('error')</script>";
?>