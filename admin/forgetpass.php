<?php 
	include '../lib/Session.php'; 
	Session::checkLogin();
?>

<?php include '../config/config.php'; ?>
<?php include '../lib/Database.php'; ?>
<?php include '../helpers/Format.php'; ?>

<?php 
	$db = new Database();
	$fm = new Format();
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
		<?php
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$email = $fm->validation($_POST['email']);
				$email = mysqli_real_escape_string($db->link, $email);

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    echo "<span style='color: red'>Invalid Email Address !</span>";
                }else{
                    $email_query = "SELECT * FROM tbl_user WHERE email = '$email' LIMIT 1";
                    $mail_check = $db->select($email_query);

					if($mail_check != false){
                        while($value = $mail_check->fetch_assoc()){
                            $userid = $value['id'];
                            $username = $value['username'];
                        }

                        //new password generate
                        $text = substr($email, 0, 3);
                        $rand = rand(10000, 99999);
                        $newpassword = "$text$rand";
                        $password = md5($newpassword);

                        $query = "UPDATE tbl_user
                                    SET
                                    password = '$password'
                                    WHERE id = '$userid' ";
                        $update_row = $db->update($query);

                        $to = "$email";
                        $from = "alucse1544@gmail.com";
                        $headers = "From: $from\n";
                        // To send HTML mail, the Content-type header must be set
                        $headers .= 'MIME-Version: 1.0';
                        $headers .= 'Content-type: text/html; charset=iso-8859-1';
                        $subject = "Your Password";
                        $message = "Your Username is ".$username." and password is ".$newpassword." please visit website to login";

                        $sendmail = mail($to, $subject, $message, $headers);

                        if($sendmail){
                            echo "<span style='color: green; font-size: 18px;'>Please check your email for new password.</span>";
                        }else{
                            echo "<span style='color: green; font-size: 18px;'>Email not sent</span>";
                        }
						
					}else{
						echo "<span style='color: red; font-size: 18px;'>Email Not Exist !</span>";
					}
				}
			}
		?>
		<form action="" method="post">
			<h1>Password Recovery</h1>
			<div>
				<input type="text" required="" name="email" placeholder="Enter valid Email"/>
			</div>
			<div>
				<input type="submit" value="Send Mail" />
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="login.php">Login</a>
		</div><!-- button -->
		<div class="button">
			<a href="#">Training with live project</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>