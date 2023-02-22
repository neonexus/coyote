<?php

if(!defined('IN_COYOTE'))
    die("Can not access this file directly!");

class DbLib
{
    
    var	$mSocket, $mResult, $mRow;
    var $mCount = 0;

    function OpenConnection()		{	$this->mSocket  =  1;		}


    function Query()				{	$this->IsConnected();		}
    function GetResult()			{	$this->IsConnected();		}
    function GetNumRows()			{	$this->IsConnected();		}


    function FetchArray()			{	$this->IsConnected();		} //Added 10 JAN 2007



    function CloseConnection()	    {	$this->IsConnected();		}


    function __wakeup()				{	$this->OpenConnection();	}
    function __sleep()				{	$this->CloseConnection();	}
    function IsConnected()
    {
        if (!$this->mSocket) die('Not connected to database server');
    }
    
}
    
///////////////////////////////////////////////////////////////////////////////
// MySQL database support
class DbLibMySQL extends DbLib
{
	private static $mHost,$mPort,$mUser,$mPassword,$mDatabase;
    
    function DbLibMySQL($host = 0, $port = 0, $user = 0, $password = 0, $database = 0) 
    {
        global $strings;
        if(file_exists("config/db_config.php")){
            require_once("config/db_config.php");
        } else {
            die("Could not open database config file!");
        }
        if ($host)      self::$mHost      = $host;
        if ($port)      self::$mPort      = $port;
        if ($user)      self::$mUser      = $user;
        if ($password)  self::$mPassword  = $password;
        if ($database)  self::$mDatabase  = $database;
    }

    
    function OpenConnection()
    {
        parent::OpenConnection();
        $this->mSocket = @mysql_connect(self::$mHost . ':' . self::$mPort, self::$mUser, self::$mPassword)
            or trigger_error($this->GetError(), E_USER_WARNING);
        @mysql_select_db(self::$mDatabase,$this->mSocket)
            or trigger_error($this->GetError(), E_USER_WARNING);
        //$this->DbQuery("SET NAMES '{$this->DefCharset}'");
        return $this->mSocket;
    }
    
    function Query($query = '')
    {
        parent::Query();
        $this->mCount++;
        ($this->mResult = @mysql_query($query,$this->mSocket)) or die($this->GetError());
        return $this->mResult;
    }


    function GetResult($row = 0, $coll = 0, $result = 0)	
    {
        parent::GetResult();
        ($result) ? $temp_result = $result : $temp_result = $this->mResult;

        if (!is_resource($temp_result)) 	      die('Not MySQL resource while getting results');
        return @mysql_result($temp_result,$row,$coll);
    }

    
    function GetNumRows($result = 0)
    {
        parent::GetNumRows();
        ($result) ? $temp_result = $result : $temp_result = $this->mResult;

        if (!is_resource($temp_result)) 	      die('Not MySQL resource while getting results');	
        return @mysql_num_rows($temp_result);
    }
    
    function FetchArray($type = MYSQL_ASSOC)
    {
        parent::FetchArray();
        return @mysql_fetch_array($this->mResult, $type);
    }
   
    function CloseConnection()
    {
        parent::CloseConnection();
        @mysql_close($this->mSocket) or trigger_error('There is no valid MySQL-Link resource', E_USER_WARNING);
    }
    
    
    function GetQueryCount()
    {
        return $this->mCount;
    }

}
?>
