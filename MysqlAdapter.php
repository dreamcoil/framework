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

    /**
     * @var \mysqli
     */
    private $interface=null;
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

        $this->opts = array_merge($this->opts, $opts);

        $this->unitTest = FALSE;

    }

    /**
     * Creates the connection
     */
    public function connect()
    {
        $this->interface = new \mysqli($this->host, $this->user, $this->database, $this->port);

        if($this->checkConnection())  {
            $this->interface->set_charset("utf8");
        }
    }

    /**
     * Checks if the connection is still alive
     *
     * @throws \Exception
     */
    public function checkConnection()
    {
		if(is_bool($this->getInterface()) || is_null($this->getInterface())) {
			return false;
		}

        if ($this->getInterface()->error) {
            throw new \Exception($this->getInterface()->error);
        }

        return true;
    }

    /**
     * @TODO: Build a better destructer 
     */
    public function __destruct()
    {
        if ($this->opts['collect']) {
            $this->query($this->collectData);
        }
    }

	/**
     * Runs a query and returns the result
     *
     * @param $query
     * @throws \Exception
     * @return $result
     */
    public function query($query)
    {
		global $dreamcoilMysqliQueries;
		if(!isset($dreamcoilMysqliQueries)) $dreamcoilMysqliQueries = 1;
		else $dreamcoilMysqliQueries++;

		$this->getInterface()->query($query);

        $this->checkConnection();

        return $query;
    }

	/**
     * Runs multiple query and returns the result
     *
     * @param $querys
     * @throws \Exception
     * @return $result
     */
    public function multi_query($querys)
    {
        $this->getInterface()->multi_query($querys);

        $this->checkConnection();

        return $querys;
    }


	/**
     * @param bool $tableName
     * @return string
     */
    public function table($tableName = FALSE)
    {
        if($tableName) {
            $this->table = $tableName;
        }

        return $this->table;
    }


    /**
     * Fetches the data from a query and returns it in an array
     *
     * @param $result   
     * @return array
     */
    public function fetch_array(\mysqli_result $result)
    {
        return $result->fetch_assoc();
    }

    /**
     * Fetches the data from a query
     *
     * @param \mysqli_result $result
     * @return array
     */
    public function fetch(\mysqli_result $result)
    {
        return $this->fetch_array($result);
    }

    /**
     * @param array $data
     * @param bool $table
     * @return string
     */
    public function insert(array $data, $table = FALSE)
    {
        if ($table !== FALSE) {
            $this->table = $table;
        }

        if ($this->opts['collect']) {
            echo NULL;
        }

        $i = 0;
        $rows = $values = [];
        foreach ($data as $row => $content) {

            $rows[$i] = "`" . $row . "`";

            if ($content == NULL && $content != "") {
                $values[$i] = "NULL";
            }
            else {
                $values[$i] = "'" . $this->webEscape($content) . "'";
            }

            $i++;
        }

        $query = "INSERT INTO `" . $this->database . "`.`" . $this->table . "` ";

        $query .= "(" . implode(', ', $rows) . ") ";

        $query .= "VALUES (" . implode(', ', $values) . ");";

        if($this->unitTest) {
            return $query;
        }

        if (!$this->opts['collect']) {
            $this->query($query);
        }
        else {
            $this->collectData .= "\n" . $query;
        }

        return NULL;
    }

    /**
     * Get stats about the Mysql Server
     *
     * @return string
     * @throws \Exception
     */
    public function stat()
    {
		if($this->checkConnection())
		{
            return $this->getInterface()->stat();
    	}
    	else throw new \Exception("Mysql Connection failed");
    }

	/**
	 * Escapes an data for a query
	 *
     * @param string $data
     * @param bool $reverse
     * @return string
     */
    public function webEscape($data, $reverse = false)
    {
    	$data = str_replace($this->webEscapeCharacters($reverse)[0], $this->webEscapeCharacters($reverse)[1], $data);
    	return $data;
    }

    /**
     * @param bool $reverse
     * @return array
     */
    private function webEscapeCharacters($reverse = false) {
        $array1 = ["<",    ">",    "'"    , "Ä"     , "ä"     , "Ö"     ,  "ö"    , "Ü"     , "ü"     ];
        $array2 = ["&lt;", "&gt;", "&#39;", "&Auml;", "&auml;", "&Ouml;", "&ouml;", "&Uuml;", "&uuml;"];

        if($reverse) {
            return [$array2, $array1];
        }
        return [$array1, $array2];
    }

	public static function getQueryCount() 
	{
		global $dreamcoilMysqliQueries;
		if(isset($dreamcoilMysqliQueries)) {
		    return $dreamcoilMysqliQueries;
        }
        return 0;
	}
	
	/**
	 * @return array
	 */
	public function getCredentials()
	{
		$cred = [
			"host" => $this->host,
			"user" => $this->user,
			"password" =>  $this->password,
			"database" =>  $this->database
		];
		return $cred;
	}

    /**
     * @return \mysqli
     */
    public function getInterface()
    {
        return $this->interface;
    }

}
