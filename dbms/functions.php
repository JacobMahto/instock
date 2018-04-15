<?php
session_start();
//initialize session variables



include 'dbConnect.php';
$result = null;

//to get the list of job-workers from the sql table job
function getJobWorkers(){
    global $connection;
    $query = 'SELECT * FROM job;';
    $resultList = mysqli_query($connection, $query);
    return $resultList;
}


//to get the list of challans from the table ch_info_gen
function getChList(){
    global $connection;
    $query = 'SELECT ch_no FROM ch_info_gen;';
    $resultList = mysqli_query($connection, $query);
    return $resultList;
}

//to insert the challan info to sql table ch_info_gen
function setChallan($arrCh){
    global $connection;
    $insquery = "INSERT INTO ch_info_gen(ch_no,date_in,date_fi,job_id,nature) VALUES($arrCh[0],'$arrCh[1]',null,'$arrCh[2]','$arrCh[3]');";
    $result = mysqli_query($connection, $insquery);
    if($result){
         return $result;
    }
    else {
        echo 'no'.mysqli_error($connection);
    }
}

//to insert challan material in sql table ch_mat
function setChMat($arrCh,$arrMat){
    global $connection;
    $go=count($arrMat);
   // echo "<br>$go"."djj";
    for($i=0;$i<count($arrMat);$i=$i+4){
        $indNum = $i+1;
        $indKg = $i+2;
        $indLen = $i+3;
        //setting blank values equal to null
        if(!trim($arrMat[$indNum])){$arrMat[$indNum]='null';}
            if(!trim($arrMat[$indKg])){$arrMat[$indKg]='null';}
            if(!trim($arrMat[$indLen])){$arrMat[$indLen]='null';}
        
        $insquery = "INSERT INTO ch_mat(ch_no,mat_name,mat_ni,mat_ki,mat_mi) VALUES($arrCh[0],'$arrMat[$i]',$arrMat[$indNum],$arrMat[$indKg],$arrMat[$indLen]);";
        $result = mysqli_query($connection, $insquery);
        if($result){
           // echo 'ok';
        }
        else{
            //echo "<br>".$insquery."<br>";
            echo 'no'.mysqli_error($connection);
        }
    }
}

//get challan-material info from sql table ch_mat
function getChMat($chNo){
    global $connection;
    $query = "SELECT * FROM ch_mat where ch_no='$chNo';";
    $resultList = mysqli_query($connection, $query);
    return $resultList;
}

//to update mat-info for returning, from table ch_mat
function updateChMatInfo($challanNo,$matName,$matValue,$challanNoReturn){
    global $connection;
    $matNameIndex=0;
    $onlyOnce = 0;//for updating the returning challan column in the ch_info_gen , it should not be looped , rather the updation query should only work once.
    for($i=0;$i<count($matValue);$i=$i+4,$matNameIndex++){
        $indNum = $i+1;
        $indKg = $i+2;
        $indLen = $i+3;
        //setting blank values equal to null
        if(!trim($matValue[$indNum])){$matValue[$indNum]='null';}
            if(!trim($matValue[$indKg])){$matValue[$indKg]='null';}
            if(!trim($matValue[$indLen])){$matValue[$indLen]='null';}    
            
            if($onlyOnce==0){                
            $updateQueryOnlyOnce = "UPDATE ch_info_gen SET ch_no_return=$challanNoReturn WHERE ch_no=$challanNo;";
            $resultOnlyOnce = mysqli_query($connection,$updateQueryOnlyOnce);
            $onlyOnce++;
            }
            
        $updateQuery = "UPDATE ch_mat SET mat_name='$matValue[$i]',mat_nf=$matValue[$indNum],mat_kf=$matValue[$indKg],mat_mf=$matValue[$indLen] WHERE ch_no=$challanNo AND mat_name='$matName[$matNameIndex]';";
      //  echo "<br>".$updateQuery."<br>";
        $result = mysqli_query($connection, $updateQuery);
        
        
    if($result){
         
    }
    else {
        echo 'no'.mysqli_error($connection);
        
    }
    }
    
}
?>