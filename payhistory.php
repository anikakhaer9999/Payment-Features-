<?php

session_start();

if(
    isset($_SESSION['username'])
    && isset($_SESSION['role'])
    && !empty($_SESSION['username'])
    && !empty($_SESSION['role'])
){

    $role = $_SESSION['role'];
    $username = $_SESSION['username'];
    ?>
        <!DOCTYPE html>

        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Home</title>

                <style>

                body {
                        background-color: lightblue;
                    }

                .text{

                            height: 25px;
                            border-radius: 5px;
                            padding: 2px;
                            border: solid thin #aaa;
                            width: 90%;
                        }


                        #button{

                            padding: 10px;
                            width: 120px;
                            color: white;
                            background-color: FireBrick;
                            border: none;
                        }

                        #box{

                            background-color: AliceBlue;
                            margin: auto;
                            width: 300px;
                            padding: 20px;
                        }


                    #ptable{
                        width: 100%;
                        border: 1px solid blue;
                        border-collapse: collapse;
                    }

                    #ptable th, #ptable td{
                        border: 1px solid blue;
                        border-collapse: collapse;
                        text-align: center;
                    }

                    #ptable tr:hover{
                        background-color: bisque;
                    }
                </style>

            </head>

            <body>

                <input id="button" type="button" value="Welcome Page" onclick="Welcome()">
                <input id="button" type="button" value="My Profile" onclick="profile()">
                <input id="button" type="button" value="My Notifications" onclick="notification()">
                <input id="button" type="button" value="Payment History" onclick="payhistory()">



                <br>
                <br>


                <div style="font-size: 20px;margin: 10px;">Welcome
                <?php
                    echo $username;
                ?></div>


                <br>
                <br>

                <div>
                <div style="font-size: 20px;margin: 10px;">All My Payments</div>

                    <table id="ptable">
                        <thead>
                            <tr>

                                <th>Product Name</th>

                                <th>Cost</th>

                                <th>Transaction Number</th>


                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            try{



                                $conn=new PDO("mysql:host=localhost:3306;dbname=e_agro_farming;","root","");

                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                              //  $mysqlquery="SELECT * FROM cart WHERE ".$role.$role[0]."_username = '$username' ORDER BY payment_time DESC";

                                $returnobj=$conn->query($mysqlquery);
                                $returntable=$returnobj->fetchAll();

                                if($returnobj->rowCount()==0){
                                    ?>
                                        <tr>
                                            <td colspan="5">No values found</td>
                                        <tr>
                                    <?php
                                }
                                else{
                                    foreach($returntable as $row){


                                        $name = null;
                                        $image = null;
                                        $pid = $row[7];
                                        $cartquery1="SELECT * FROM Product
                                        WHERE p_id = $pid";

                                        $returnobj1=$conn->query($cartquery1);
                                        $returntable1=$returnobj1->fetchAll();

                                        if($returnobj1->rowCount() == 1)
                                        {
                                            foreach($returntable1 as $row1){
                                                $name = $row1[1];
                                                $image = $row1[2];
                                            }
                                        }

                                    ?>




                                        <tr>
                                            <td><?php echo $row[6] ?></td>
                                            <td><?php echo $name ?></td>
                                            <td><img src="<?php echo $image ?>" width="150" height="150"></td>
                                            <td><?php echo $row[2]?></td>
                                            <td><?php echo $row[1]?></td>

                                            <?php
                                            if ($role != 'farmer')
                                            {
                                                ?>
                                                <td><?php echo $row[3] ?></td>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <td><?php echo $row[3] ?>
                                                <br>
                                                <br>
                                                <input id="button" type="button" value="Update Status" onclick="updatedelivery(<?php echo $row[0]?>)">

                                                </td>
                                                <?php
                                            }
                                            ?>



                                        </tr>

                                        <?php
                                    }
                                }
                            }
                            catch(PDOException $ex){
                                ?>


                                    <tr>
                                        <td colspan="5">No values found</td>
                                    <tr>
                                <?php
                            }


                            ?>

                        </tbody>
                    </table>
                </div>

                <br>
                <input id="button" type="button" value="Click to Logout" onclick="logoutfn();">

                <script>
                    function logoutfn(){
                        location.assign('logout.php');   ///default GET method
                    }

                    function home(){
                        location.assign('home.php');   ///default GET method
                    }

                    function profile(){
                        location.assign('profile.php');   ///default GET method
                    }

                    function uploadfn(){
                        location.assign('upload.php');
                    }

                    function deletefn(pid){
                        ///for multiple values: file.php?varname=value&var1=value1
                        location.assign('delete.php?prodid='+pid);
                    }

                    function notification(){
                        location.assign('notification.php');
                    }

                    function payhistory(){
                        location.assign('payhistory.php');
                    }

                    function updatedelivery(payid){

                        var status = window.prompt("Delivery status: ");

                        location.assign('updatedelivery.php?payid='+payid+'&status='+status);
                    }


                </script>


            </body>
        </html>

    <?php
}
else{
     ?>
        <script>alert("give farmer name!");</script>
        <script>location.assign("home.php");</script>
    <?php
}


?>
