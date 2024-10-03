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
   if (!isset($_GET['delpageid']) || $_GET['delpageid'] == NULL) {
    // Redirect to post list if post_id is not set
    echo "<script>window.location = 'index.php';</script>";
    exit();
    }else{
        $pageid = $_GET['delpageid'];
        echo $pageid;

        $query = "DELETE FROM tbl_page WHERE id = '$pageid' ";
        $delete_page = $db->delete($query);

        if($delete_page){
            echo "<script>alert('Page Deleted Successfully')</script>";
            echo "<script>window.location = 'index.php'</script>";
        }else{
            echo "<scrip>alert('Page Not Deleted')</script>";
            echo "<script>window.location = 'page.php'</script>";
        }
    }
?>