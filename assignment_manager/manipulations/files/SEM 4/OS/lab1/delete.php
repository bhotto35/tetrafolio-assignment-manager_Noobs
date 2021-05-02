<?php
    include '../dbconn.php';
    
    $id = $_POST['id'];
    $location = "../";//$_POST['location'];
    $q = "select location from file where id = ".$id;
    $r = mysqli_result($link,$q);
    $ra = mysqli_fetch_assco($r);
    $location = $location."".$ra['location'];
    $query1 = "delete from file where id = ".$id;
    if(!file_exists($location))
    {
        if(unlink($location))
        {
            mysqli_query($link,$query1);
            $str = "<script>alert('Successful upload".$query1."');
            </script>";
            echo $str;
        }
        else
            echo "<script>alert('Could not upload');
            </script>";
    }
    else{
        echo "<script>alert('File already exists in database');
            </script>";
            $str = "<script>";
            $str = $str.'alert("File already exists in database '.$query1.'")';
            $str = $str."</script>";
            echo $str;
    }
?>