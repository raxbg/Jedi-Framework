<?php
class dbHandler
{
    private $host;
    private $username;
    private $password;
    private $db;
    
    public static $con;
       
    public function __construct()
    {
        $this->host = DB_HOST;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->db = DB_NAME;
        $this->dbConnect();
    }
    
    public function __destruct()
    {
    	$this->dbDisconnect();
    }
    
    public function dbConnect()
    {
		global $system;
		
    	if (empty(self::$con))
    	{
	        self::$con = mysql_connect($this->host,$this->username,$this->password);
	        if (!self::$con)
	          {
	            die('Could not connect: ' . mysql_error());
	          }
	        mysql_select_db($this->db, self::$con);
	        mysql_query("SET NAMES 'utf8'", self::$con);
	        $system->registerDbConnect();
    	}
    }
    
    
    public function EncryptPwd($password)
    {
        $password = mysql_real_escape_string($password);
        $query = "SELECT SHA1('{$password}')";
        $result = mysql_query($query);
        $password = mysql_fetch_row($result);
        return $password[0];
    }
    
    
    public function dbDisconnect()
    {
		global $system;
		
        if(!empty(self::$con))
        {
	    	if (mysql_close(self::$con))
	        {
	        	self::$con = false;
	        	$system->unregisterDbConnection();
	        }
        }
    }
    
    public function Connection()
    {
        return self::$con;
    }

    public function ExecuteQuery($query)
    {
        if ($result = mysql_query($query,self::$con)) return $result;
        else
        {
	    	error_log($_SERVER['SCRIPT_FILENAME'].' - '.mysql_error());
            return false;
        }
    }
    
    public function MakeSelectOptions($query, $key, $value, $mustSelect = NULL)
    {
        $options="";
        $result = $this->ExecuteQuery($query);
        if($result && mysql_num_rows($result)>0)
        {
            while($option = mysql_fetch_array($result))
            {
                if($mustSelect != NULL)
                {
                    $options.="<option value=\"{$option[$key]}\"";
                    if ($option[$key] == $mustSelect)
                    {
                        $options .= " selected=\"selected\"";
                    }
                    $options .= ">";
                }
                else
                {
                    $options.="<option value=\"{$option[$key]}\">";
                }
                $options.= $option[$value]." ";
                $options.="</option>\n";
            }
        }
        return $options;
    }
}
?>
