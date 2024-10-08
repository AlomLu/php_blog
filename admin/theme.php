<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>
<?php


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
                <h2>Update Theme</h2>
               <div class="block copyblock"> 
                <?php

                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $theme = mysqli_real_escape_string($db->link, $_POST['theme']);

                        $query = "UPDATE tbl_theme
                                    SET
                                    theme = '$theme'
                                    WHERE id = '1' ";

                        $updated_row = $db->update($query);

                        if($updated_row){
                            echo '<span class="success">Theme Updated successfully</span>';
                        }else{
                            echo '<span>Theme not Updatead</span>';
                        }
                }

                ?>
                <?php 
                    $query = "SELECT * FROM tbl_theme WHERE id='1' ";
                    $selected_theme = $db->select($query);
                    if($selected_theme){
                        while($result = $selected_theme->fetch_assoc()){

                     
                ?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                               <input <?php if($result['theme'] == 'default'){
                                echo "checked";
                               } ?> type="radio" name="theme" value="default">Default
                            </td>
                        </tr>
                        <tr>
                            <td>
                               <input <?php if($result['theme'] == 'green'){
                                echo "checked";
                               } ?> type="radio" name="theme" value="green">Green
                            </td>
                        </tr>
                        <tr>
                            <td>
                               <input <?php if($result['theme'] == 'red'){
                                echo "checked";
                               } ?> type="radio" name="theme" value="red">Red
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Change" />
                            </td>
                        </tr>
                    </table>
                    </form>
                        <?php  } }  ?>
                </div>
            </div>
        </div>

<?php include 'inc/footer.php' ?>