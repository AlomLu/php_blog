<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Post</h2>

        <?php 
            // Check if 'post_id' exists in the URL, if not redirect to post list
            if (isset($_GET['post_id'])) {
                $post_id = $_GET['post_id'];
            } else {
                // Redirect to post list if post_id is not set
                echo "<script>window.location = 'postlist.php';</script>";
                exit();
            }
        ?>
        


        <?php
            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $title = mysqli_real_escape_string($db->link, $_POST['title']);
                $cat_id = mysqli_real_escape_string($db->link, $_POST['cat_id']);
                $body = mysqli_real_escape_string($db->link, $_POST['body']);
                $tags = mysqli_real_escape_string($db->link, $_POST['tags']);
                $author = mysqli_real_escape_string($db->link, $_POST['author']);

                $permited = array('jpg', 'jpeg', 'png', 'gif');
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_temp = $_FILES['image']['tmp_name'];

                $div = explode('.', $file_name);
                $file_ext = strtolower(end($div));
                $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                $uploaded_image = "upload/" . $unique_image;

                // Check for empty fields
                if ($title == "" || $cat_id == "" || $body == "" || $tags == "" || $author == "") {
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
                            $query = "UPDATE tbl_post
                                      SET cat_id = '$cat_id',
                                          title = '$title',
                                          body = '$body',
                                          image = '$uploaded_image',
                                          author = '$author',
                                          tags = '$tags'
                                      WHERE id = '$post_id'";
                            $updated_row = $db->update($query);
                            if ($updated_row) {
                                echo "<span class='success'>Data Updated Successfully.</span>";
                            } else {
                                echo "<span class='error'>Data Not Updated!</span>";
                            }
                        }
                    } else {
                        // Update the post without changing the image
                        $query = "UPDATE tbl_post
                                  SET cat_id = '$cat_id',
                                      title = '$title',
                                      body = '$body',
                                      author = '$author',
                                      tags = '$tags'
                                  WHERE id = '$post_id'";
                        $updated_row = $db->update($query);
                        if ($updated_row) {
                            echo "<span class='success'>Data Updated Successfully.</span>";
                        } else {
                            echo "<span class='error'>Data Not Updated!</span>";
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
                $query = "SELECT * FROM tbl_post WHERE id='$post_id'";
                $post = $db->select($query);
                
                if ($post) {
                    while ($post_result = $post->fetch_assoc()) {
            ?>
            <form action="editpost.php?post_id=<?php echo $post_id; ?>" method="POST" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td><label>Title</label></td>
                        <td><input type="text" name="title" value="<?php echo $post_result['title']; ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Category</label></td>
                        <td>
                            <select id="select" name="cat_id">
                                <option>Select Category</option>
                                <?php 
                                    $query = "SELECT * FROM tbl_category";
                                    $category = $db->select($query);
                                    if ($category) {
                                        while ($result = $category->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $result['id']; ?>" <?php if ($post_result['cat_id'] == $result['id']){ echo 'selected'; } ?>>
                                    <?php echo $result['name']; ?>
                                </option>
                                <?php } ?>
                                <?php } else { ?>
                                    <span>No Category available</span>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Upload Image</label></td>
                        <td>
                            <img src="<?php echo $post_result['image']; ?>" height="100px" width="200px" alt="">
                            <br />
                            <input name="image" type="file" />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;"><label>Content</label></td>
                        <td><textarea name="body" class="tinymce"><?php echo $post_result['body']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Tags</label></td>
                        <td><input type="text" name="tags" value="<?php echo $post_result['tags']; ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Author</label></td>
                        <td><input type="text" name="author" value="<?php echo $post_result['author']; ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" Value="Save" /></td>
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
