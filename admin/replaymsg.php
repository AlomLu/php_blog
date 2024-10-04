<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>
        <div class="grid_10">
		
        <?php 
            if(!isset($_GET['msgid']) || $_GET['msgid'] == NULL){
                echo "<script>window.location = 'inbox.php' </script";
            }else{
                $id = $_GET['msgid'];
            }
        
        ?>
            <div class="box round first grid">
                <h2>View Message</h2>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $toEmail = $fm->validation($_POST['toEmail']);
                        $fromEmail = $fm->validation($_POST['fromEmail']);
                        $subject = $fm->validation($_POST['subject']);
                        $messsage = $fm->validation($_POST['messsage']);
                        $sendmail = mail($toEmail, $fromEmail, $subject, $subject);

                        if($sendmail){
                            echo "<span class='success'>Message Sent Successfully.</span>";
                        }else{
                            echo "<span class='error'>Something Wnet Wrong !</span>";
                        }
                    }
                ?>

                <div class="block"> 
                    <?php 
                        $query = "SELECT * FROM tbl_contact WHERE id = '$id' ";
                        $get_message = $db->select($query);

                        if($get_message){
                            while($result = $get_message->fetch_assoc()){

                         
                    ?>        
                    <form action="" method="POST" >
                        <table class="form">
                        
                            <tr>
                                <td>
                                    <label>To</label>
                                </td>
                                <td>
                                    <input type="text" readonly name="toEmail" value="<?php echo $result['email']; ?>" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>From</label>
                                </td>
                                <td>
                                    <input type="text" name="fromEmail" placeholder="Enter Your Email Address" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Subject</label>
                                </td>
                                <td>
                                    <input type="text" name="subject" placeholder="Enter Subject" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Content</label>
                                </td>
                                <td>
                                    <textarea name="message" class="tinymce">

                                    </textarea>
                                </td>
                            </tr>
                        
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="submit" Value="Send" />
                                </td>
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
<?php include 'inc/footer.php' ?>

