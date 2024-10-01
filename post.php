<?php include 'inc/header.php'; ?>

<?php
if(!isset($_GET['id']) || $_GET['id'] == NULL){
	header("Location: 404.php");
}else{
	$id = $_GET['id'];
}
?>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">
				<!-- <?php echo "<span>$id</span"; ?> -->
				<?php 
					$query = "SELECT * FROM tbl_post where id=$id";
					$post = $db->select($query);
					if($post){
						while($result = $post->fetch_assoc()){
					
				?>
				<h2><?php echo $result['title'] ?></h2>
				<h4><?php echo $fm->formatDate($result['date']); ?><a href="#"> by <?php echo $result['author']; ?></a></h4>
				<img src="admin/upload/<?php echo $result['image']; ?>" alt="Missing..."/>
				<?php echo $result['body'] ?>
					
				<div class="relatedpost clear">
					<h2>Related articles</h2>
					<?php 
						$catid = $result['cat_id'];
						$queryrelated = "SELECT * FROM tbl_post where cat_id=$catid AND id !=$id limit 5";
						$related_post = $db->select($queryrelated);
						if($related_post){
							while($related_result = $related_post->fetch_assoc()){
						
					?>
							<a href="post.php?id=<?php echo $related_result['id']; ?>">
								<img src="admin/<?php echo $related_result['image']; ?>" alt="post image"/>
							</a>
						<?php } ?>
					<?php }else{ echo "No Related Post Available !!"; } ?>
				</div>
				<?php } ?> <!-- end while loop -->
				<?php }else{header("Location: 404.php");} ?>
	</div>
</div>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/footer.php'; ?>