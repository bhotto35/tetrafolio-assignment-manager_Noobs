<?php
    include 'dbconn.php';
?>
<html>
<body>

<style>
    .assignment{
        display:inline-block;
        padding:10px;
        text-align:center;
        width:65%;
        color:green;
        border-bottom: 1px solid white;
        background:rgb(200,191,231);
    }
    .delete{
        display:inline-block;
        padding:12px 10px 12px 10px;
        text-align:center;
        color:white;
        border-bottom: 1px solid white;
        background:red;
    }
    .delete:hover{
        background:pink;
    }
    .assignment:hover{ 
        background:rgb(164,149,215);
    }
    .general{
        font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;
    }
</style>
<div style = "width:70%; margin: 0 auto;top:10%;padding:10px">
<?php
    $session_id = $_POST['session_id'];
    $subject_id = $_POST['subject_id'];
    $types = array("General Assignments"=>"general_assignments","Labs"=>"lab","Project"=>"project","Notes"=>"notes");
    $types1 = array("General Assignments"=>"general","Labs"=>"lab","Project"=>"project","Notes"=>"notes");

    foreach($types as $x => $y)
    {
        echo "<div class='assignment-topic'>".$x."</div>";
        $query = "select ga.id, ga.name,ga.deadline from ".$y." as ga inner join subject as sub on ga.subject_id = sub.id inner join sessions as sess on sub.session_id = sess.id";
        if(strcmp($y,"notes")==0)
            $query = "select ga.id, ga.name from ".$y." as ga inner join subject as sub on ga.subject_id = sub.id inner join sessions as sess on sub.session_id = sess.id";
        $query = $query." where sess.id=".$session_id." and sub.id = ".$subject_id.";";

        $result = mysqli_query($link,$query);

        if(mysqli_num_rows($result)==0)
        {
            echo "No assignments added";
        }
        while($result_array = mysqli_fetch_assoc($result))
        {
            
            if(strcmp($y,"notes")!=0)
            {
                $currdate = date('Y-m-d')." ".date('H:m:s');
                $neg = false;
                if(strcmp($currdate,$result_array['deadline'])>0)
                $neg = true;
                $datetime1 = new DateTime(date('Y-m-d')." ".date('H:m:s'));
                $datetime2 = new DateTime($result_array['deadline']);

                $difference = $datetime1->diff($datetime2);
                $s = $difference->format("%a:%h:%i:%s");
                $times = explode(":",$s);
                $weight = array(24*60*60,24*60,24,1);
                $units = array('day(s)','hour(s)','minute(s)','second(s)');
                $weighted_sum = 0;
                echo "<div style='text-align:center'>";
                foreach($times as $m=>$n)
                {
                    $times[$m] = (int)$n;
                    if($neg)
                    $times[$m] = 0-$times[$m];
                    echo $times[$m]." ".$units[$m]." ";
                    $weighted_sum +=$times[$m]*$weight[$m];
                }
                //echo $weighted_sum." &nbsp";
                //print_r($times);
                if(!$neg)
                {   
                    $progress = ((31*24*60*60)-$weighted_sum)/ (31*24*60*60)*100;
                    //echo "hmm ".$progress;
                    echo '<progress id="file" value="'.$progress.'" max="100"></progress></div>';
                }
                else
                {
                    echo "<span style = 'color:red'> Past deadline!</span>";
                }
                
            }
            
            
            $type = $types1[$x];
            $str = "<div style='text-align:center'><div class='assignment' onclick = 'openAssignment(".$subject_id.",".$result_array['id'].",";
            $str = $str.'"'.$type.'"';
            $str = $str.",".$session_id.")'>".$result_array['name']."</div>";
            echo $str;
            $str1 = '<div class="delete" onclick = "';
            $str1 = $str1."delete_('".$y."',".$result_array['id'].",'".$result_array['name']."')";
            $str1 = $str1.'">';
            $str1 = $str1."<i class='fa fa-trash'></i></button></div>";
            echo $str1;
            
        }
        $str0 = '<div id="assignment-add"><button type = "button" id = "assignment-add-btn" onclick="';
        $str0=$str0."openAddForm('".$y."')";
        $str0 = $str0.'">';
        echo $str0;
        
        ?>
        <i class='fa fa-plus'>Add</i></button></div><hr><br>
        <?php
    }

    /*$query = "select ga.id, ga.name from ".$types[$type]." as ga inner join subject as sub on ga.subject_id = sub.id inner join sessions as sess on sub.session_id = sess.id";
    $query = $query." where sess.id=".$session_id." and sub.id = ".$subject_id.";";

    $result = mysqli_query($link,$query);

    if(mysqli_num_rows($result)==0)
    {
        echo "No assignments added";
    }
    while($result_array = mysqli_fetch_assoc($result))
    {
        $general = "general";
        $str = "<div class='assignment' onclick = 'openAssignment(".$subject_id.",".$result_array['id'].",".$general.")'>".$result_array['name']."</div>";
        echo $str;
    }*/
    
?>
</div>
</body>
</html>

