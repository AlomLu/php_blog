<?php include 'inc/header.php'; ?>
<?php 
            if(!isset($_GET['pageid']) || $_GET['pageid'] == NULL ){
                // echo "<script>window.location = 'index.php'</script>";
                echo "<script>window.location = '404.php'</script>";
				// header("Location : 404.php");
            }else{
                $id = $_GET['pageid'];
            }

            // if(isset($_GET['pageid'])){
            //     $id = $_GET['pageid'];
            // }else{
            //     echo "<script>window.location = 'index.php'</script>";
            // }

        ?>
	<?php
		$query = "SELECT * FROM tbl_page WHERE id = '$id' ";
		$page_details = $db->select($query);

		if($page_details){
			while($result = $page_details->fetch_assoc()){
		
	
	?>  
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">
				<h2><?php echo $result['name'] ?></h2>
				<p><?php echo $result['body'] ?></p>
				<p><?php echo $result['body'] ?></p>
				<p><?php echo $result['body'] ?></p>
			</div>
		</div>
		<?php include 'inc/sidebar.php'; ?>
	</div>
	<?php } ?>
<?php }else{ header("Location: 404.php"); } ?>
<?php include 'inc/footer.php'; ?>


	