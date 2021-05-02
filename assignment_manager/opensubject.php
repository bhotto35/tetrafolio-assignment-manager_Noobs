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
        #assignment-add{
            width:70%;
            margin: 0 auto;
            top:10%;
            padding:10px
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
        #assignment-add-btn{
            border:none;
            padding:7px;
            font:Lucida, sans-serif;
            background:darkgray;
            color:white
        }
        #assignment-add-btn:hover{
            background:violet;
        }
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
        .assignment-topic{
            font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;
            text-align:center;
        }
        #new-assignment{
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
            function delete_(tablename,id,name)
            {
                var x = confirm("Are you sure you want to delete"+name+" from "+tablename+"?");
                if(x)
                {
                    $.ajax({
					url : "manipulations/delassgn.php",
					type : 'post',
					data: {"tablename":tablename,"id":id},
					success: function(data) {
						console.log('success');
						
					},
					error: function() {
						console.log('An error occurred');
					}
				});
                setTimeout(() => {  location.reload(); }, 100);
                }
                //alert("deleting");
            }
            var tablename="";
            function openAddForm(tb)
            {
                tablename = tb;
                document.getElementById("category").innerHTML="Add to "+tb;
                document.getElementById("new-assignment").style.display="block";
            }
            function closeAddForm()
            {
                document.getElementById("new-assignment").style.display="none";
            }
            function  add()
            {
                var subject_id = document.getElementById("subject_id").value;
                var deadline = document.getElementById("deadline").value;
                var name = document.getElementById("name").value;
                $.ajax({
                    url : "manipulations/newassgn.php",
                    type : 'post',
                    data: {"subject_id":subject_id,"tablename":tablename,"name":name,"deadline":deadline},
                    success: function(data) {
                        console.log('success');
                    },
                    error: function() {
                        console.log('An error occurred');
                        alert('Error!')
                    }
                });
                setTimeout(() => {  location.reload(); }, 100);

            }
            function openAssignment(subject_id,assgn_id,type,session_id)
            {
                const form=document.createElement('form');
                form.method='post';
                form.action='openassgn.php';
                const subject_id_ = document.createElement('input');
                subject_id_.type = 'hidden';
                subject_id_.name = 'subject_id';
                subject_id_.value = subject_id;
                form.appendChild(subject_id_);
                const assgn_id_ = document.createElement('input');
                assgn_id_.type = 'hidden';
                assgn_id_.name = 'assgn_id';
                assgn_id_.value = assgn_id;
                form.appendChild(assgn_id_);
                const type_ = document.createElement('input');
                type_.type = 'hidden';
                type_.name = 'type';
                type_.value = type;
                form.appendChild(type_);
                const session_id_ = document.createElement('input');
                session_id_.type = 'hidden';
                session_id_.name = 'session_id';
                session_id_.value = session_id;
                form.appendChild(session_id_);
                document.body.appendChild(form);
                form.submit();
            }
            function listAssignments(session_id,subject_id){
                $.ajax({
                    url : "assignments.php",
                    type : 'post',
                    data: {"session_id":session_id,"subject_id":subject_id},
                    async:true,
                    success: function(data) {
                        $('#assignment').html(data);
                    },
                    error: function() {
                        $('#assignment').text('An error occurred');
                    }
                });
                
            }
        </script>
        <nav style = "width:97.5%;height:5%;padding:15px;background:rgb(0,162,232)">
			<div style = "text-align:center;display:inline">
				
                <button id = "home" onclick = "goHome()">
                    <i class="fa fa-home">Home</i>
                </button>
				
				<?php
                    /*if(isset($_POST))
                    $_SESSION['session_id'] = $_POST['sess_id'];*/
                    
                  
                    $sub_id = $_POST['sub_id'];
                    $session_id = $_POST['sess_id'];
                    //echo "sub_id: ".$sub_id." sess_id: ".$session_id;
                    
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
                        $str = "<script>listAssignments(".$session_id.",".$sub_id.");</script>";
                        echo $str;
					?>
				</div>
			</div>
		</nav>
        <div id = "new-assignment">
			<span id="category"style="color:black;font-weight:bold;font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif"></span>
			<button class="cancel" onclick="closeAddForm()"><i class="fa fa-times"> </i></button>
			<br><br>
			<form id = "add-topic" method="post" action="">
				<table><tr><td>
				<span style="font-size:12px">Name of assignment:</span></td>
				<td> <input type="text" id="name" name="name" required/></td></tr>
                <tr><td>
				<span style="font-size:12px">Deadline:</span></td>
				<td> <input type="date" id="deadline" name="deadline" required/></td>
				<?php 
                    echo "<input type='number' id='session_id' name='session_id' value='".$session_id."' hidden>";
                    echo "<input type='number' id='subject_id' name='subject_id' value='".$sub_id."' hidden>";
                ?>
				</tr></table>
			</form>
			<button onclick="add()">Add</button>
		</div>
        <div style = "padding: 15px; border-radius: 15px 50px; width:70%; margin: 40 auto; background: white; box-shadow: 0px 2px 20px 1px rgb(45,45,45)">
			<div style = "padding:5px;text-align:center">
				<h2 style = "font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;">Assignments</h2>
			</div>
            
            <div id = "assignment">
            </div>
		</div>
    </body>
</html>