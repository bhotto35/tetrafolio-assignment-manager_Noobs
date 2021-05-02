<?php
    include '../dbconn.php';
    $session_name = $_POST['session_name'];
    $subject_name = $_POST['subject_name'];
    $assgn_name = $_POST['assgn_name'];
    $assgn_id = $_POST['assgn_id'];
    $sub_id = $_POST['subject_id'];
    $type = $_POST['type'];
    $path = "../files/".$session_name."/".$subject_name."/".$assgn_name;
    echo $path;
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $location =  "files/".$session_name."/".$subject_name."/".$assgn_name;
    if (isset($_FILES["file0"]) && $_FILES["file0"]["error"] == 0)
    {
        $file_name     = basename($_FILES["file0"]["name"]); 
        $file_type     = $_FILES["file0"]["type"]; 
        $file_size     = $_FILES["file0"]["size"]; 
        $file_tmp_name = $_FILES["file0"]["tmp_name"]; 
        $query1 = "insert into file(name,location,type, subject_id,assignment_id) values('$file_name','$location','$type',$sub_id,$assgn_id);";
        if(!file_exists("$path/$file_name"))
        {
            if(move_uploaded_file($file_tmp_name, "$path/$file_name"))
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
    }
?>