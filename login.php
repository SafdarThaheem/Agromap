<?php include 'php/config.php';

    session_start();
    
    if(isset($_POST['submit'])){

			

			$pdo = new PDO($dsn, $user, $password, $opt);

			$password = md5($_POST['password']);
			$query = "SELECT username, password FROM " . '"Proyecto_Arroz"' . "." . '"user_info"' . 
						"WHERE username = '{$_POST['username']}' and password = '{$password}';";

			$result = $pdo->query($query);

			if ($result->rowCount() > 0){

				foreach ($result as $row) {
					$_SESSION['username'] = $row['username'];

					header("Location: index.php");
				}
				 
			}else{
				echo '<div class="alert alert-danger">username or password incorrect</div>';
			}
    	}
    ?>

<!DOCTYPE html>
<html>
<head>
	<title>agromap</title>
	
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    
    <style type="text/css">
    	body, html {
		    height: 100%;
		    background-repeat: no-repeat;
			background-color: #585858;
		    /* background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33)); */
		}

		.card-container.card {
		    max-width: 466px;
			max-height: 555px;
		    padding: 40px 40px;
		}

		.btn {
		    font-weight: 700;
		    height: 36px;
		    -moz-user-select: none;
		    -webkit-user-select: none;
		    user-select: none;
		    cursor: default;
		}

		/*
		 * Card component
		 */
		.card {
		    background-color: #FFFFFF;
		    /* just in case there no content*/
		    padding: 20px 25px 30px;
		    margin: 0 auto 25px;
		    margin-top: 50px;
		    /* shadows and rounded borders */
		    -moz-border-radius: 2px;
		    -webkit-border-radius: 2px;
		    border-radius: 2px;
		    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		}

		.profile-img-card {
		    width: 288px;
		    height: 148.43px;
		    margin: 0 auto 10px;
		    display: block;
		    -moz-border-radius: 50%;
		    -webkit-border-radius: 50%;
		    border-radius: 0%;
		}

		/*
		 * Form styles
		 */
		.profile-name-card {
		    font-size: 16px;
		    font-weight: bold;
		    text-align: center;
		    margin: 10px 0 0;
		    min-height: 1em;
		}

		.reauth-email {
		    display: block;
		    color: #404040;
		    line-height: 2;
		    margin-bottom: 10px;
		    font-size: 14px;
		    text-align: center;
		    overflow: hidden;
		    text-overflow: ellipsis;
		    white-space: nowrap;
		    -moz-box-sizing: border-box;
		    -webkit-box-sizing: border-box;
		    box-sizing: border-box;
		}

		.form-signin #inputEmail,
		.form-signin #inputPassword {
		    direction: ltr;
		    height: 58px;
		    font-size: 20px;
		}

		.form-signin input[type=email],
		.form-signin input[type=password],
		.form-signin input[type=text],
		.form-signin button {
		    width: 100%;
		    display: block;
		    margin-bottom: 10px;
		    z-index: 1;
		    position: relative;
		    -moz-box-sizing: border-box;
		    -webkit-box-sizing: border-box;
		    box-sizing: border-box;
		}

		.form-signin .form-control:focus {
		    border-color: rgb(104, 145, 162);
		    outline: 0;
		    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
		    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
		}

		.btn.btn-signin {
		    /*background-color: #4d90fe; */
		    background-color: rgb(119, 185, 72);
		    /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
		    padding: 0px;
		    font-weight: bold;
		    font-size: 25px;
		    height: 58px;
		    -moz-border-radius: 3px;
		    -webkit-border-radius: 3px;
		    border-radius: 15px;
		    border: none;
		    -o-transition: all 0.218s;
		    -moz-transition: all 0.218s;
		    -webkit-transition: all 0.218s;
		    transition: all 0.218s;
		}

		.btn.btn-signin:hover,
		.btn.btn-signin:active,
		.btn.btn-signin:focus {
		    background-color: rgb(73, 144, 22);

		}

		.forgot-password {
		    color: rgb(104, 145, 162);
		}

		.forgot-password:hover,
		.forgot-password:active,
		.forgot-password:focus{
		    color: rgb(12, 97, 33);
		}

		label{
			font-size: 17px;
		}

		.checkbox input{
			width: 16px;
			height: 16px;
		}

    </style>
</head>
<body>
			
	<div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="images/AgroMap.png">
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" action="" method="POST" >
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" name="username" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me" >  Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" name="submit" type="submit">Sign in</button>
            </form><!-- /form -->
            <a href="#" class="forgot-password" style="">
                Forgot the password?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->

    
</div>
</body>
</html>