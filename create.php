<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create a Record</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Rubik+Pixels&family=Tourney:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        
        // Get form data and insert into tabel
        if(isset($_POST['create'])){
            
            // Write a prepared statement to insert data
            $insert = $connection->prepare('INSERT INTO scp(subject, class, description, containment, image) values(?, ?, ?, ?, ?)');
            // Actual data to be inserted
            
            $insert->bind_param('sssss', $_POST['subject'],  $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image']);
            
            
            if($insert->execute()){
                
            echo "<div>Record Added successfully</div>";    
                
            }
            else{
                echo "<div>Error: {$insert->error}</div>";    
            }
        }
          
      ?>
      
    <h1>Enter a New Record</h1>
    <p><a href="index.php">Back to Index Page</a></p>
    
    
    <form class="form-group" action="create.php" method="post">
        <label>Enter SCP Item #:</label>
        <br>
        <input type="text" name="subject" placeholder="Item #..." class="form-control" required>
        <br>
        <label>Enter Item Class:</label>
        <br>
        <input type="text" name="class" placeholder="Class..." class="form-control">
        <br>
        <label>Enter Description:</label>
        <br>
        <textarea class="form-control" name="description" required>Enter Item Description...</textarea>
        <br>
        <label>Enter Containment Procedures:</label>
        <br>
        <textarea class="form-control" name="containment" required>Enter Item Containment Procedure...</textarea>
        <br>
        <label>Enter Image:</label>
        <br>
        <input type="text" name="image" placeholder="e.g.images/name_of_image.png" class="form-control">
        <br>
        <input type="submit" name="create" class="btn btn-primary">
    </form>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>