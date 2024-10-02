<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<style>
    .left-side{
        float: left;
        width: 70%;
    }
    .rght-side{
        float: right;
        width: 20%;
    }
    .rght-side img{
        height: 160px;
        width: 170px;
    }
</style>



        <div class="grid_10">
            <div class="box round first grid">
                <h2>Update Site Title and Description</h2>

                <?php
                    // Handle form submission
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $title = $fm->validation($_POST['title']);
                        $slogan = $fm->validation($_POST['slogan']);

                        $title = mysqli_real_escape_string($db->link, $title);
                        $cat_id = mysqli_real_escape_string($db->link, $slogan);

                        $permited = array('png');
                        $file_name = $_FILES['logo']['name'];
                        $file_size = $_FILES['logo']['size'];
                        $file_temp = $_FILES['logo']['tmp_name'];

                        $div = explode('.', $file_name);
                        $file_ext = strtolower(end($div));
                        $same_image = 'logo' . '.' . $file_ext;
                        $uploaded_image = "upload/" . $same_image;

                        // Check for empty fields
                        if ($title == "" ||  $slogan == "") {
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
                                    $query = "UPDATE title_slogan
                                                SET 
                                                title = '$title',
                                                slogan = '$slogan',
                                                logo = '$uploaded_image'
                                                WHERE id = '1' ";
                                    $updated_row = $db->update($query);
                                    if ($updated_row) {
                                        echo "<span class='success'>Data Updated Successfully.</span>";
                                    } else {
                                        echo "<span class='error'>Data Not Updated!</span>";
                                    }
                                }
                            } else {
                                // Update the post without changing the image
                                $query = "UPDATE title_slogan
                                            SET                                 
                                            title = '$title',
                                            slogan = '$slogan'
                                            WHERE id = '1' ";
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

                <?php
                    $query = "SELECT * FROM title_slogan WHERE id='1' ";
                    $blog_title = $db->select($query);
                    if($blog_title){
                        while($result = $blog_title->fetch_assoc()){

                ?>
                <div class="block sloginblock"> 
                    <div class="left-side">               
                        <form action="titleslogan.php" method="POST" enctype="multipart/form-data">
                            <table class="form">					
                                <tr>
                                    <td>
                                        <label>Website Title</label>
                                    </td>
                                    <td>
                                        <input type="text" value="<?php echo $result['title'] ?>"  name="title" class="medium" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Website Slogan</label>
                                    </td>
                                    <td>
                                        <input type="text" value="<?php echo $result['slogan'] ?>" name="slogan" class="medium" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Upload Logo</label>
                                    </td>
                                    <td>
                                        <input name="logo" type="file" />
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <input type="submit" name="submit" Value="Update" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="right-side">
                        <img src="<?php echo $result['logo'] ?>" alt="logo">
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
            </div>
        </div>
<?php include 'inc/footer.php' ?>
