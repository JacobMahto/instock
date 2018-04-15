<?php
include './dbms/functions.php';
if (isset($_POST['submit'])) {
    $array_ch_info = array($_POST['ch_no'],$_POST['date_in'],$_POST['job'],$_POST['nat']);
    $array_mat_info = array();
    
    for($i=1;$i<=15;$i++){
        
          if(trim($_POST["mat$i"])){              
           array_push($array_mat_info, $_POST["mat$i"], $_POST["num$i"],$_POST["wt$i"],$_POST["len$i"]);            
        }
    }
    print_r($array_ch_info);
    echo '\n HI <br>';
    print_r($array_mat_info);
    $result = setChallan($array_ch_info);
    if($result){
        setChMat($array_ch_info, $array_mat_info);
    }
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <title>Fee Wizard | Tech-Rex</title>
    </head>

    <body>
        <header>
            <div class="row bg-primary p-3 ">
                <h4 class="col-8 text-white text-uppercase font-weight-bold">instock ver.1 - (Issue)</h4>
                <h5 class="col text-light text-right text-capitalize font-italic">welcome jvm<BR> @override</h5>
            </div>        
            <!-- NAVBAR WITH RESPONSIVE TOGGLE -->
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
                <div class="container">
                    <a class="navbar-brand" href="#">Operations</a>
                    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="issue.php">Issue</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="submitCh.php.php">Submission</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Customise</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Templates</a>
                            </li>
                        </ul>
                        <form action="" class="form-inline my-2">
                            <input type="text" class="form-control" placeholder="Enter Challan">
                            <button type="button" class="btn my-2 mr-sm-2 btn-outline-success ">Search</button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <form class="form" action="index.php" method="post">
                <div class="row">
                    <div class="col-3"><label for="ch_no">Enter Challan No.</label>
                        <input type="text" name="ch_no" class="form-control"></div>
                    <div class="col-3"><label for="date_in">Issuing Date</label>
                        <input type="date" name="date_in" class="form-control"></div>
                    <div class="col-4">
                        <label for="job-worker">Select Job-Worker</label>
                        <?php
                        $list = getJobWorkers();
                        echo '<select class="form-control" name="job">';
                        while ($a = mysqli_fetch_row($list)) {
                            echo "<option value='$a[0]'>$a[1]</option>";
                        }
                        echo '</select>';
                        ?>

                    </div>
                    <div class="col-2"><label for="nat">Proc. Nature</label>
                        <input type="text" name="nat" class="form-control"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="thead-inverse">
                                <tr class="table-row">
                                    <th class="text-center">Name</th>
                                    <th class="text-center">No.(s)</th>
                                    <th class="text-center">Weight(kg)</th>
                                    <th class="text-center">Length(m)</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 1; $i <= 15; $i++) {
                                    $mat = "mat".$i;
                                    echo '<tr>';
                                    echo "<td><input type='text' class='form-control text-center' name='mat$i' placeholder='Material $i'></input></td>";
                                    echo "<td><input type='text' class='form-control text-center' name='num$i' placeholder='No.(s)'></input></td>";
                                    echo "<td><input type='text' class='form-control text-center' name='wt$i' placeholder='kg(s)'></input></td>";
                                    echo "<td><input type='text' class='form-control text-center' name='len$i' placeholder='m.'></input></td>";
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>                       
                    </div>                        
                    </div>
                 <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="submit">Issue Challan</button>
                        </div>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </body>
</html>
