<?

class MySQL
{
var $CONN = "";                       

var $DBASE = "wlsxsql";                
var $USER = "root"; 
var $PASS = "Zjcstwx2000";
var $SERVER = "localhost:3306"; 

var $LSTART;  //limit LSTART,NUMEVERYPAGE
var $NUMEVERYPAGE; 
var $TOTAL; //Total records
var $PAGE;  //current page
var $TOTALPAGE;

function connect()
  {
    $conn = @mysql_connect($this->SERVER,$this->USER,$this->PASS);
    $select_db=@mysql_select_db($this->DBASE,$conn);
    if($conn && $select_db)
      {
        $this->CONN = $conn;
        return ture;
      }
    return false;
  }

function select($sql="")
  {
    if(empty($sql))             return false;
    if(!eregi("^select",$sql))  return false;
    if(empty($this->CONN))      return false;
	//mysql_query("set charsets utf8");
    $conn = $this->CONN;
    $results = @mysql_query($sql,$conn);
    if(!$results or empty($results))
     {
       @mysql_free_result($results);
       return false;
     }
    else
      {
        $count = 0;
        $data = array();
        while ( $row = @mysql_fetch_array($results))
          {
            $data[$count] = $row;
            $count++;
          }

        @mysql_free_result($results);
        return $data;
     }
  }

function insert($sql="")
  {
    if(empty($sql))            return false; 
    if(!eregi("^insert",$sql)) return false;
    if(empty($this->CONN))     return false; 

    $conn = $this->CONN;
    $results = @mysql_query($sql,$conn);
    if($results)  return  true;
    else return false;
   }



function update($sql="")
  {
     if(empty($sql))            return false;
     if(!eregi("^update",$sql)) return false;
     if(empty($this->CONN))     return false;

     $conn = $this->CONN;
     $results = @mysql_query($sql,$conn);
     if($results)  return true;
     return false;
  }


function del($sql="")
  {
     if(empty($sql)) return false;
     if(!eregi("^delete",$sql)) return false;
     if(empty($this->CONN))  return false;

     $conn = $this->CONN;
     $results = @mysql_query($sql,$conn);
     if($results) return true;
     else  return false;
  }

}
if(!empty($_GET)) extract($_GET); 
if(!empty($_POST)) extract($_POST); 
if(!empty($_COOKIE)) extract($_COOKIE); 
if(!empty($_SESSION)) extract($_SESSION);
?>
