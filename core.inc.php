<?php
function establishConnection()
{
 $con = mysql_connect("localhost","root","")
 or die ("Es konte keine verbindung zum host hergestellt werden</br>");
 
 return $con;
}

function deleteSelected($sql)
{
   $con = establishConnection();
   if ($con != null && $con != false)
   {
	$dbcon = mysql_select_db("ulsb",$con)
  	or die ("Es konte keine verbindung zur datenbank hergestellt werden</br>".mysql_error());
  	makeQuery($sql,$con);
  	mysql_close($con);
 	}
}
function getTeilnr($sql)
{
 $con = establishConnection();
 if ($con != null && $con != false)
 {
  $dbcon = mysql_select_db("ulsb",$con)
  or die ("Es konte keine verbindung zur datenbank hergestellt werden</br>".mysql_error());
  makeQuery($sql,$con);
  echo($sql." hi");
  mysql_close($con);
 }
}

/* here are the core Query functions for datamanipulations.
 * makeSelectQuery serves to execute querrys returning result sets
 * While makeQuery acts on the database with out requiring a response.
 */
 
function makeSelectQuery($query) 
{
 include("connect.inc.php");
 $result = mysql_query($query,$con);
 return $result;	
}

function makeQuery($query,$con)
{
 mysql_query($query,$con);
}

function createTableEinzelteile()
{
   createTableView($result,$cNames);
 
}
function createTableProfilteile()
{

 $result = makeSelectQuery("SELECT * FROM tbl_profileteile ",$con);
 
 createTableView($result);
 
 
}
function getColumnNames($r) 
{
  $cnames= array();
  $row = mysql_fetch_row($r);
  
  $count = 0;
  foreach ($row as $key => $value) 
  {
   $cnames[$count] = mysql_field_name($r, $count);
   $count++;
  }

  return $cnames;
  
}
function InsertInto($tblnamem,$values)
{

}



###=================== VIEW ======================###
function showTable($tbl_name) 
{
    
 	$sql = "SELECT * FROM ". $tbl_name;
 	$sql2 = "SELECT * FROM ". $tbl_name." LIMIT 0 , 1";
 	echo($sql2);
 	$result = makeSelectQuery($sql);
 	$cn = makeSelectQuery($sql2);
 	
 	$numberOfColumns = mysql_num_fields($result); //total number of fields
 	$numberOfRows = mysql_num_rows($result); // total number of rows
     
    echo $numberOfRows." ".$numberOfColumns;
 	$columnNames = getColumnNames($cn); 
    
 	$colspan = $numberOfColumns+1;// sets the footer width in <tfoot> tag

 	$tableMatrix =array();

	//saving table content in  2 d array	 
	for ($i = 0; $i <= $numberOfRows; $i++) 
	{
   		$tableMatrix[$i]= mysql_fetch_array($result);
	}
	//echo $tableMatrix[0][0];
	createTableView($tbl_name,$numberOfColumns,$numberOfRows,$columnNames,$tableMatrix);
	
}


function createTableView($tbl_name,$numberOfColumns, $numberOfRows, $columnNames,$tableMatrix) 
{
/*
 * This is the mother ship of all functions. Its purpose is to
 * so abstract as to create a view of all data tables contained in a database.
 * It dgenerates an xhtml/html table with a table header displaying the table name
 * and its columns. A footer(not yet complete with some usefull functions). Selectable check boxes
 * containing the ids equal to the row count(required for further manipulation). As well
 * as the content. Which then can be beautifully styled with css to craete an exquisite viewing pleasure. 
 */
 
 $colspan = $numberOfColumns+1;// sets the footer width in <tfoot> tag



//top right box 
 echo('<form name="table_row_select" action="controller.php" method="POST" >');
 echo('<table id="rounded-corner" summary="dynamic table">');
 echo('<thead>');
 echo('<tr>');
 echo('<th scope="col" class="rounded-company">Einzelteile</th>');
 for ($i = 0; $i <=  $numberOfColumns; $i++) 
 {
    //right most round box
 	if ($i == $numberOfColumns)
 	{
 	 echo"<th scope='col' class='rounded-q4'>$columnNames[$i]</th>  ";
 	}
 	else 
 	{
 	  echo"<th scope='col' class='rounded-q1'>$columnNames[$i]</th>  ";	
 	}
        	
 }
 
 echo('</tr>');
 echo('</thead>');
 
 echo('<tfoot>');
 echo('<tr>');
 echo("<td colspan='$colspan' class='rounded-foot-left'><input type='submit' name='newRow' value='Neu Anlegen' />");
 echo("<input type='submit' name='deleteRow' value='l&ouml;schen' /><input type='submit' name='changeRow' value='&auml;ndern' /></em></td>");
 echo("<td class='rounded-foot-right'>&nbsp;</td>");
 echo('</tr>');
 echo('</tfoot>');

 echo('<tbody>' );
 for ($k = 0; $k < $numberOfRows; $k++)  //print rows
 {
 	echo('<tr>');
 	for ($l = 0; $l <= $numberOfColumns+1; $l++) 
 	{
 
 	 echo('<td>');
 	 //make checkboxes
 	 if($l == 0)
 	 {
 	  //if collumn == 0 insert a check box|--> _".$k.
 	  echo"<input  type='checkbox' name='row[]' value='".$tableMatrix[$k][0]."' />";
 	 }
 	
 	 //else fill field with normal values
 	  
 	   echo($tableMatrix[$k][$l-1]);
 	   //echo $k.":".$l;
 	  
 	
 	 echo('</td>');
 		
 	}
  }
 	echo('</tr>');
 
 echo('</tbody>');
 echo('</table>');
 echo('</form>');
	
}











/*
 * This function allows for easy styled HTML output.
 * It takes 4 parameters: $fon;$col;$siz;$txt which specify the
 * font-face; color; size for the forth parameter($txt).
 * adittionaly this function relies on 2 Arrays one containing all of
 * the websafe fon names. The other color names with corresponding 
 * Hexadecimal values to represent them(all web safe colors of course)).
 */
function mkTXT($txt="no text was entered",$fon ='',$col='',$siz='')//font-face,color,size, message contenbt
{
    echo("<font face='$fon' color='$col' size='$siz'>$txt</font><br />");
}
//test function to return color values from color array
function getFonts($index)
{
  $i = 0;
  $col="";
  foreach ($GLOBALS['colors'] as $key)
  {
    if($i == $index)
    {
       $col = $key;
       return $col;
    }
    else
    {
        $i++;
    }

  }
}
    
    


//Font list
$font = array(
              "Impact","Verdana","COURIER","Arial","Arial Narrow",
              "Helvetica","sans-serif","georgia","Comic Sans MS",
              "cursive","monospace","Courier New","Trebuchet MS",
              "Gill Sans","Lucida Console","Copperplate Gothic Light",
              "Times New Roman");
//Acossiative websafecolor array
$colors = array("white"  => "#FFFFFF","silver" => "#C0C0C0","grey" => "#808080",
                "black"  => "#000000","red"    => "#FF0000","maroon" => "#800000",
                "yellow" => "#FFFF00","olive"  => "#808000","lime" => "#00FF00",
                "green"  => "#008000","aqua"   => "#00FFFF","teal" => "#008080",
                "blue"   => "#0000FF","navy"   => "#000080","fuchsia" => "#FF00FF",
                "purple" => "#800080"
                 );


//loop that iterates through all fonts
//for testing purposes
for ($i = 0; $i < count($font);$i++)
{
   $col = getFonts($i);
 //  mkTXT($font[$i],$col,$i,"My name is Earl!"); 
}


?>