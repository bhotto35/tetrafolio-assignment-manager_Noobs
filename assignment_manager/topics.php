<?php
    include 'dbconn.php';
?>


<style>
    .subject{
        width:100%;
        padding:10px;
        text-align:center;
        color:green;
        background:rgb(239,228,176);
        display:block;
    }
    .subject:hover{ 
        background:rgb(223,201,96);
    }
</style>
<div style = "width:70%; margin: 0 auto;top:10%;padding:10px">
<?php
    $session_id = $_POST['session_id'];
    $query = "select sub.id,sub.name from subject as sub inner join sessions as sess on sub.session_id = sess.id where sess.id =".$session_id.";";
    
    $result = mysqli_query($link,$query);

    if(mysqli_num_rows($result)==0)
    {
        echo "No topics added";
    }
    while($result_array = mysqli_fetch_assoc($result))
    {
        $str = "<div class='subject' onclick = 'openSubject(".$session_id.",".$result_array['id'].")'>".$result_array['name']."</div>";
        echo $str;
        echo "<br>";
    }
    
?>
</div>
    

