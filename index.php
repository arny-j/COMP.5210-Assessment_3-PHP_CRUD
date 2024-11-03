<!doctype html>
<html>
    <head>
        
        <title>SCP - Secure, Contain, Protect</title>
        <link rel="icon" href="images/scp-logo2.png" type="image/png">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Rubik+Pixels&family=Tourney:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php include "connection.php"; ?>
        <nav>
            <div class="d-flex align-items-center ml-3">
                <div class="me-3">
                    <img src="images/scp-logo.png" alt="SCP Foundation Logo" style="width: 120px; height: auto;">
                </div>
                <div>
                    <h1 class="light-blue">SCP Foundation</h1>
                    <h4 class="light-blue heading"><i>Secure, Contain, Protect</i></h4>
                </div>
            </div>
            <a href="index.php">Index</a>
            <?php foreach($result as $link): ?>
                <a href="index.php?link=<?php echo $link['subject']; ?>">
                    <?php echo $link['subject']; ?>
                </a>
            <?php endforeach; ?>
            <a href="create.php">Create New Record</a>
        </nav>
        
        <div class="content shadowed">
            <?php 
            
                // Based on menu click and link get value display full record
                if(isset($_GET['link'])) {
                    // Save GET Value as a Variable
                    $subject = $_GET['link'];
                    
                    // Run SQL Query to Retrieve Record Based on the Model
                    $item = $connection->query("SELECT * FROM scp WHERE subject='$subject'");
                    if($item && $item->num_rows > 0){
                        // if query successful save $item as array
                        $array = $item->fetch_assoc();
                        
                        $update = "update.php?update=" . $array['id'];
                        $delete = "index.php?delete=" . $array['id'];
                        
                        echo "
                        
                        <h2 class='display-5 heading'><strong><span class='light-blue'>Item #:</span> {$array['subject']}</strong></h2>
                        <h3 class='display-6 heading'><span class='light-blue'>Class:</span> {$array['class']}</h3>
                        <div class='d-flex flex-column flex-md-row align-items-center m-1 '>
                        
                            <div class='flex-grow-1 w-100 w-md-50 pe-md-3'>
                                <h3 class='display-6 light-blue heading'><b>Description:</b></h3>
                                <div class='p-3 main-text'>
                                    <p>{$array['description']}</p>
                                </div>
                            </div>
                            <div class='w-100 w-md-50 mt-3 mt-md-0 ms-md-3 text-center p-3'>
                                <p><img src='{$array['image']}' alt='{$array['subject']}' class='rounded img-fluid  cust-img'/></p>
                            </div>
                        </div>
                        <h3 class='display-6 light-blue heading'>Containment:</h3>
                        <p class='p-3 main-text'>{$array['containment']}</p>
                        <p>
                            <a href='{$update}' class='btn btn-primary m-2'>Update</a>
                            <a href='{$delete}' class='btn btn-primary m-2'>Delete</a>
                            
                        </p>
                        
                        ";
                    }
                    else{
                        echo "<p>Error Executing Statement (cannot retrieve SCP Item)...</p>";
                    }
                   
                }
                else {
                    // This content will display first time a user visits the application
                    echo "<h3 class='heading'>Please Use Menu Above to Navigate This Application</h3>";
                    
                }
            
            // Delete Functionality
            if(isset($_GET['delete'])){
                $delID = $_GET['delete'];
                $delete = $connection->prepare("DELETE FROM scp WHERE id=?");
                $delete->bind_param("i", $delID);
                
                if($delete->execute()) {
                    echo "<div>Redcord Deleted.</div>";
                }
                else {
                    echo "<div>Error Deleting Record: {$delete->error}</div>";
                }
            }
            
            
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>