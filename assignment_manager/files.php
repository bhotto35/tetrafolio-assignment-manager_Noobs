<?php
    include 'dbconn.php';
?>
<html>
    <head>
        <meta charset="utf-8" />
        <!--<link rel="icon" href="%PUBLIC_URL%/favicon.ico" />-->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="theme-color" content="#000000" />
        <meta
            name="description"
            content="Web app for Assignment Management"
        />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <style>
        .row {
        display: flex; /* equal height of the children */
        }

        .col {
        flex: 1; /* additionally, equal width */
        
        padding: 10px;
        border: solid;
        }
        .timer{
            padding:20px;
            text-align:center;
            font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;
            font-size:70px;
        }
        td{
            padding: 2px 12px 2px 12px;
        }
        .deadline{
            padding:20px;
            text-align:center;
            font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;
            font-size:70px;
            color:red;
        }
        .submitted{
            padding:20px;
            text-align:center;
            font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;
            font-size:70px;
            color:lawngreen;
        }
    </style>
    <body>
        <div class='row'>
        <div class='col'>
        <?php
            $types = array("General Assignment"=>"general_assignments","Lab"=>"lab","Project"=>"project","Note"=>"notes");
            $types1 = array("general"=>"General Assignment","lab"=>"Lab","project"=>"Project","notes"=>"Note");
            $type = $_POST['type'];
            $subject_id = $_POST['subject_id'];
            $assgn_id = $_POST['assgn_id'];
            $query = "select * from file where type = '".$type."' and subject_id = ".$subject_id." and assignment_id=".$assgn_id.";";
            //echo $query;
            $results = mysqli_query($link,$query);
            echo "<table>";
            while($result_array = mysqli_fetch_assoc($results))
            {
                echo "<tr>";
                $str= "<td>".$result_array['name']."</td><td><button id = 'download".$result_array['id']."' onclick = 'downloadFile(".$result_array['id'].")' value='".$result_array['location']."'>";
                $str =$str."<i class='fa fa-download'>&nbspDownload</i></button>";
                $str = $str."<button type ='button'id = 'del".$result_array['id']."'onclick = deleteFile(".$result_array['id'].") value='".$result_array['location']."'>";
                $str = $str."<i class='fa fa-trash'>&nbspDelete</i></button>";
                $str = $str."<button id = 'replace".$result_array['id']."'onclick = replaceFile(".$result_array['id'].") value='".$result_array['location']."'>";
                $str =$str."<i class='fa fa-exchange'>&nbspReplace</i></button></td></tr>";
                echo $str;
            }
            echo "</table>";
            $submitted=-1;
            if(strcmp($type,"notes")!=0)
            {
                $query = "select submitted from ".$types[$types1[$type]]." where id = ".$assgn_id.";";
                $result = mysqli_query($link,$query);
                $ra = mysqli_fetch_assoc($result);
                $submitted = $ra['submitted'];
                //echo "sub_stat: ".$submitted;
            }
            
            
            
            
            
            /*$filename = 'files/DA1_OS.pptx';
            //Check the file exists or not
            if(file_exists($filename)) {

            //Define header information
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: 0");
            header('Content-Disposition: attachment; filename="'.basename($filename).'"');
            header('Content-Length: ' . filesize($filename));
            header('Pragma: public');

            //Clear system output buffer
            flush();

            //Read the size of the file
            readfile($filename);

            //Terminate from the script
            die();
            }
            else{
            echo "File does not exist.";
            }*/
        ?>
        </div>
        <?php
            if($submitted!=-1)
            {
                
                if($submitted!=1)
                {
                    echo "<input type = 'number' id='sub_stat' name='sub_stat' value=0 hidden>";
                    echo '<div id = "timer"class = "col timer"></div>';
                }
                else{
                    echo "<input type = 'number' id='sub_stat' name='sub_stat' value=1 hidden>";
                    echo '<div id = "timer"class = "col submitted">Submitted</div>';
                }
            }
            else
            echo "<input type = 'number' id='sub_stat' name='sub_stat' value=-1 hidden>";
        ?>
        <script>
            var sub_stat = document.getElementById('sub_stat').value;
            //var sub_stat=0;
            if(sub_stat==0)
            {
                var sec=document.getElementById('seconds').value;
                var sec0 = sec;
                var days = Math.floor(sec/(24*60*60));
                var sec = sec%(24*60*60);
                var hrs = Math.floor(sec/(60*60));
                var sec = sec%(60*60);
                var min = Math.floor(sec/(60));
                var sec=sec%60;
                var timer = setInterval(function(){
                    document.getElementById('timer').innerHTML="Time remaining: "+days+":"+hrs+":"+min+":"+sec;
                    if(sec<=0 && min>0 && hrs>0 && days>0)
                    {
                        sec=59;
                        min-=1;
                    }
                    else if(min<=0 && hrs>0 && days>0)
                    {
                        min = 59;
                        sec = 59;
                        hrs-=1;
                    }
                    else if(hrs<=0 && days>0)
                    {
                        hrs = 23;
                        min = 59;
                        sec = 59;
                        days-=1;
                    }

                    else if(sec<=0 && min<=0 && days<=0 && hrs<=0)
                    {
                        //clearInterval(x);
                        //document.getElementById('timer').innerHTML="Deadline passed!";
                        
                        if(min<=-59 && sec<=-59 && hrs<=-23)
                        {
                            hrs = 0;
                            min = 0;
                            sec = 0;
                            days-=1;
                        }
                        else if(min<=-59 && sec<=-59){
                            hrs-=1;
                            min = 0;
                            sec = 0;
                        }
                        else if(sec<=-59){
                            min-=1;
                            sec = 0;
                        }
                        document.getElementById('timer').innerHTML="Deadline passed by: "+days+":"+hrs+":"+min+":"+sec;
                        document.getElementById('timer').style.color = 'red';
                    }
                },1000);
            }
            
        </script>
        </div>
    </body>
</html>