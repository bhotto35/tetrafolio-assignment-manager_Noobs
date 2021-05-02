<?php
    include '../dbconn.php';
    $name = $_POST['topic-name'];
    $session = $_POST['session_id'];
    $query = "insert into subject(name,session_id) values('".$name."',$session);";
    $result = mysqli_query($link,$query);
    if($result)
    echo "<script>alert('done')</script>";
    else
    echo "<script>alert('error')</script>";
?>