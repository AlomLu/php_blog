

<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php 
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
    $user_name = $_SESSION['userName'];
    $user_role = $_SESSION['userRole'];
    $user_id = $_SESSION['userId']; 
    // $user_name = Session::get('userName');
    // $user_role = Session::get('userRole');
    // $user_id = Session::get('userId');  // Use Session::get('userId')

    // Debugging output
    echo "user Id ". $user_id . "<br/>";
    echo "user Name ".$user_name . "<br/>";
    echo "user Role ".$user_role;
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Profile</h2>
        <?php

        ?>

        <?php 
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = mysqli_real_escape_string($db->link, $_POST['name']);
            $username = mysqli_real_escape_string($db->link, $_POST['username']);
            $email = mysqli_real_escape_string($db->link, $_POST['email']);
            $details = mysqli_real_escape_string($db->link, $_POST['details']);

            if(empty($name) || empty($username) || empty($email) || empty($details)){
                echo "<span class='error'>Field must not be empty</sapn>";
            }else{
                $query = "UPDATE tbl_user
                SET
                name = '$name',
                username = '$username',
                email = '$email',
                details = '$details'
                WHERE id = '$user_id' ";

                $row_updated = $db->update($query);

                if($row_updated){
                    echo "<span class='success'>Profile Updated Successfully</sapn>";
                }else{
                    echo "<span class='error'>Profile Not Updated</sapn>";
                }
            }


            
           }
        
        ?>
        
        <div class="block">
            <?php 
                $query = "SELECT * FROM tbl_user WHERE id = '$user_id' AND role = '$user_role' ";
                // $query = "SELECT * FROM tbl_user WHERE id = '$user_id' AND role = '$user_role' ";
                $get_user = $db->select($query);

                if($get_user){
                    while($result = $get_user->fetch_assoc()){

                    
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td><label>Name</label></td>
                        <td><input type="text" name="name" value="<?php echo $result['name']; ?>"  class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>User Name</label></td>
                        <td><input type="text" name="username" value="<?php echo $result['username']; ?>"  class="medium" /></td>
                        <!-- <td><input type="text" name="name" value="<?php echo $_SESSION['userName']; ?>"  class="medium" /></td> -->
                    </tr>
                    <tr>
                        <td><label>Email</label></td>
                        <td><input type="text" name="email" value="<?php echo $result['email']; ?>"  class="medium" /></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Details</label>
                        </td>
                        <td>
                            <textarea name="details" class="tinymce">
                                <?php echo $result['details']; ?>
                            </textarea>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td><label>Role</label></td>
                        <td><input type="text" name="role" value="<?php echo $_SESSION['userRole']; ?>"  class="medium" /></td>
                    </tr> -->

                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" Value="Update" /></td>
                    </tr>
                </table>
            </form>
        <?php } } ?>
        </div>
    </div>
</div>

<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>

<?php include 'inc/footer.php'; ?>
