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
				$username = $fm->validation($_POST['username']);
				$password = $fm->validation(md5($_POST['password']));

				$username = mysqli_real_escape_string($db->link, $username);
				$password = mysqli_real_escape_string($db->link, $password);

				if($username == "" || $password == ""){
					$error = "Field must not be empty";
				}else{
					$query = "SELECT * FROM tbl_user WHERE username = '$username' AND password = '$password' ";
					$result = $db->select($query);

					if($result != false){
						$value = mysqli_fetch_array($result);
						// $value = $result->fetch_assoc();
						// $row = mysqli_num_rows($result);
						// if($row > 0){
							Session::set("login", true);
							Session::set("userId", $value['id']);
							Session::set("userName", $value['username']);
							Session::set("userRole", $value['role']);
							// Debugging role output
							// echo "<p>Role from DB: " . $value['role'] . "</p>";

							header("Location: index.php"); // admin er index
						// }else{
						// 	echo "<span style='color: red; font-size: 18px;'>No Result found</span>";
						// }
					}else{
						echo "<span style='color: red; font-size: 18px;'>Username or Password not matched!!..</span>";
					}
				}
			}
		?>
		<form action="login.php" method="post">
			<h1>Admin Login</h1>
			<div>
				<input type="text" required="" name="username" placeholder="Username"/>
			</div>
			<div>
				<input type="password" required="" name="password" placeholder="Password"/>
			</div>
			<div>
				<input type="submit" value="Log in" />
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="forgetpass.php">Forgot Password !</a>
		</div><!-- button -->
		<div class="button">
			<a href="#">Training with live project</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>