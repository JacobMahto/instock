<?php
include './dbms/functions.php';
$_SESSION['matValueInf'] = array();
if (isset($_POST['submit'])) {
    //echo $_POST['date'];
}
if (isset($_POST['chNoSubmit'])) {
    //echo 'yes is';
    $_SESSION['chNo'] = $_POST['challanNo'];
}

if (isset($_POST['matSubmit'])) {
   // $decodeNameChangeDotToUnderscore = str_replace('.', "__z__", $_POST['']);//name values with periods in them can't be retrived with post variable , therefor all the dots have been replaced by custom character and then will be decoded after being recalled by post variable.
   for($i=1;$i<=count($_SESSION['matNameInf']);$i++){
       array_push($_SESSION['matValueInf'],$_POST["mat$i"],$_POST["num$i"],$_POST["wt$i"],$_POST["len$i"]);
   }
   
   $returningChallanNo = $_POST['ch_no_return'];
  // echo "<br>Hello<br>";
   print_r($_SESSION['matNameInf']);
   print_r($_SESSION['matValueInf']);
   updateChMatInfo($_SESSION['chNo'],$_SESSION['matNameInf'] , $_SESSION['matValueInf'] , $returningChallanNo);
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
                <h4 class="col-8 text-white text-uppercase font-weight-bold">instock ver.1 - (submission)</h4>
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
            <form class="form" action="submitCh.php" method="post">
                <div class="row">
                    <div class="col">
                        <label for="ch_no">Select Challan No.</label>
                        <div class="input-group">                            
                            <?php
                            $list = getChList();
                            echo '<select class="form-control" name="challanNo">';
                            while ($a = mysqli_fetch_row($list)) {
                                echo "<option name='$a[0]'>$a[0]</option>";
                            }
                            echo '</select>';
                            ?>
                            <button type="submit" name="chNoSubmit" class="btn input-group-addon btn-primary">View</button>
                        </div>
                    </div>
                    
                    <div class="col"><label for="ch_no">Enter Receiving Challan No.</label>
                        <input type="text" name="ch_no_return" class="form-control"></div>
                        
                    <div class="col"><label for="date_fi">Returning Date</label>
                        <input type="date" name="date_fi" class="form-control"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="thead-inverse">
                                <tr class="table-row">
                                    <th class="text-center">S.No.</th>
                                    <th class="text-center">Material</th>
                                    <th class="text-center">Return No.(s)</th>
                                    <th class="text-center">Return Wt.(kg)</th>
                                    <th class="text-center">Return Length(m)</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultList = getChMat($_SESSION['chNo']);
                                $i = 1;
                                $_SESSION['matNameInf'] = array();
                                while ($row = mysqli_fetch_row($resultList)) {                                    
                                    //$nameChangeDotToUnderscore = str_replace('.', "__z__", $row[1]);//name values with periods in them can't be retrived with post variable , therefor all the dots have been replaced by custom character and then will be decoded after being recalled by post variable.
                                    array_push($_SESSION['matNameInf'], $row[1]);
                                    echo '<tr>';
                                    echo "<td>$i</td>";
                                    echo "<td><input type='text' class='form-control text-center' name='mat$i' value='$row[1]' placeholder='Material $i'></input></td>";
                                    echo "<td><input type='text' class='form-control text-center' name='num$i' placeholder='$row[2]'></input></td>";
                                    echo "<td><input type='text' class='form-control text-center' name='wt$i' placeholder='$row[3]'></input></td>";
                                    echo "<td><input type='text' class='form-control text-center' name='len$i' placeholder='$row[4]'></input></td>";
                                    echo '</tr>';
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table> 
                        <div class="text-center"><button type="submit" name="matSubmit" class="btn btn-success">Confirm Return</button></div>
                    </div>

            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </body>
</html>
