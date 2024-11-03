<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update a Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Rubik+Pixels&family=Tourney:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
            background-color: #292929;
            color: #1386F7;
            padding: 20px;
        }
        
    </style>
  </head>
  <body class="container">
      
      <?php 
      
        // Enabel Error Reporting
        error_reporting(E_ALL);
        
        // Display errors 
        ini_set('display_errors', 1);
        
        include "connection.php";
        
        // initialise empty array
        $row = [];
        
        // get value directed from index.php
        if(isset($_GET['update'])){
            $id = $_GET['update'];
            
            // based on the GET value select record based on that ID
            $recordID = $connection->prepare("SELECT * FROM scp WHERE id = ?");
            
            // check if record exists
            if(!$recordID){
                echo "<div>No Record Found</div>";
                exit;
            }
            
            $recordID->bind_param("i", $id);
            
            // execute the querry
            if($recordID->execute()){
                echo "<div>Record Ready for Upadting</div>";
                $temp = $recordID->get_result();
                $row = $temp->fetch_assoc();
            }
            else{
                echo "<div>Error: {$recordID->error}</div>";
            }
            
        }
        
        if(isset($_POST['update'])){
            $update = $connection->prepare("UPDATE scp SET subject=?, class=?, description=?, containment=?, image=? WHERE id=?");
            $update->bind_param("sssssi", $_POST['subject'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image'], $_POST['id']);
            
            if($update->execute()){
                echo "<div class='alert alert-success p-3 m-2'>Record Updated Successfully</div>";
            }
            else{
                echo "<div class='alert alert-danger p-3 m-2'>Error: {$update->error}</div>";
            }
        } 
      ?>
      
    <h1>Update This Record</h1>
    <p><a href="index.php">Back to Index Page</a></p>
    
    
    <form class="form-group" action="update.php" method="post">
        <!-- if not working change the php part -->
        <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
        <label>Enter Item #:</label>
        <br>
        <input type="text" name="subject" value="<?php echo isset($row['subject']) ? $row['subject'] : ''; ?>" class="form-control">
        <br>
        <label>Enter Item Class:</label>
        <br>
        <input type="text" name="class" value="<?php echo isset($row['class']) ? $row['class'] : ''; ?>" class="form-control">
        <br>
        <label>Enter Item Description:</label>
        <br>
        <textarea class="form-control" name="description" value="<?php echo isset($row['description']) ? $row['description'] : ''; ?>">Enter Item Description...</textarea>
        <br>
        <label>Enter Item Containment Procedure:</label>
        <br>
        <textarea class="form-control" name="containment" value="<?php echo isset($row['containment']) ? $row['containment'] : ''; ?>">Enter Item Containment Procedure...</textarea>
        <br>
        <label>Enter Image:</label>
        <br>
        <input type="text" name="image" value="<?php echo isset($row['image']) ? $row['image'] : ''; ?>" class="form-control">
        <br>
        <input type="submit" name="update" class="btn btn-warning">
    </form>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>