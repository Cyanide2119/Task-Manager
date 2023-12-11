<?php
include('config/constants.php');

// Connect to the database
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    if (isset($_POST['update_priority'])) {
        // Get the current date
        $currentDate = date('Y-m-d');

        // Update priorities for tasks with a deadline set for today
        $updateSql = "UPDATE tbl_tasks SET priority = 'High' WHERE deadline = '$currentDate'";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult === false) {
            // Handle update error
            die(mysqli_error($conn));
        }
    }
}

?>

<html>
    <head>
        <title>Task Manager with PHP and MySQL</title>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/styl.css" />
    </head>
    
    <body>
        <div class="wrapper">
            <h1>TASK MANAGER</h1>
            
            <!-- Menu Starts Here -->
            <div class="menu">
                <a href="<?php echo SITEURL; ?>">Home</a>
                <a href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
            </div>

            <div class="menu2">
                <?php 
                    // Display lists
                    $sql2 = "SELECT * FROM tbl_lists";
                    $res2 = mysqli_query($conn, $sql2);

                    if($res2 == true) {
                        while($row2 = mysqli_fetch_assoc($res2)) {
                            $list_id = $row2['list_id'];
                            $list_name = $row2['list_name'];
                            ?>
                            
                            <a href="<?php echo SITEURL; ?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>
                            
                            <?php
                        }
                    }
                ?>
            </div>
        
            <div class="all-tasks">
                <form method="post" action="">
                    <p>
                        <button type="submit" name="update_priority" class="btn-primary">Update Priority for Today's Tasks</button>
                    </p>
                    
                    <p>
                        <a class="btn-primary" href="<?php SITEURL; ?>add-task.php">Add Task</a>
                    </p>
                </form>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Task Name</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>
                    
                    <?php 
                       
                        $sql = "SELECT * FROM tbl_tasks";
                        $res = mysqli_query($conn, $sql);

                        if($res == true) {
                            $count_rows = mysqli_num_rows($res);
                            $sn = 1;

                            if($count_rows > 0) {
                                while($row = mysqli_fetch_assoc($res)) {
                                    $task_id = $row['task_id'];
                                    $task_name = $row['task_name'];
                                    $priority = $row['priority'];
                                    
                                    $deadline = $row['deadline'];
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $task_name; ?></td>
                                        
                                        <td>
                                        <?php 
                                        if($priority=='High'){

                                            echo "<font color ='red'>",$priority;
                                            
                                                /*
                                                $msg = "First line of text\nSecond line of text";

                                                
                                                $msg = wordwrap($msg,70);

                                                
                                                
                                                mail("varunvn2119@gmail.com","My subject",$msg);*/
                                                
                                                
                                        }
                                        else if($priority=='Medium'){
                                            echo "<font color ='orange'>",$priority;
                                        }
                                        else 
                                            echo "<font color ='green'>",$priority;
                                        ?>
                                        </td>
                                        <td><?php echo $deadline; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update </a>
                                            
                                            <a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                                        </td>
                                    </tr>
                                    
                                    <?php
                                }
                            } else {
                                ?>
                                
                                <tr>
                                    <td colspan="5">No Task Added Yet.</td>
                                </tr>
                                
                                <?php
                            }
                        }
                    ?>
                </table>
            </div>
            
        </div>
    </body>
</html>

