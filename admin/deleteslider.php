<?php 
    include '../lib/Session.php';
    Session::checkSession();
?>

<?php include '../config/config.php'; ?>

<?php include '../lib/Database.php'; ?>


<?php 
	$db = new Database();
?>

<?php 
    // Check if 'post_id' exists in the URL, if not redirect to post list
    if (!isset($_GET['delsliderid']) || $_GET['delsliderid'] == NULL) {
        // Redirect to post list if post_id is not set
        echo "<script>window.location = 'sliderlist.php';</script>";
        exit();
    }else {
        $sliderid = $_GET['delsliderid'];

        $query = "SELECT * FROM tbl_slider WHERE id='$sliderid' ";
        $getData = $db->select($query);

        if($getData){
            while($delimg = $getData->fetch_assoc()){
                $dellink = $delimg['image'];
                unlink($dellink);
            }
        }

        $query = "DELETE FROM tbl_slider WHERE id='$sliderid' ";
        $delData = $db->delete($query);

        if($delData){
            echo "<script>alert('Slider Deleted Successfully')</script>";
            echo "<script>window.location = 'sliderlist.php'</script>";
        }else{
            echo "<script>alert('Slider Not Deleted ')</script>";
            echo "<script>window.location = 'sliderlist.php'</script>";
        }
    }
?>
