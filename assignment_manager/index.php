<?php
	require 'dbconn.php'
?>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!--<link rel="icon" href="%PUBLIC_URL%/favicon.ico" />-->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="theme-color" content="#000000" />
		<meta
			name="description"
			content="Web app for Assignment Management"
		/>
		<style>
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
			#session:hover{
				cursor:pointer;
				background:slateblue;
				color:white;
			}
			#session-list{
				background: rgba(24,24,24,0.6);
				position:relative;
				top:20px;
				display:none;
				color:white;
				box-shadow:0px 2px 15px 1px rgb(145,145,145);
				padding:5px;
			}
			.session-list-elements{
				display:block;
				background: gray;
				padding:7px;
				cursor:pointer;
			}
			.session-list-elements:hover{
				background:darkgray;
			}
			#add-session{
				padding:5px;
				width:100%;
				background:gray;
				border:none;
			}
			#add-session:hover{
				background:darkgray;
			}
			#subject-add{
				width:70%;
				margin: 0 auto;
				top:10%;
				padding:10px
			}
			#subject-add-btn{
				border:none;
				padding:7px;
				font:Lucida, sans-serif;
				background:darkgray;
				color:white
			}
			#subject-add-btn:hover{
				background:violet;
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
			#new-topic{
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
			input{
				padding:5px;
				border-radius:12px;
				background:gray;
				
				outline:none;		
			}
			input:focus{
				background:white;
				box-shadow:0px 1px 5px 3px lightyellow;
			}
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
		function toggle_session_list()
		{
			var x = document.getElementById("session-list");
			if (x.style.display === "none") {
				x.style.display = "block";
			} else {
				x.style.display = "none";
			}
		}
		function openSubject(sess_id,sub_id){
			//alert(sess_id+" "+sub_id);
			const form=document.createElement('form');
			form.method='post';
			form.action='opensubject.php';
			//pwd_0.style.visibility='hidden';
			const sess_id_ = document.createElement('input');
			sess_id_.type = 'hidden';
			sess_id_.name = 'sess_id';
			sess_id_.value = sess_id;
			form.appendChild(sess_id_);
			const sub_id_ = document.createElement('input');
			sub_id_.type = 'hidden';
			sub_id_.name = 'sub_id';
			sub_id_.value = sub_id;
			form.appendChild(sub_id_);
			document.body.appendChild(form);
			form.submit();
		}
		function closeNewTopicForm()
		{
			document.getElementById("new-topic").style.display="none";
		}
		function openNewTopicForm()
		{
			document.getElementById("new-topic").style.display="block";
		}
		function addTopic()
		{
			var name = document.getElementById('topic-name').value;
			var sess_id = document.getElementById('session-id').value;
			$.ajax({
					url : "manipulations/newsubject.php",
					type : 'post',
					data: {"session_id":sess_id,"topic-name":name},
					success: function(data) {
						console.log(data);
					},
					error: function() {
						console.log('An error occurred');
					}
				});
				setTimeout(() => {  changeSession(sess_id); }, 100);
		}
		function changeSession(id){
			if(id!=0)
			{
				/*$.ajax({
					url : "topics.php",
					type : 'post',
					data: {"session_id":id},
					success: function(data) {
						$('#subject').html(data);
						console.log(data.subject);
						
					},
					error: function() {
						$('#subject').text('An error occurred');
					}
				});*/
				const form=document.createElement('form');
				form.method='post';
				form.action='index.php';
				//pwd_0.style.visibility='hidden';
				const sess_id_ = document.createElement('input');
				sess_id_.type = 'hidden';
				sess_id_.name = 'session-id';
				sess_id_.value = id;
				form.appendChild(sess_id_);
				document.body.appendChild(form);
				form.submit();
			}
				
		}
	</script>
	<body style = "background:rgb(129,135,145)">
		<header style="height:60%;width:100%;background-image:url('background.png');background-size:cover;">
			<h1 style = "font-size: 600%;font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;color:rgb(255,83,0);text-shadow: 0px 0px 12px rgb(254,135,56);padding: 20px; position:relative;top:30%;left:10%">
				SkedSetGo
			</h1>
			<h1 style = "font-size: 200%;font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;color:rgb(255,83,0);text-shadow: 0px 0px 12px rgb(254,135,56);padding: 20px; position:relative;top:10%;left:10%">
				Your Personal Assignment Manager
			</h1>
		</header>
		<nav style = "width:97.5%;height:5%;padding:15px;background:rgb(0,162,232)">
			<div style = "float:left">
				
				
				<?php
					/*if(!isset($_SESSION))
					session_start();
					$_SESSION['session-id']=0;
					$_SESSION['session-name']='';*/
					$session_id = 0;
					$session_name = '';
					$session_ids = array();
					$session_names = array();
					$query = "Select * from sessions;";
					$result = mysqli_query($link,$query);
					$num_rows = mysqli_num_rows($result);
					if($num_rows!=0)
					{
						while($result_array = mysqli_fetch_assoc($result))
						{
							$date = date('Y-m-d');
							if(strcmp($date,$result_array['end_date'])<=0 && strcmp($date,$result_array['start_date'])>=0)
							{
								$session_id = $result_array['id'];
								$session_name = $result_array['name'];
							}
							array_push($session_ids,$result_array['id']);
							array_push($session_names,$result_array['name']);
						}
						
					}
					if(isset($_POST['session-id']))
					{
						$session_id = $_POST['session-id'];
						$query = "select name from sessions where id = ".$session_id.";";
						$result = mysqli_query($link,$query);
						$result_arr = mysqli_fetch_assoc($result);
						$session_name = $result_arr['name'];
					}
					
				?>
				<div id="session" onclick = "toggle_session_list()" >
					Session: 
					<?php
						echo $session_name;
					?>
				</div>
				<div id = "session-list">
					<?php
						foreach($session_ids as $i=>$value)
						{
							$str = "<a class='session-list-elements' onclick='changeSession(".$value.")'>".$session_names[$i]."</a>";
							echo $str;
							/*$str2 = "<script>changeSession(".$session_id.");</script>";
							echo $str2;*/
						}
					?><br>
					<button id="add-session" type = "button" >
						<i class="fa fa-plus">Add session</i>
					</button>
					
				</div>
				
			</div>
			<div style="display:inline-block;padding-left:20px"><i class = "fa fa-home">Home </i></div>
		</nav>
		<div id = "new-topic">
			<span style="color:black;font-weight:bold;font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif">Add new topic</span>
			<button class="cancel" onclick="closeNewTopicForm()"><i class="fa fa-times"> </i></button>
			<br><br>
			<form id = "add-topic" method="post" action="">
				<table><tr><td>
				<span style="font-size:12px">Name of topic:</span></td>
				<td> <input type="text" id="topic-name" name="topic-name"/></td>
				<?php echo "<input type='number' id='session-id' name='session-id' value='".$session_id."' hidden>"?>
				</tr></table>
			</form>
			<button onclick="addTopic()">Add</button>
		</div>
		<div style = "padding: 15px; border-radius: 15px 50px; width:70%; margin: 40 auto; background: white; box-shadow: 0px 2px 20px 1px rgb(45,45,45)">
			<div style = "padding:5px;text-align:center">
				<h2 style = "font-family: 'Century Gothic', CenturyGothic, Geneva, AppleGothic, sans-serif;">Topics</h2>
				
			</div>
			<div id="subject">
			<div style = "width:70%; margin: 0 auto;top:10%;padding:10px">
				<?php
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
			</div>
			<div id="subject-add">
				<button type = "button" id = "subject-add-btn"onclick="openNewTopicForm()">
					<i class="fa fa-plus">Add Topic</i>
				</button>
			</div>
		</div>
		
	</body>
</html>