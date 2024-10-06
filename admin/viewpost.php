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
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<script>window.location = 'postlist.php' </script>";
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
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td><label>Title</label></td>
                        <td><input readonly type="text" value="<?php echo $post_result['title']; ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Category</label></td>
                        <td>
                            <select readonly id="select">
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
                        <td><label>Image</label></td>
                        <td>
                            <img src="<?php echo $post_result['image']; ?>" height="100px" width="200px" alt="">
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;"><label>Content</label></td>
                        <td><textarea readonly class="tinymce"><?php echo $post_result['body']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Tags</label></td>
                        <td><input type="text" readonly value="<?php echo $post_result['tags']; ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Author</label></td>
                        <td>
                            <input type="text" readonly value="<?php echo $post_result['author']; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" Value="Ok" /></td>
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
