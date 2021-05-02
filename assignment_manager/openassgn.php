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
        #home{
            padding: 10px 15px 10px 15px;
            background: lightblue;
            font-family: Lucida, sans-serif;
            color: slateblue;
            border:none;
        }
        #home:hover{
            background:gray;
            color:black;
        }
        #session{
            position:relative; 
            padding:10px 15px 10px 15px;
            border-radius:25px;
            border: 1px solid white;
            font-family: Georgia, sans-serif;
            display:inline;
            font-size:14px;
            color:lightblue;
        }
        #new-file{
            position:fixed;
            left:30%;
            background:white;
            
            border-radius:15px;
            box-shadow:0px 1px 20px 3px darkgray;
            font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;
            color: darkgray;
            text-align:center;
            padding:10px;
            display:none;
        }
        .cancel{
            background:red;
            color:white;
            border:none;
            padding:5px;
            margin-bottom:10px;
            float:right;
        }
        .cancel:hover{
            background:pink
        }
    </style>
    <body style = "background:rgb(129,135,145)">
        <header style="height:60%;width:100%;background-image:url('background.png');background-size:cover;">
			<h1 style = "font-size: 600%;font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;color:rgb(255,83,0);text-shadow: 0px 0px 12px rgb(254,135,56);padding: 20px; position:relative;top:30%;left:10%">
				SkedSetGo
			</h1>
			<h1 style = "font-size: 200%;font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;color:rgb(255,83,0);text-shadow: 0px 0px 12px rgb(254,135,56);padding: 20px; position:relative;top:10%;left:10%">
				Your Personal Assignment Manager
			</h1>
		</header>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            function goHome()
            {
                window.location.replace('index.php');
            }
            function listFiles(type, sub_id,assgn_id)
            {
                $.ajax({
					url : "files.php",
					type : 'post',
					data: {"type":type,"subject_id":sub_id,"assgn_id":assgn_id},
					success: function(data) {
						$('#files').html(data);
						
					},
					error: function() {
						$('#files').text('An error occurred');
					}
				});
                
                
            }
            function changeSubStat(tablename,id){
                $.ajax({
					url : "manipulations/chngsubstat.php",
					type : 'post',
					data: {"tablename":tablename,"id":id},
					success: function(data) {
						console.log(data);
					},
					error: function() {
						console.log('An error occurred');
					}
				});
				setTimeout(() => {  location.reload(); }, 100);
            }
            function uploadFile(){
                alert('Hmm');
            }
            function downloadFile(id)
            {
                var eid = "download"+id;
                address = document.getElementById(eid).value;
                const form=document.createElement('form');
                form.method='post';
                form.action='downloadfile.php';
                const address_ = document.createElement('input');
                address_.type = 'hidden';
                address_.name = 'address';
                address_.value = address;
                form.appendChild(address_);
                document.body.appendChild(form);
			    form.submit();
            }
            function openAddForm()
            {
                document.getElementById("new-file").style.display="block";
            }
            function closeAddForm()
            {
                document.getElementById("new-file").style.display="none";
            }
            function doneUploading()
            {
                setTimeout(() => {  location.reload(); }, 100);
            }
            function deleteFile(id)
            {
                var eid = "del"+id;
                location = document.getElementById(eid).value;
                $.ajax({
					url : "manipulations/delete.php",
					type : 'post',
					data: {"id":id},
					success: function(data) {
						console.log(data);
					},
					error: function() {
						console.log('An error occurred');
					}
				});
				//setTimeout(() => {  location.reload(); }, 100);
                alert('deleting');
            }
            
            
        </script>

        <nav style = "width:97.5%;height:5%;padding:15px;background:rgb(0,162,232)">
			<div style = "text-align:center;display:inline">
				
                <button id = "home" onclick = "goHome()">
                    <i class="fa fa-home">Home</i>
                </button>
				
				<?php

					$session_id = $_POST['session_id'];
                    $sub_id = $_POST['subject_id'];
                    $assgn_id = $_POST['assgn_id'];
                    $type = $_POST['type'];

				?>
				<div id="session" >
					<span style = "font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;">Session: </span>
					<?php
                        $query = "select name from sessions where id=".$session_id.";";
                        $result = mysqli_query($link,$query);
                        $result_name = mysqli_fetch_assoc($result);
                        $session_name = $result_name['name'];
						echo $session_name;
					?>
				</div>
                <i class = "fa fa-angle-double-right"></i>
                <div id="session" >
					<span style = "font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;">Subject: </span>
					<?php
                        
                        $query = "select name from subject where id=".$sub_id.";";
                        $result = mysqli_query($link,$query);
                        $result_name = mysqli_fetch_assoc($result);
                        $sub_name = $result_name['name'];
						echo $sub_name;
                        $str = "<script>listFiles('".$type."',".$sub_id.",".$assgn_id.");</script>";
                        echo $str;
					?>
				</div>
                <i class = "fa fa-angle-double-right"></i>
                <div id="session" >
					<span style = "font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;">
					<?php
                        $types = array("General Assignment"=>"general_assignments","Lab"=>"lab","Project"=>"project","Note"=>"notes");
                        $types1 = array("general"=>"General Assignment","lab"=>"Lab","project"=>"Project","notes"=>"Note");
                        $query = "select name from ".$types[$types1[$type]]." where id=".$assgn_id.";";
                        $result = mysqli_query($link,$query);
                        $result_name = mysqli_fetch_assoc($result);
                        $name = $result_name['name'];
                        $assgn_name = $name;
                        echo $types1[$type].": </span>";
						echo $name;
                        $deadline = 0;
                        $query = "select deadline from ".$types[$types1[$type]]." where subject_id=".$sub_id.";";
                        $result = mysqli_query($link,$query);
                        $result_dl = mysqli_fetch_assoc($result);
                        $deadline = $result_dl['deadline'];

                        $currdate = date('Y-m-d')." ".date('H:m:s');
                        $neg = false;
                        if(strcmp($currdate,$deadline)>0)
                        $neg = true;
                        
                        $datetime1 = new DateTime(date('Y-m-d')." ".date('H:m:s'));
                        $datetime2 = new DateTime($deadline);
                        $difference = $datetime1->diff($datetime2);
                        $s = $difference->format("%a:%h:%i:%s");
                        $times = explode(":",$s);
                        $weight = array(24*60*60,24*60,24,1);
                        $units = array('day(s)','hour(s)','minute(s)','second(s)');
                        $seconds = 0;
                        foreach($times as $m=>$n)
                        {
                            $times[$m] = (int)$n;
                            if($neg)
                            $times[$m] = 0-$times[$m];
                            $seconds +=$times[$m]*$weight[$m];
                        }
                        //echo $weighted_sum." &nbsp";
                        //print_r($times);
                        echo "<input type='number' name='seconds' id='seconds' value='".$seconds."' hidden>";
                        //$progress = ((31*24*60*60)-$seconds)/ (31*24*60*60)*100;
                        //echo "hmm ".$progress;
					?>
				</div>
			</div>
		</nav>
        <div id = "new-file">
			<span style="color:black;font-weight:bold;font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif">
            Upload file from Computer
            </span>
			<button class="cancel" onclick="closeAddForm()"><i class="fa fa-times"> </i></button>
			<br><br>
			<form id = "add-topic" method="post" action="manipulations/upload.php" enctype="multipart/form-data" target="upload_target">
				
                Upload file: <input type="file" id="file0" name="file0" required/>
				<?php 
                    
                    //echo "<input type='number' id='session_id' name='session_id' value=".$session_id." hidden>";
                    echo "<input type='number' id='subject_id' name='subject_id' value=".$sub_id." hidden>";
                    echo "<input type='text' id='session_name' name='session_name' value='".$session_name."' hidden>";
                    echo "<input type='text' id='subject_name' name='subject_name' value='".$sub_name."' hidden>";
                    echo "<input type='text' id='assgn_name' name='assgn_name' value='".$assgn_name."' hidden>";
                    echo "<input type='number' id='assgn_id' name='assgn_id' value=".$assgn_id." hidden>";
                    echo "<input type='text' id='type' name='type' value=".$type." hidden>";
                ?>
				
                <input type="submit" name="submitBtn" value="Upload" onclick="doneUploading()"/>
			</form>
            <!--<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>-->
			<?php
                    /*$str = '<button type = "button" id = "file-add-btn"onclick="';
                    $str = $str."uploadFile('".$session_name."','".$sub_name."','".$assgn_name."')";
                    $str = $str.'">';
                    $str = $str.'<i class="fa fa-upload">Upload</i></button>';
                    echo $str;*/
            ?>
            <iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;"></iframe>
		</div>
        <div style = "padding: 15px; border-radius: 15px 50px; width:70%; margin: 40 auto; background: white; box-shadow: 0px 2px 20px 1px rgb(45,45,45)">
			<div style = "padding:5px;text-align:center">
				<h2 style = "font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;">Files</h2>
				
			</div>
			<div id="files">
						
			</div>
			<div id="file-upload">
                <button type = "button" onclick="openAddForm()">
					<i class="fa fa-upload">Upload file</i>
				</button>
			</div>
            <div id="file-create">
            
				<button type = "button" id = "subject-add-btn"onclick="createFile()">
					<i class="fa fa-plus">Create File</i>
				</button>
			</div>
            <?php
            $str = '<button onclick="';
            $str=$str."changeSubStat('".$types[$types1[$type]]."',".$assgn_id.")";
            $str = $str.'">';
            $str = $str.'Change submission status</button>';
            echo $str;
            ?>
		</div>
        <div>
            <!--<button><i class="fa fa-file-word-o fa-3x" aria-hidden="true">Hmm</i></button>-->
            <!--<button><i class="fa fa-file-powerpoint-o fa-3x" aria-hidden="true">Hmm</i></button>-->
            
        </div>
        <script>
            
            $(document).ajaxComplete(function() {
                if ($('#sub_stat').length && $('#timer').length) {
                    var sub_stat = document.getElementById('sub_stat').value;
                    //alert(sub_stat);
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
                            //alert("in");
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
                            else if(sec>0){
                                sec-=1;
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
                                else{
                                    sec-=1;
                                }
                                document.getElementById('timer').innerHTML="Deadline passed by: "+days+":"+hrs+":"+min+":"+sec;
                                document.getElementById('timer').style.color = 'red';
                            }
                        },1000);
                    }
                }
            });

            
            
        </script>
    </body>
</html>