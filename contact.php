<?php include 'inc/header.php'; ?>

<style>
	.contact_error{
		color: red;
		float: left;
	}
	td{
		width: 5%;
	}
</style>
	<?php 
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$firstname = $fm->validation($_POST['firstname']);
			$lastname = $fm->validation($_POST['lastname']);
			$email = $fm->validation($_POST['email']);
			$body = $fm->validation($_POST['body']);

			$firstname = mysqli_real_escape_string($db->link, $firstname);
			$lastname = mysqli_real_escape_string($db->link, $lastname);
			$email = mysqli_real_escape_string($db->link, $email);
			$body = mysqli_real_escape_string($db->link, $body);

			$error_fname = "";
			$error_lname = "";
			$error_email = "";
			$error_message = "";
			if(empty($firstname)){
				$error_fname = "First Name must not be empty";
			}
			if(empty($lastname)){
				$error_lname = "Last Name must not be empty";
			}
			if(empty($email)){
				$error_email = "Email must not be empty";     //individually error
			}
			// if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			// 	$error_ = "Invalid Email Address !";
			// }
			if(empty($body)){
				$error_message = "Message must not be empty";
			}

		/*	$error ="";
			if(empty($firstname)){
				$error = "FIrst Name must not be empty";
			}elseif(empty($lastname)){
				$error = "lastname Name must not be empty";
			}elseif(empty($email)){                              // one error for all field
				$error = "email must not be empty";
			}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error = "Invalid Email Address !";
			}elseif(empty($body)){
				$error = "Message must not be empty";
			}	*/ 
			else{
				$query ="INSERT INTO tbl_contact (firstname, lastname, email, body) VALUES ('$firstname', '$lastname', '$email', '$body')";
				$inserted_rows = $db->insert($query);

				if($inserted_rows){
					 $msg = "Message Sent Successfully";
				}else{
					 $msg = "Message Not Sent!";
				}
			}
		}	
	?>


	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">
				<h2>Contact us</h2>
				<?php 
				/*	if(isset($error)){
						echo "<span style='color: red'>$error</span>";
					} */
					if(isset($msg)){
						echo "<span style='color: green'>$msg</span>";
					} 
				?>
				<?php 
				
				?>
			<form action="contact.php" method="post">
				<table>
				<tr>
					<td>Your First Name:</td>
					<td>
					<?php if(isset($error_fname)){
						echo "<span class='contact_error'>$error_fname</span>"; 
					}
					?>
					<input type="text" name="firstname" placeholder="Enter first name"/>
					<!-- <input type="text" name="firstname" placeholder="Enter first name" required="1"/> -->
					</td>
				</tr>
				<tr>
					<td>Your Last Name:</td>
					<td>
					<?php if(isset($error_lname)){
						echo "<span class='contact_error'>$error_lname</span>"; 
					}
					?>
					<input type="text" name="lastname" placeholder="Enter Last name"/>
					<!-- <input type="text" name="lastname" placeholder="Enter Last name" required="1"/> -->
					</td>
				</tr>
				
				<tr>
					<td>Your Email Address:</td>
					<td>
					<?php if(isset($error_email)){
						echo "<span class='contact_error'>$error_email</span>"; 
					}
					?>
					<input type="email" name="email" placeholder="Enter Email Address"/>
					<!-- <input type="email" name="email" placeholder="Enter Email Address" required="1"/> -->
					</td>
				</tr>
				<tr>
					<td>Your Message:</td>
					<td>
					<?php if(isset($error_message)){
						echo "<span class='contact_error'>$error_message</span>"; 
					}
					?>
					<textarea name="body"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
					<input type="submit" name="submit" value="Send"/>
					</td>
				</tr>
		</table>
	<form>				
 </div>
</div>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/footer.php'; ?>