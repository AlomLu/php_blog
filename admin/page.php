<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>
<style>
    .actiondel{
        margin-left: 10px;
    }
.actiondel a{
    border: 1px solid #ddd;
    color: ##F0F0F0;
    cursor: pointer;
    font-size: 20px;
    padding: 4px 10px;
    font-weight: normal;
    background: #f0f0f0 none repeat scroll 0 0;

}
</style>
        <div class="grid_10">
        <?php 
            // if(!isset($_GET['pageid']) || $_GET['pageid'] == NULL ){
            //     echo "<script>window.location = 'index.php'</script>";
            // }else{
            //     $id = $_GET['pageid'];
            // }
            
            if(isset($_GET['pageid'])){
                $id = $_GET['pageid'];
            }else{
                echo "<script>window.location = 'index.php'</script>";
            }

        ?>
            <div class="box round first grid">
                <?php echo $id ?>
                <h2>Edit Page</h2>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $name = mysqli_real_escape_string($db->link, $_POST['name']);
                        $body = mysqli_real_escape_string($db->link, $_POST['body']);
                        
                  

                        if($name == "" || $body == "" ){
                            echo "<span class='error'>Feild must not be empty!.</sapn>";
                        }else{
                           $query = "UPDATE tbl_page
                                        SET
                                        name = '$name',
                                        body = '$body'
                                        WHERE id = '$id' ";
                           $updated_row = $db->update($query);
                           if ($updated_row) {
                            echo "<span class='success'>Page Updated Successfully.</span>";
                           }else {
                            echo "<span class='error'>Page Not Updated !</span>";
                           }
                        }
                    }
                ?>

                <div class="block">   
                    <?php
                        $query = "SELECT * FROM tbl_page WHERE id = '$id' ";
                        $page_details = $db->select($query);

                        if($page_details){
                            while($result = $page_details->fetch_assoc()){
                        
                    
                    ?>            
                    <form action="page.php?pageid=<?php echo $id; ?>" method="POST" >
                        <table class="form">
                        
                            <tr>
                                <td>
                                    <label>Name</label>
                                </td>
                                <td>
                                    <input type="text" name="name"  value="<?php echo $result['name']?>" class="medium" />
                                </td>
                            </tr>
                        
                            <tr>
                                <td style="vertical-align: top; padding-top: 9px;">
                                    <label>Content</label>
                                </td>
                                <td>
                                    <textarea name="body" class="tinymce">
                                    <?php echo $result['body'] ?>
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="submit" Value="Update"/>
                                    <?php
                                        if($_SESSION['userRole'] == '3'){ ?>
                                            <span class="actiondel"><a onclick="confirm('Are you sure to delete!')" href="deletepage.php?delpageid=<?php echo $result['id']; ?>">Delete</a></span>
                                      <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php } ?>
                <?php } ?>
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

