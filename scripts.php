<?php
    //INCLUDE DATABASE FILE
    include('database.php');
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();


    function counter($contStatus){
        global $conn;
        $sql= "SELECT * FROM tasks where status_id= $contStatus";
        $result = mysqli_query($conn,$sql);
        $res=mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo count($res);

    }
    

    function getTasks($status,$icon)
    {
        //CODE HERE
        global $conn;
        //SQL SELECT
        // $sql = "SELECT * FROM tasks where status_id= '$status'" ;
        $sql = "SELECT tasks.id as 'id' , title , types.name as 'NameTypes'  ,priority_id,tasks.status_id, priorities.name as 'NamePriority', statuses.name as 'NameStatus', task_datetime , description 
                from tasks 
                INNER JOIN types on types.id = tasks.type_id 
                INNER JOIN priorities on tasks.priority_id = priorities.id
                INNER JOIN statuses ON tasks.status_id=statuses.id  WHERE status_id =$status";
        
        $result = mysqli_query($conn,$sql);
      
        // $row=mysqli_fetch_assoc( $result);
        while ($row =mysqli_fetch_assoc( $result)){
            $icon = '';
                if($status == 1){
                    $icon='fa fa-circle-question';
                }
                else if ($status == 2){
                    $icon='fa fa-spinner';
                }
                else{
                    $icon='fa fa-circle-check';
            
                }
                
            echo '<button id="'.$row['id'].'" class="d-flex button border  w-100 p-1" data-bs-toggle="modal" data-bs-target="#task '.$row['id'].'">
            <div class="col-md-1">
                <i class="'.$icon.' text-success"></i> 
            </div>
            <div class="text-start col-md-11 ">
                <div class="fw-bolder">'.$row['title'].'</div>
                <div class="">
                    <div class="text-gray">#'.$row['id'].' created in '.$row['task_datetime'].'</div>
                    <div class="" title="">'.$row['description'].'</div>
                </div>
                <div class="">
                    <span class="col-md-auto btn btn-primary text-white ">'.$row['NamePriority'].'</span>
                    <span class="col-md-auto btn btn-gray text-dark">'.$row['NameTypes'].'</span>
    
    
                </div>
            </div>
          </button>';
          ?>  

          <!-- TASK MODAL -->
        <div class="modal fade" id="task<?php echo $row['id']?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="scripts.php" method="POST" id="form-task">
					<div class="modal-header">
						<h5 class="modal-title">Add Task</h5>
						<a href="#" class="btn-close" data-bs-dismiss="modal"></a>
					</div>
					<div class="modal-body">
							<!-- This Input Allows Storing Task Index  -->
							<input type="hidden" id="task-id">
							<div class="mb-3">
								<label class="form-label">Title</label>
								<input type="text" class="form-control" id="task-title" name="task-name" value="<?php echo $row["title"] ?>"/>
							</div>
							<div class="mb-3">
								<label class="form-label">Type</label>
								<div class="ms-3">
									<div class="form-check mb-1">
										<input class="form-check-input" name="task-type" type="radio" value="1" id="task-type-feature" <?php if($row["NameTypes"] == "feature") echo "checked" ?> />
										<label class="form-check-label" for="task-type-feature">Feature</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" name="task-type" type="radio" value="2" id="task-type-bug" <?php if($row["NameTypes"] == "bug") echo "checked" ?> />
										<label class="form-check-label" for="task-type-bug">Bug</label>
									</div>
								</div>
								
							</div>
							<div class="mb-3">
								<label class="form-label">Priority</label>
								<select class="form-select" id="task-priority" name="task-priority">
									<option value="<?php echo $row["priority_id"] ?>" selected><?php echo $row["NamePriority"] ?></option>
									<option value="1">Low</option>
									<option value="2">Medium</option>
									<option value="3">High</option>
									<option value="4">Critical</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="form-label">Status</label>
								<select class="form-select" id="task-status" name="task-status">
									<option value="<?php echo $row["status_id"] ?>" selected><?php echo $row["NameStatus"] ?></option>
									<option value="1">To Do</option>
									<option value="2">In Progress</option>
									<option value="3">Done</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="form-label">Date</label>
								<input type="date" class="form-control" id="task-date"  value="<?php echo $row["date"] ?>" name="task-date"/>
							</div>
							<div class="mb-0">
								<label class="form-label">Description</label>
								<textarea class="form-control" rows="10" id="task-description" name="task-description"><?php echo $row['description']  ?></textarea>
							</div>

                            <input class="d-none" type="text" name="id" value="<?php echo $row["id"] ?>">
						
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-white" data-bs-dismiss="modal">Cancel</a>
						<button type="submit" name="delete" class="btn btn-danger task-action-btn" id="task-delete-btn">Delete</a>
						<button type="submit" name="update" class="btn btn-warning task-action-btn" id="task-update-btn">Update</a>
						<button type="submit" name="save" class="btn btn-primary task-action-btn" id="task-save-btn">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

    <?php


        // echo "Fetch all tasks"
    }
}
    
    function saveTask()
    {
        //CODE HERE
        $title = $_POST['taskTitle'];
		$type = $_POST['taskType'];
		$priority = $_POST['taskPriority'];
		$status = $_POST['taskStatus'];
		$date = $_POST['taskDate'];
		$description = $_POST['taskDescription'];
        //SQL INSERT
        global $conn;
        $sql = "INSERT INTO tasks(title, type_id, priority_id, status_id, task_datetime, description) 
            VALUES('$title', '$type', '$priority', '$status', '$date', '$description');";
            $result=mysqli_query($conn,$sql);

        //validation use input data
        // if(empty($title)||empty($)||empty($)||empty($)){
        //     echo"Please fill all the fields";
        //  }else{
        //     $result=mysqli_query($conn,$sql);
        // if($result){
        //     echo"data inserted succefully"
        // }
        // else{
        //     echo"data not inserted"
        // }
        // }


        $_SESSION['message'] = "Task has been added successfully !";
		header('location: index.php');
    }

  
    function updateTask()
    {
        //CODE HERE
        //SQL UPDATE
        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
    }

    function deleteTask()
    {
        //CODE HERE
        //SQL DELETE
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
    }

?>