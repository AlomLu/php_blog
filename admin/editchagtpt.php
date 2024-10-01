<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>
        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Update Post</h2>
                <?php 
                    if(isset($_GET['post_id'])){
                        // echo "<span>{$_GET['post_id']}</span>";
                        $post_id = $_GET['post_id'];
                    }else{

                    }

                    // if(!isset($_GET['post_id']) || $_GET['post_id'] == NULL){
                    //     // header("Location: postlist.php");
                    //     // exit();
                    //     echo "<script>window.location = 'postlist.php' </script>";
                    // }else{
                    //     $post_id = $_GET['post_id'];
                    //     echo $post_id;
                    // }
                    
                ?>
               <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $title = mysqli_real_escape_string($db->link, $_POST['title']);
                        $cat_id = mysqli_real_escape_string($db->link, $_POST['cat_id']);
                        // $image = mysqli_real_escape_string($db->link, $_POST['image']);
                        $body = mysqli_real_escape_string($db->link, $_POST['body']);
                        $tags = mysqli_real_escape_string($db->link, $_POST['tags']);
                        $author = mysqli_real_escape_string($db->link, $_POST['author']);
                        
                        $permited  = array('jpg', 'jpeg', 'png', 'gif');
                        $file_name = $_FILES['image']['name'];
                        $file_size = $_FILES['image']['size'];
                        $file_temp = $_FILES['image']['tmp_name'];

                        $div = explode('.', $file_name);
                        $file_ext = strtolower(end($div));
                        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
                        $uploaded_image = "upload/".$unique_image;

                        if($title == "" || $cat_id == "" || $body == "" || $tags == "" || $author == ""){
                            echo "<span class='error'>Feild must not be empty!.</sapn>";
                        }else{
                            if(!empty($file_name)){
                                if ($file_size >1048567) {
                                    echo "<span class='error'>Image Size should be less then 1MB!
                                    </span>";
        
                                   } elseif (in_array($file_ext, $permited) === false) {
                                    echo "<span class='error'>You can upload only:-"
                                    .implode(', ', $permited)."</span>";
        
                                   } else{
                                   move_uploaded_file($file_temp, $uploaded_image);
                                   $query = "UPDATE tbl_post
                                   SET
                                   cat_id = '$cat_id',
                                   title = '$title',
                                   body = '$body',
                                   image = '$image',
                                   author = '$author',
                                   tags = '$tags'
                                   WHERE id = '$post_id' ";
                                   $updated_row = $db->update($query);
                                    if ($updated_row) {
                                        echo "<span class='success'>Data Updated Successfully.</span>";
                                    }else {
                                        echo "<span class='error'>Data Not Updated !</span>";
                                    }
                                }
                            }else{
                                $query = "UPDATE tbl_post
                                SET
                                cat_id = '$cat_id',
                                title = '$title',
                                body = '$body',
                                author = '$author',
                                tags = '$tags'
                                WHERE id = '$post_id' ";
                                // alert($query);
                                $updated_row = $db->update($query);
                                    if ($updated_row) {
                                    echo "<span class='success'>Data Updated Successfully.</span>";
                                    }else {
                                    echo "<span class='error'>Data Not Updated !</span>";
                                    }
                            }
                        }
                    }
                ?>

                <div class="block">               
                    <?php 
                    
                        // $query = "SELECT tbl_post.*, tbl_category.name FROM tbl_post
                        // INNER JOIN tbl_category
                        // ON tbl_post.cat_id = tbl_category.id
                        // WHERE tbl_post.id='$post_id'";
                        // $post = $db->select($query);
                        $query = "SELECT * FROM tbl_post WHERE id='$post_id'";
                        $post = $db->select($query);
                        
                        if($post){
                            while($post_result = $post->fetch_assoc()){
                                
                    ?>
                    <form action="editpost.php" method="POST" enctype="multipart/form-data">
                        <table class="form">
                        
                            <tr>
                                <td>
                                    <label>Title</label>
                                </td>
                                <td>
                                    <input type="text" name="title" value="<?php echo $post_result['title']; ?>"  class="medium" />
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    <label>Category</label>
                                </td>
                                <td>
                                    <select id="select" name="cat_id">
                                        <option>Select Category</option>
                                        <?php 
                                            $query = "SELECT * FROM tbl_category";
                                            $category = $db->select($query);
                                            if($category){
                                                while($result = $category->fetch_assoc()){
                                        ?>
                                            <option value="<?php echo $result['id'] ?>"><?php echo $result['name']; ?></option>
                                        <?php } ?>
                                        <?php }else{ ?>
                                            echo "<span>No Category availble</span>";
                                            <?php } ?>
                                    </select>
                                </td>
                            </tr>
                    
                        
                            <!-- <tr>
                                <td>
                                    <label>Date Picker</label>
                                </td>
                                <td>
                                    <input type="text" id="date-picker" />
                                </td>
                            </tr> -->
                            <tr>
                                <td>
                                    <label>Upload Image</label>
                                </td>
                                <td>
                                    <img src="<?php echo $post_result['image'] ?>" height="100px" width="200px" alt="">
                                        </br>
                                    <input name="image" type="file" />
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top; padding-top: 9px;">
                                    <label>Content</label>
                                </td>
                                <td>
                                    <textarea name="body" class="tinymce">
                                    <?php echo $post_result['body']; ?>
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Tags</label>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $post_result['tags']; ?>" name="tags"   class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Author</label>
                                </td>
                                <td>
                                    <input type="text" name="author"  value="<?php echo $post_result['author']; ?>"  class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="submit" Value="Save" />
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

