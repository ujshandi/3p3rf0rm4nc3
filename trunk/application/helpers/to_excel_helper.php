<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
* Author: Derek Allard, Dark Horse Consulting, www.darkhorse.to, April 2006
  Modified by Chan
*/

function to_excel($query, $filename='exceloutput',$colHeaders='')
{
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below
     
     $obj =& get_instance();
	
     //$fields = $query->list_fields();
   //var_dump($query);die;     
     if ($query->num_rows() == 0) {
          echo '<p>The table appears to have no data.</p>';
     } else {
        if ($colHeaders==''){
		 	$fields = $query->field_data();
			foreach ($fields as $field) {
				$headers .= $field->name . "\t";
			}
		}
		else {
			$fields = $colHeaders;
			foreach ($fields as $field) {
				$headers .= $field. "\t";
			}
		}
		 
     
          foreach ($query->result() as $row) {
               $line = '';
               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         $value = "\t";
                    } else {
                         $value = str_replace('"', '""', $value);
                         $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
               }
               $data .= trim($line)."\n";
          }
          
          $data = str_replace("\r","",$data);
                      
          header("Content-type: application/x-msdownload");
          header("Content-Disposition: attachment; filename=$filename.xls");
          echo "$headers\n$data";  
     }
}



function to_csv($query, $filename='exceloutput')
{
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below
     
     $obj =& get_instance();
     $fields = $query->field_data();
   
     if ($query->num_rows() == 0) {
          echo '<p>The table appears to have no data.</p>';
     } else {
          foreach ($fields as $field) {
             $headers .= $field->name . ";";//"\t";
          }
     
          foreach ($query->result() as $row) {
               $line = '';
               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         $value = ";";//"\t";
                    } else {
                         $value = str_replace('"', '""', $value);
                         $value = '"' . $value . '"' . ";";//"\t";
                    }
                    $line .= $value;
               }
               //$data .= trim($line)."\n";
               $data .= $line."\n";
          }
          
          $data = str_replace("\r","",$data);
         //    var_dump($headers);die;              
          header("Content-type: application/x-msdownload");
          header("Content-Disposition: attachment; filename=$filename.csv");
		  header("Content-type: text/csv");
          echo "$headers\n$data";  
     }
}

function to_txt($query, $filename='exceloutput',$withoutRowNum=false)
{
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below
     
     $obj =& get_instance();
     $fields = $query->field_data();
   
     if ($query->num_rows() == 0) {
          echo '<p>The table appears to have no data.</p>';
     } else {
		  $i=0;
          foreach ($fields as $field) {
             //chan if ($i==0) $headers .= "#". "\t";
             if (($i==0)&&($withoutRowNum==false)) $headers .= "#". "\t";
			 $headers .= $field->name . "\t";
			 $i++;
          }
			 $i=1;
          foreach ($query->result() as $row) {
               //chan $line = $i. "\t";
			   if ($withoutRowNum==false) $line = $i. "\t";
			   else $line = "";
               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         $value = "\t";
                    } else {
                         $value = str_replace('"', '""', $value);
                         $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
               }
               //$data .= trim($line)."\n";
               $data .= $line."\n";
			   $i++;
          }
          
          $data = str_replace("\r","",$data);
         //    var_dump($headers);die;              Content-Type: text/plain
          header("Content-type: application/x-msdownload");
          header("Content-Disposition: attachment; filename=$filename.txt");
		  header("Content-type:  text/plain");
          echo "$headers\n$data";  
     }
}


function to_myob($query, $filename='exceloutput',$withoutRowNum=false)
{
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below
     
     $obj =& get_instance();
     $fields = $query->field_data();
   
     if ($query->num_rows() == 0) {
          echo '<p>The table appears to have no data.</p>';
     } else {
		  $i=0;
          foreach ($fields as $field) {
             //chan if ($i==0) $headers .= "#". "\t";
             if (($i==0)&&($withoutRowNum==false)) $headers .= "#". "\t";
			 $headers .= $field->name . "\t";
			 $i++;
          }
			 $i=1;
          foreach ($query->result() as $row) {
               //chan $line = $i. "\t";
			   if ($withoutRowNum==false) $line = $i. "\t";
			   else $line = "";
               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         $value = "\t";
                    } else {
                         $value = str_replace('"', '""', $value);
                         //$value = '"' . $value . '"' . "\t";
                         $value =  $value . "\t";
                    }
                    $line .= $value;
               }
               //$data .= trim($line)."\n";
               $data .= $line."\r\n";
			   $i++;
          }
          
        //  $data = str_replace("\r","",$data);
         //    var_dump($headers);die;              Content-Type: text/plain
          header("Content-type: application/x-msdownload");		  
		  //header("Content-type: application/vnd.ms-excel");
		  header("Content-type:  text/csv");
          header("Content-Disposition: attachment; filename=$filename.txt");
		  
		  echo "$headers\r\n$data";  
     }
}
?>