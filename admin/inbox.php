<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Inbox</h2>
				<?php 
					if(isset($_GET['delid'])){
						$id = $_GET['delid'];

						$query = "DELETE FROM tbl_contact WHERE id = '$id' ";
						$delData = $db->delete($query);
						if($delData){
							echo "<span class='success'>Message Deleted Successfully</span>";
						}else{
							echo "<span class='success'>Message Not Deleted !</span>";
						}

					}
				?>
				<?php 
					if(isset($_GET['seenid'])){
						$seenid = $_GET['seenid'];

						$query = "UPDATE tbl_contact 
									SET
									status = '1'
									WHERE id = '$seenid'";
						$update_row = $db->update($query);

						if($update_row){
							echo "<span class='success'>Message Sent in the Seen Box</span>";
						}else{
							echo "<span class='success'>Something Wrong !</span>";
						}
					}
				?>
				<?php 
					if(isset($_GET['unseenid'])){
						$unseenid = $_GET['unseenid'];

						$query = "UPDATE tbl_contact 
									SET
									status = '0'
									WHERE id = '$unseenid'";
						
						$update_row = $db->update($query);

						if($update_row){
							echo "<span class='success'>Message Sent in the Inbox</span>";
						}else{
							echo "<span class='success'>Something Wrong !</span>";
						}
					}
				?>
                <div class="block">  
                    <table class="data display datatable" id="example">     
						<thead>
							<tr>
								<th>Serial No.</th>
								<th>Name</th>
								<th>Email</th>
								<th>Message</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$query = "SELECT * FROM tbl_contact WHERE status ='0' ORDER BY id desc";
								$messages = $db->select($query);

								if($messages){
									$i=0;
									while($result = $messages->fetch_assoc()){
										$i++;
									
							?>
							<tr class="odd gradeX">
								<td><?php echo $i; ?></td>
								<td><?php echo $result['firstname'].' '.$result['lastname']; ?></td>
								<td><?php echo $result['email']; ?></td>
								<td><?php echo $fm->textShorten($result['body'], 30); ?></td>
								<td><?php echo $fm->formatDate($result['date']); ?></td>
								<td>
									<a href="viewmsg.php?msgid=<?php echo $result['id'] ?>">View</a> ||
									<a href="replymsg.php?msgid=<?php echo $result['id'] ?>">Reply</a> ||
									<a onclick="confirm('Are you sure you want to move the message to the Seen box?')" href="?seenid=<?php echo $result['id'] ?>">Seen</a>
								</td>
								<?php } } ?>
							</tr>
						</tbody>
					</table>
               </div>
            </div>
            <div class="box round first grid">
                <h2>Seen Message</h2>
                <div class="block">  
					<table class="data display datatable" id="example">     
						<thead>
							<tr>
								<th>Serial No.</th>
								<th>Name</th>
								<th>Email</th>
								<th>Message</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$query = "SELECT * FROM tbl_contact WHERE status ='1' ORDER BY id desc";
								$messages = $db->select($query);

								if($messages){
									$i=0;
									while($result = $messages->fetch_assoc()){
										$i++;
									
							?>
							<tr class="odd gradeX">
								<td><?php echo $i; ?></td>
								<td><?php echo $result['firstname'].' '.$result['lastname']; ?></td>
								<td><?php echo $result['email']; ?></td>
								<td><?php echo $fm->textShorten($result['body'], 30); ?></td>
								<td><?php echo $fm->formatDate($result['date']); ?></td>
								<td>
									<a href="viewmsg.php?msgid=<?php echo $result['id'] ?>">View</a> ||
									<a onclick="confirm('Are you sure you want to move the message to the Inbox?')" href="?unseenid=<?php echo $result['id'] ?>">Unseen</a> ||
									<a onclick="confirm('Are you sure you want to to Delete the message?')" href="?delid=<?php echo $result['id'] ?>">Delete</a>
								</td>
								<?php } } ?>
							</tr>
						</tbody>
					</tabl>
               </div>
            </div>
        </div>
<script type="text/javascript">

    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();


    });
</script>
<?php include 'inc/footer.php' ?>