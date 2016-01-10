<?php

namespace Dreamcoil;

class MysqlAdapter
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;
    private $unitTest;
    private $connection;
    private $table;
    private $opts;
    private $collectData;
	
	/**
	 * Creates a Mysql Connection
     *
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @param int $port
     * @param array $opts
     */
    public function __construct($host, $user, $password, $database, $port = 3306, array $opts = array())
    {

        $this->opts['collect'] = FALSE;

        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;

        if(isset($opts['collect'])) $this->opts['collect'] = $opts['collect'];

        $this->opts['charset'] = "utf8";

        if(isset($opts['charset'])) $this->opts['charset'] = $opts['charset'];

        $this->unitTest = FALSE;

    }

    /**
     * Checks if the connection is still alive
     *
     * @throws Exception
     */
    public function checkConnection()
    {

        if (mysqli_error($this->connection())) {

            throw new \Exception(mysqli_error($this->connection()));

            return false;

        }

        return true;

    }

    /**
     * @TODO: Build a better destructer 
     */
    public function __destruct()
    {

        if ($this->opts['collect']) $this->query($this->collectData);

    }

    /**
     * Creates the connection 
     */
    public function connect()
    {

        $this->connection = mysqli_connect(
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $this->port);

        mysqli_set_charset($this->connection, $this->opts['charset']);

        $this->checkConnection();

    }

    /**
     * Returns the current connection
     *
     * @return $this->connection;
     */
    public function connection()
    {

        return $this->connection;

    }

	/**
     * Runs a query and returns the result
     *
     * @param $query
     * @throws Exception
     * @return $result
     */
    public function query($query)
    {

        $query = mysqli_query($this->connection(), $query);

        $this->checkConnection();

        return $query;

    }

	/**
     * Runs multiple query and returns the result
     *
     * @param $querys
     * @throws Exception
     * @return $result
     */
    public function multi_query($querys)
    {

        $query = mysqli_multi_query($this->connection(), $querys);

        $this->checkConnection();

        return $query;

    }


	/**
     * @param bool $tableName
     * @return string
     */
    public function table($tableName = FALSE)
    {

        if(!$tableName) return $this->table;

        $this->table = $tableName;

    }

    /**
     * Fetches the data from a query
     *
     * @param $result   
     * @return array
     */
    public function fetch($result)
    {

        return mysqli_fetch_assoc($result);

    }


    /**
     * Fetches the data from a query and returns it in an array
     *
     * @param $result   
     * @return array
     */
    public function fetch_array($result)
    {

    	$i = 0;

    	$return = [];

    	while($data = $this->fetch($result))
    	{

    		$return[$i] = $data;

    		$i++;

    	}

    	return $return;

    }

    /**
     * @param $var
     */
    public function debug($var)
    {

        var_dump($var);

    }

    /**
     * @param array $data
     * @param bool $table
     * @return string
     */
    public function insert(array $data, $table = FALSE)
    {

        if ($table !== FALSE) $this->table = $table;


        if ($this->opts['collect']) echo NULL;

        $i = 0;

        foreach ($data as $row => $content) {

            $rows[$i] = "`" . $row . "`";

            if ($content == NULL) $values[$i] = "NULL";
            else $values[$i] = "'" . $this->webEscape($content) . "'";

            $i++;

        }

        $query = "INSERT INTO `" . $this->database . "`.`" . $this->table . "` ";

        $query .= "(" . implode(', ', $rows) . ") ";

        $query .= "VALUES (" . implode(', ', $values) . ");";

        if($this->unitTest) return $query;

        if (!$this->opts['collect']) $this->query($query);
        else $this->collectData .= "\n" . $query;

        return NULL;

    }

    /**
     * Get stats about the Mysql Server
     *
     * @return string
     * @throws Exception
     */
    public function stat()
    {

		if($this->checkConnection())
		{

    		return mysqli_stat($this->connection);

    	}
    	else throw new \Exception("Mysql Connection failed");

    }

	/**
	 * Escapes an data for a query
	 *
     * @param string $data
     * @return string
     */
    public function webEscape($data)
    {

    	$data = str_replace(
    		["<",    ">",    "'"    , "Ä"     , "ä"     , "Ö"     ,  "ö"    , "Ü"     , "ü"     ] , 
    		["&lt;", "&gt;", "&#39;", "&Auml;", "&auml;", "&Ouml;", "&ouml;", "&Uuml;", "&uuml;"] , 
    		$data);

    	return $data;

    }



}
