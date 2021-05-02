<?php
    include '../dbconn.php';
    $tablename = $_POST['tablename'];
    $id = $_POST['id'];
    $query = "delete from $tablename where id=$id;";
    $result = mysqli_query($link,$query);
    if($result)
    echo "<script>alert('done')</script>";
    else
    echo "<script>alert('error')</script>";
?>