<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>
<?php

if(isset($_GET['catid'])){
    $id = $_GET['catid'];
    // echo "<scrip>window.location = 'catlist.php' </script>" //redirect through javascript
}else{
    header("Location: catlist.php"); //redirect through php
    exit();
}
// if(!isset($_GET['catid']) || $_GET['catid'] == NULL){
//     header("Location: catlist.php"); //redirect through php
//     exit();
//     // echo "<scrip>window.location = 'catlist.php' </script>";
// }else{
//     $id = $_GET['catid'];
// }

?>
        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Update Category</h2>
               <div class="block copyblock"> 
                <?php

                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $name = mysqli_real_escape_string($db->link, $_POST['name']);

                    if(empty($name)){
                        echo '<span>Field must not be empty</span>';
                    }else{
                        $query = "UPDATE tbl_category
                                    SET
                                    name = '$name'
                                    WHERE id = '$id'";

                        $updated_row = $db->update($query);

                        if($updated_row){
                            echo '<span class="green">Category Updated successfully</span>';
                        }else{
                            echo '<span>Category not Updatead</span>';
                        }
                    }
                }

                ?>
                <?php 
                    $query = "SELECT * FROM tbl_category WHERE id=$id order by id desc";
                    $category = $db->select($query);
                    if($category){
                        while($result = $category->fetch_assoc()){

                      
                ?>
                 <form action="editcat.php?catid=<?php echo $id; ?>" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="name" value="<?php echo $result['name']; ?>" placeholder="Enter Category Name..." class="medium" />
                            </td>
                        </tr>
						<tr> 
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

<?php include 'inc/footer.php' ?>