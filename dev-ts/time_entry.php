
<?php 
    $pageTitleEntry = ["Create time entry", "Edit time entry"]; 
   

       
 if ((isset($_GET['id']) && $_GET['id'] > 0) || (isset($_GET['role']) && $_GET['role'] === "Admin")) {
            $pageTitle=$pageTitleEntry[1];
        } else {
            $pageTitle=$pageTitleEntry[0];  
        } 

        $dsn = 'mysql:host=localhost;dbname=time registration';
        $username = 'root';
        $password = '';
        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception handling
        
            // Fetch the task titles from the database
            $taskStmt = $pdo->query("SELECT id, title FROM tasks");
            $tasks = $taskStmt->fetchAll(PDO::FETCH_ASSOC); // Fetch tasks as an associative array
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
?>

<!DOCTYPE html>
<html lang="en">
    <?php  include("head.php"); ?>
<body>
   <?php 
   
   include("menu.php");
   ?>
    <div class="container-fluid h-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="card shadow-lg mb-3" style="max-width: 750px;">
            <form class="row" method="POST" action="form_actions/timeEntry_save.php">
                    <div class="col-12 mt-2 mb-2">
                        <h2 class="text-center">
                            
                        <?php
                            if ((isset($_GET['id']) && $_GET['id'] > 0) || (isset($_GET['role']) && $_GET['role']==="Admin")) {
                                echo "Edit ";
                            } else {
                                echo "Create ";
                            }
                            ?>time entry</h2>
                    </div>
                    <?php
                   
                    if(isset($_GET['message']) && $_GET['message'] === 'error')
                    {
                        echo '<div class="alert alert-error" role="alert">Something went wrong. Please try again.</div>';
                    }
                    ?>
                    <div class="col-12 col-sm-12 mb-3">
                        <label for="taskTitle" class="form-label">Task title<a style="color: red;">*</a></label>

                        <div class="input-group mb-3">
                            <select class="form-select" aria-label="Default select example" required id="taskTitle" name="taskTitle">

                                <option selected></option>
                                <?php
                                foreach ($tasks as $task) {
                                    echo '<option value="' . $task['id'] . '">' . htmlspecialchars($task['title']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3">
                        <label for="date">Date<a style="color: red;">*</a></label>
                    </div>
                    <div class="col-6 col-sm-6 mb-3">
                        <label for="timeInput" >Allocated time<a style="color: red;">*</a></label>
                    </div>
                    <div class="col-6 col-sm-6 mb-3">
                        <input id="date" name="date"  class="form-control" type="date" placeholder="add date" required>
                    </div>
                    <div class="col-6 col-sm-6 mb-3" id="timeInput">
                        <div class="row">
                            <div class="col-6 col-sm-6 mb-3">
                                <div class="input-group flex-nowrap">
                                    <select class="form-select" aria-label="Default select example" id="hours" name="hours" required>
                                        <option>00</option>
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                    <span class="input-group-text" id="addon-wrapping">h</span>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 mb-3">

                                <div class="input-group flex-nowrap">
                                    <select class="form-select" id="minutes" name="minutes" required>
                                        <option>00</option>
                                        <option>05</option>
                                        <option>10</option>
                                        <option>15</option>
                                        <option>20</option>
                                        <option>25</option>
                                        <option>30</option>
                                        <option>35</option>
                                        <option>40</option>
                                        <option>45</option>
                                        <option>50</option>
                                        <option>55</option>
                                    </select>
                                    <span class="input-group-text" id="addon-wrapping">m</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3">
                    <?php
                            if (isset($_GET['role']) && $_GET['role']==="Admin") 
                            {
                        ?>
                    
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                        </div>
                        <div class="mb-6">
                                     <input class="form-control" readonly>
                        </div>
                
                        <?php
                            }
                        ?>
                    </div>
                    <div class="col-6 col-sm-6 mb-3">
                    <?php
                            if (isset($_GET['role']) && $_GET['role']==="Admin") 
                            {
                        ?><div class="mb-3">
                                <label for="approved" class="form-label">Status</label>
                                </div>
                                <div class="mb-6">
                               <div class="input-group flex-nowrap">
                                    <select class="form-select" id="approved" name="approved">
                                        <option></option>
                                        <option>Pending</option>
                                        <option>Yes</option>
                                        <option>No</option>
                                        
                                    </select>
                                </div>
                            </div>
<?php
                            }
                        ?>
                        </div>
                    <div class="col-12 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Notes</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="6"></textarea>
                        </div>

                    </div>
                    <?php
                    if ((isset($_GET['id']) && $_GET['id'] > 0) || (isset($_GET['role']) && $_GET['role']==="Admin")) 
                    {
                    ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-5 mb-3">
                        <button type="button" class="btn btn-outline-dark">Delete</button>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="d-grid gap-2 col-6 mx-auto mt-5 mb-3">
                    <button type="submit" class="btn btn-outline-dark" style="float: right;" name="submit">Save</button>
                    </div>
            </div>
            

            </form>
        </div>
    </div>
    </section>
    </div>
    </div>
</body>
</html>
