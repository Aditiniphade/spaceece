<?php
 include("indexDB.php");


$u_id=$_POST['u_id'];
$c_id=$_POST['c_id'];

$b_time=$_POST['b_time'];
$end_time=$_POST['end_time'];
 $b_time= date($b_time);
$date3=strtotime(date("Y-m-d h:i:sa"));
date_default_timezone_set("Asia/Kolkata");
$date1=strtotime(date($b_time));
$date4=strtotime($b_time,strtotime("+{ $end_time} minutes"));
$sql2="SELECT spaceece.consultant.c_from_time,spaceece.consultant.c_to_time from spaceece.consultant join spaceece.users where spaceece.users.u_id='$c_id'  AND spaceece.users.u_id=spaceece.consultant.u_id;";
$res1 = mysqli_query($conn,$sql2);
$count= mysqli_num_rows($res1);
$sno =1;
if($count>0){
while($row = mysqli_fetch_assoc($res1)){

if(strtotime($row['c_from_time'])>$date1|| strtotime($row['c_from_time'])>$date4 ){
    if(strtotime($row['c_to_time'])< $date1|| strtotime($row['c_to_time'])< $date4 ){
        echo json_encode(['status'=>'fail','date1'=>$date1,'date3'=>$date3,'msg'=>"CONSULTANT NOT AVAILABLE"]);
    }
}else{
    
$sql1="SELECT * from new_apointment where c_id='$c_id'";
$res = mysqli_query($conn,$sql1);
if($date3 > $date1){
    echo json_encode(['status'=>'fail','date1'=>$date1,'date3'=>$date3,'msg'=>"INVALID SELECTED DATE"]);
    
}else{
echo "Inside1";
  
$sql1="SELECT * from new_apointment where c_id='$c_id'";
$res2 = mysqli_query($conn,$sql1);

        // count that data is there or not in database
        $count= mysqli_num_rows($res2);
        $sno =1;
        if($count>0){
            while($row = mysqli_fetch_assoc($res2)){
        $date5=strtotime(date($row['b_time']));
          
            $tme=$row['b_time'];
            $end=$row['end_time'];
          
            $date2=strtotime((date($row['b_time'])),strtotime("+{ $end} minutes") );
          
            if($date1>$date2 || $date1<$date2){
      
              
                if($date1 >$date5  || $date1 < $date5){
                    if ($date1 >$date2 || $date1 <$date2 ){
                        echo "Inside2";
                        $sql = "INSERT INTO  new_apointment (u_id,c_id,b_time,end_time) VALUES('$u_id','$c_id','$b_time','$end_time')";
                        $res = mysqli_query($conn,$sql);
                        header('Content-Type:application/json');
                
                
                        //checking whether query is excuted or not
                        if($res){
                            echo json_encode(['status'=>'success','result'=>'Added']);
                            // count that data is there or not in database
                            
                           
                        }
                      
                       
                    }else{
                        echo json_encode(['status'=>'fail1','msg'=>"UNABLE TO ADD DATA"]);
                    }
                }else{
                        echo json_encode(['status'=>'fail1','msg'=>"UNABLE TO ADD DATA"]);
                       }
            }else{
                    echo json_encode(['status'=>'fail2','msg'=>"UNABLE TO ADD DATA"]);
                }
                
                
                 
            }

          

        }else{
   echo  "inside";

    $sql = "INSERT INTO  new_apointment (u_id,c_id,b_time,end_time) VALUES('$u_id','$c_id','$b_time','$end_time')";
                $res = mysqli_query($conn,$sql);
                header('Content-Type:application/json');
        
        
                //checking whether query is excuted or not
                if($res){
                    echo json_encode(['status'=>'success','result'=>'Added']);
                    // count that data is there or not in database
                    
                   
                }else{
                    echo json_encode(['status'=>'fail', 'msg'=>"UNABLE TO ADD DATA"]);
                }
   
}
}
}
}




} else{
    echo json_encode(['status'=>'fail','count'=>$count, 'msg'=>"UNABLE TO ADD DATA"]);
}  


    
                   
            ?>