<?php include '../config/config.php'; ?>

<?php include '../lib/Database.php'; ?>

<?php include '../helpers/Format.php'; ?>

<?php 
	$db = new Database();
?>

<?php 
    // Check if 'post_id' exists in the URL, if not redirect to post list
    if (!isset($_GET['delpostid']) || $_GET['delpostid'] == NULL) {
        // Redirect to post list if post_id is not set
        echo "<script>window.location = 'postlist.php';</script>";
        exit();
    }else {
        $postid = $_GET['delpostid'];

        $query = "SELECT * FROM tbl_post WHERE id='$postid' ";
        $getData = $db->select($query);

        if($getData){
            while($delimg = $getData->fetch_assoc()){
                $dellink = $delimg['image'];
                unlink($dellink);
            }
        }

        $query = "DELETE FROM tbl_post WHERE id='$postid' ";
        $delData = $db->delete($query);

        if($delData){
            echo "<script>alert('Data Deleted Successfully')</script>";
            echo "<script>window.location = 'postlist.php'</script>";
        }else{
            echo "<script>alert('Data Not Deleted ')</script>";
            echo "<script>window.location = 'postlist.php'</script>";
        }
    }
?>
