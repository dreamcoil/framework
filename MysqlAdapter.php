<?php

namespace Dreamcoil;

function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}

class MysqlAdapter
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;
    public $unitTest;

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
        $this->opts['webEscape'] = TRUE;

        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;

        $this->opts = array_merge($this->opts, $opts);

        $this->unitTest = FALSE;
    }

    /**
     * @param string $option
     * @throws \Exception
     */
    private function existsOption($option)
    {
        if(!isset($this->opts[$option])) {
            throw new \Exception("MysqlAdapter option '".$option."' doesn't exists");
        }
    }

    /**
     * @param string $option
     * @param mixed $value
     */
    public function setOption($option, $value)
    {
        $this->existsOption($option);
        $this->opts[$option] = $value;
    }

    /**
     * Creates the connection
     */
    public function connect()
    {
        $this->interface = new \mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

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

        if (null !== $this->getInterface()->connect_error) {
            throw new \Dreamcoil\Exception\MysqlAdapter($this->getInterface()->connect_errno." (".$this->getInterface()->connect_errno.")");
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

        if(!is_null($this->interface)) {
            $this->interface->close();
            $this->interface = null;
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
        if(!isset($dreamcoilMysqliQueries)) {
            $dreamcoilMysqliQueries = [];
        }
        $dreamcoilMysqliQueries[] = $query;

        $this->checkConnection();

        $result = $this->getInterface()->query($query);
        return $result;
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
     * Fetches the data from a query
     *
     * @param \mysqli_result $result
     * @return array
     */
    public function fetch(\mysqli_result $result)
    {
        return $result->fetch_assoc();
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
        $rows = $values = $questionMarks = $vars = [];
        foreach ($data as $row => $content) {

            $rows[$i] = "`" . $row . "`";
            $questionMarks[$i] = "?";


            if (is_null($content)) {
                $values[$i] = "NULL";
                $vars[$i] = null;
            } else {
                if($this->opts['webEscape']) {
                    $content = $this->webEscape($content);
                }
                $vars[$i] = $content;
                $values[$i] = "'" . $content . "'";
            }

            $i++;
        }

        $query = "INSERT INTO `" . $this->database . "`.`" . $this->table . "` ";
        $query .= "(" . implode(', ', $rows) . ") ";
        $preparedQuery = $query;
        $query .= "VALUES (" . implode(', ', $values) . ");";
        $preparedQuery .= "VALUES (" . implode(', ', $questionMarks) . ");";

        if($this->unitTest) {
            return $query;
        }

        if (!$this->opts['collect']) {
            $statement = $this->getInterface()->prepare($preparedQuery);
            if($statement === false) {
                throw new \Exception("Can't prepare Mysql Query: ".$preparedQuery);
            }
            
            $var_types = '';
            foreach ($vars as $var) {
                $var_type = gettype($var);
                if($var_type == 'integer') {
                    $var_type = 'i';
                } else if($var_type == 'double') {
                    $var_type = 'd';
                } else if($var_type == 'string' || is_null($var)) {
                    $var_type = 's';
                } else {
                    throw new \Exception("MysqlAdapter cannot bind ".var_export($var, true).":".$var_type);
                }
                $var_types .= $var_type;
            }

            $vars = array_merge([-1 => $var_types], $vars);

            call_user_func_array(array($statement, "bind_param"), refValues($vars));
            $statement->execute();

            return $statement->id;
        }
        else {
            $this->collectData .= "\n" . $query;
        }

        return NULL;
    }


    /**
     * @param $fields
     * @param $table
     * @param null $where
     * @return null|string
     */
    public function update(array $fields, $table = FALSE, $where = NULL)
    {
        if ($table !== FALSE) {
            $this->table = $table;
        }

        // There are no fields to update
        if(count($fields) == 0) {
            return NULL;
        }

        $sets = [];
        foreach ($fields as $field => $value) {
            if($this->opts['webEscape'] && !is_null($value)) {
                $value = $this->webEscape($value);
            }
            if(is_null($value)) {
                $sets[] = "`".$field."` = NULL";
            } else {
                $sets[] = "`".$field."` = '" . $value . "'";
            }
        }
        $query  = "UPDATE `" . $this->database . "`.`" . $this->table . "` ";
        $query .= "SET ".implode(", ", $sets);

        if(!is_null($where)) {
            $query .= " WHERE ".$where;
        }

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
        else throw new \Dreamcoil\Exception\MysqlAdapter("Mysql Connection failed");
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

    public static function getExecutedQuerys()
    {
        global $dreamcoilMysqliQueries;
        if(isset($dreamcoilMysqliQueries)) {
            return $dreamcoilMysqliQueries;
        }
        return [];
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
