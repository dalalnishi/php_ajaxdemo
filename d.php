<?php 
    $con=mysqli_connect('localhost','root','root');
    
    if(isset($_GET['db'])){
        if(isset($_REQUEST['values']) && isset($_GET['tblname'])){
            
            $db=$_REQUEST['db'];
            $tblname=$_REQUEST['tblname'];
            $values=$_REQUEST['values'];
    
            mysqli_select_db($con,$db);            
            $res=mysqli_query($con,"select $values from $tblname");
            $rw=mysqli_num_rows($res);
            
            $c=explode(',',$values);
            $cnt=count($c);            
            ?>
            
            <table class="bottomBorder" align="center">            
            <?php
            if($rw>0){
                while($r=mysqli_fetch_array($res)){
                    echo "<tr>";
                    for($i=0;$i<$cnt;$i++){
                        echo "<td>".$r[$i]."</td>";
                    }
                }
                echo "</tr>";
            }
            else{
                print "No Data!!!";
            }            
            ?>
            </table>
            
        <?php       
            
        }
        else if(isset($_GET['tblname'])){
            $tblname=$_GET['tblname'];
            $db=$_GET['db'];
            
            mysqli_select_db($con,$db);
            $res=mysqli_query($con,"DESCRIBE $tblname");
            ?>
            
            <div>            
            <select name="from[]" id="multiselect" class="form-control" size="8" multiple="multiple">       
            <?php 
                while($r=mysqli_fetch_array($res)){
                ?>    
                <option value="<?php echo $r[0]?>"><?php echo $r[0]?></option>
                <?php } ?>
            </select>
            
            <button type="button" id="multiselect_rightAll" class="btn btn-block">>></button>
            <button type="button" id="multiselect_rightSelected" class="btn btn-block">></button>
            <button type="button" id="multiselect_leftSelected" class="btn btn-block"><</button>
            <button type="button" id="multiselect_leftAll" class="btn btn-block"><<</button>
           
            <select name="to[]" id="multiselect_to" class="form-control" size="8" multiple="multiple"></select>
            </div>
            
        <?php 
        }        
        else{
            $db=$_GET['db'];
            
            $res=mysqli_query($con,"SHOW TABLES FROM $db");
            ?>
        Select Table:
        <select id="tblname" onChange="onTblSelect()" required>
        <option value="">--Select Table--</option>
            <?php
                while($r=mysqli_fetch_array($res)){
            ?>
            <option value="<?php echo $r[0]?>"><?php echo $r[0]?></option>
            <?php
                }
            ?>
        </select>
    <?php
    }
    }
    ?>
