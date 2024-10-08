<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Slider</h2>

        <?php 
            // Check if 'post_id' exists in the URL, if not redirect to post list
            if (isset($_GET['slider_id'])) {
                $slider_id = $_GET['slider_id'];
            } else {
                // Redirect to post list if post_id is not set
                echo "<script>window.location = 'postlist.php';</script>";
                exit();
            }
        ?>
        


        <?php
            // Handle form submission
            echo "<p>$slider_id</p>";
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $title = mysqli_real_escape_string($db->link, $_POST['title']);

                $permited = array('jpg', 'jpeg', 'png', 'gif');
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_temp = $_FILES['image']['tmp_name'];

                $div = explode('.', $file_name);
                $file_ext = strtolower(end($div));
                $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                $uploaded_image = "upload/slider/" . $unique_image;

                // Check for empty fields
                if ($title == "") {
                    echo "<span class='error'>Field must not be empty!</span>";
                } else {
                    if (!empty($file_name)) {
                        // If a new image is uploaded, validate it
                        if ($file_size > 1048567) {
                            echo "<span class='error'>Image Size should be less than 1MB!</span>";
                        } elseif (in_array($file_ext, $permited) === false) {
                            echo "<span class='error'>You can upload only: " . implode(', ', $permited) . "</span>";
                        } else {
                            // Move the file to the upload directory and update with image
                            move_uploaded_file($file_temp, $uploaded_image);
                            $query = "UPDATE tbl_slider
                                      SET 
                                          title = '$title',
                                          image = '$uploaded_image'
                                      WHERE id = '$slider_id' ";
                            $updated_row = $db->update($query);
                            if ($updated_row) {
                                echo "<span class='success'>Slider Updated Successfully.</span>";
                            } else {
                                echo "<span class='error'>Slider Not Updated!</span>";
                            }
                        }
                    } else {
                        // Update the post without changing the image
                        $query = "UPDATE tbl_slider
                                  SET 
                                      title = '$title'
                                  WHERE id = '$slider_id'";
                        $updated_row = $db->update($query);
                        if ($updated_row) {
                            echo "<span class='success'>Slider Updated Successfully.</span>";
                        } else {
                            echo "<span class='error'>Slider Not Updated!</span>";
                        }
                    }
                }
            }
        ?>

        <div class="block">
            <?php 
                // Fetch the post data
                    // INNER JOIN tbl_category
                    // ON tbl_post.cat_id = tbl_category.id
                    // WHERE tbl_post.id='$post_id'";
                    // $post = $db->select($query);
                $query = "SELECT * FROM tbl_slider WHERE id='$slider_id'";
                $slider = $db->select($query);
                
                if ($slider) {
                    while ($result = $slider->fetch_assoc()) {
            ?>
            <form action="editslider.php?slider_id=<?php echo $slider_id; ?>" method="POST" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td><label>Title</label></td>
                        <td><input type="text" name="title" value="<?php echo $result['title']; ?>" class="medium" /></td>
                    </tr>

                    <tr>
                        <td><label>Upload Image</label></td>
                        <td>
                            <img src="<?php echo $result['image']; ?>" height="100px" width="200px" alt="">
                            <br />
                            <input name="image" type="file" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" Value="Update" /></td>
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

<?php include 'inc/footer.php'; ?>
