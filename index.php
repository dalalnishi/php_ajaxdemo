<?php 
    $con=mysqli_connect('localhost','root','root');
?>

<!DOCTYPE html>
<html>
<head>
   
    <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="node_modules/multiselect-two-sides/dist/js/multiselect.js"></script>
    <script type="text/javascript" src="node_modules/multiselect-two-sides/dist/js/multiselect.min.js"></script>

    <style>
        .form-control{
            width:25%;
        }
        #cdata{
            text-align:center;
            border-radius: 10px 5px;
        }   
        #maindiv{
            width:100%;
            border: 1px solid;
            padding: 10px;
            box-shadow: 5px 10px #888888;
            background-color:lightyellow;
        } 
        select{
            font-family: Cursive;
            font-size: 15px;
            border-radius:10px;
        }
        button{
            background-color:rgb(0,114,199);
            border-radius: 7px;
            box-shadow: 3px 7px grey;
            width: 15%;
            color: white;
        }
        table.bottomBorder { 
            border-collapse: collapse; 
        }
        table.bottomBorder td { 
            border-bottom: 1px solid yellowgreen; 
            padding: 10px; 
            text-align: left;
        }   
    </style>
</head>
<body>
    <div id='maindiv'>
    <table align="center">
        <tr>
            <td>Select Database:</td>
            <td>
                <select id="db" required onChange="onDbSelect()">
                <option value="">--Select Database--</option>
                    <?php
                        $res=mysqli_query($con,'SHOW DATABASES');
                        while ($r=mysqli_fetch_array($res)) {
                    ?>
                    <option value="<?php echo $r[0]?>"><?php echo $r[0]?></option>
                    <?php
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div id="tbl"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div id="colm"></div>
            </td>
        </tr>
        
    </table>
    <div id="cdata"></div>
    </div>

    <script type="text/javascript">

        var x = new XMLHttpRequest();

        function onDbSelect(){
            var db=document.getElementById('db').value;
            
            x.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tbl").innerHTML = this.responseText;
            }
        };
            x.open('GET','d.php?db='+db,true);
            x.send(null);
        }

        function onTblSelect(){
            var tblname=document.getElementById('tblname').value;
            var db=document.getElementById('db').value;

            x.onreadystatechange=function(){
                if(this.readyState == 4 && this.status == 200){
                    document.getElementById("colm").innerHTML = this.responseText;
                    $('#multiselect').multiselect();

                    $("#tblname").change(function(){
                        if($(this).val().length == 0) {
                            $("#cdata").empty();
                        }
                    })
                    
                    $("button").click(function(){
                        var values = [];
                        
                        $("#multiselect_to option").each(function () {                                
                             values.push($(this).val());
                        });
                                          
                            $.ajax({
                                url: 'd.php?tblname='+tblname+'&db='+db,
                                method: 'POST',
                                data: "values=" + values,
                                success: function(data) {
                                    document.getElementById('cdata').innerHTML=data;
                                }                                
                            });                           
                    });                    
                }
            };
            x.open('GET','d.php?tblname='+tblname+'&db='+db,true);
            x.send(null);
        }

    </script>
    
</body>
</html>