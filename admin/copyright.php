﻿<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>
        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Update Copyright Text</h2>
                <?php 
                   if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $note = $fm->validation($_POST['note']);
                        $note = mysqli_real_escape_string($db->link, $note);

                        if($note == ""){
                            echo "<span class='error'>Filed must not be empty</span>";
                        }else{
                            $query = "UPDATE tbl_footer
                                        SET
                                        note = '$note'
                                        WHERE id = '1' ";

                            $updated_row = $db->update($query);

                            if ($updated_row) {
                                echo "<span class='success'>Data Updated Successfully.</span>";
                            } else {
                                echo "<span class='error'>Data Not Updated!</span>";
                            }
                        }
                   }
                
                ?> 
                <div class="block copyblock"> 
                    <?php 
                        $query = "SELECT * FROM tbl_footer WHERE id = '1' ";
                        $footer_note = $db->select($query);

                        if($footer_note){
                            while($result = $footer_note->fetch_assoc()){

                    ?>
                    <form action="copyright.php" method="POST">
                        <table class="form">					
                            <tr>
                                <td>
                                    <input type="text" value="<?php echo $result['note'] ?>" name="note" class="large" />
                                </td>
                            </tr>
                            
                            <tr> 
                                <td>
                                    <input type="submit" name="submit" Value="Update" />
                                </td>
                            </tr>
                        </table>
                    </form>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
<?php include 'inc/fooer.php' ?>