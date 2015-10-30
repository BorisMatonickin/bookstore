<?php
    class Mysqldb {
        /*
         * database connection
         */
        private $_connection = NULL;
 
        /*
         * record of the last query
         */
        private $_last;
        
        /*
         * default fetch mode
         */
        private $_fetchMode = PDO::FETCH_ASSOC;
        
        /*
         * reference to the registry object
         */
        private $_registry;
        
        /*
         * construct the database object, loads registry object
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            $this->_registry = $registry;
        }
        
        /*
         * create a new database connection
         * @param string $host - database hostname
         * @param string $user - database username
         * @param string $password - databae password
         * @param string $database - database used for connection
         * @return int the id of the new connection
         */
        public function newConnection($host, $database, $user, $password) {
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                $this->_connection = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password, $options);
            } catch (PDOException $e) {
                $this->_connection = NULL;
                echo 'Error connecting to host ' . $e->getMessage();
                exit();
            }
            return $this->_connection;
        }
        
        /*
         * execute a query string
         * @param string $queryStr - the query
         * @param array $params - parameters for executing in query
         */
        public function query($queryStr = NULL, $params = NULL) {
            $stmt = $this->_connection->prepare($queryStr);
            if (!$stmt) {
                $errorInfo = $this->_connection->errorInfo();
                throw new PDOException("Database error {$errorInfo[0]}: {$errorInfo[2]}");
            }
            $paramsConverted = array();
            if (get_magic_quotes_gpc() === true) {
                if (is_array($params)) {
                    foreach ($params as $key => $value) {
                        $paramsConverted[$key] = stripslashes($value);
                    }
                } else {
                    $paramsConverted[] = stripslashes($params);
                }
            } else {
                $paramsConverted = is_array($params) ? $params : array($params);
            }
            
            // checking if statement is executed properly
            if (!$stmt->execute($paramsConverted)) {
                $errorInfo = $stmt->errorInfo();
                throw new PDOException("Database error{$errorInfo[0]}: {$errorInfo[2]}");
            } else {
                return $this->_last = $stmt;
            }
        }
        
        /*
         * sets PDO fetch mode
         * @param $fetchMode - PDO fetchMode
         */
        public function setFetchMode($fetchMode) {
            return $this->_fetchMode = $fetchMode;
        }
        
        /*
         * gets fetched rows according to PDO fetch mode
         */
        public function getRows() {
            try {
                return $this->_last->fetch($this->_fetchMode);
            } catch (PDOException $e) {
                echo 'Fetching failed ' . $e->getMessage();
            }
            return false;
        }
        
        /*
         * gets the number of affected rows from the previous query
         * @return int - the number of affected rows
         */
        public function affectedRows() {
            try {
                return $this->_last->rowCount();
            } catch (PDOException $e) {
                echo 'No affected rows ' . $e->getMessage();
            }
            return false;
        }
        
        /*
         * executes query with parameters for prepared statement
         * @param string $queryStr - the query
         * @param array $params - array of values for prepared statement
         */
        public function execute($queryStr = NULL, $params = NULL) {
            if (!empty($queryStr)) {
                try {
                   // $stmt = $this->query($queryStr, $params);
                    return $this->query($queryStr, $params);
                } catch (PDOException $e) {
                    echo 'Execution failed' . $e->getMessage();
                }
                return false;
            }
        }
        
        /*
         * creates array used in insert query with prepared statements
         * @param array $array - array of fields and values to be inserted 
         *   into database
         * @param string $pre - used as letter before database field in 
         *   advanced and complex queries (u.id, u.firstName etc)
         * @return array - the array to be used in the insert query - index[0] 
         *   contains database fields, index[2] placeholders (?) and index[3] values
         */
        private function insertArray($array = NULL, $pre = NULL) {
            if (!empty($array) && is_array($array)) {
                $fields = array();
                $holders = array();
                $values = array();
                foreach ($array as $key => $value) {
                    $fields[] = !empty($pre) ? "`{$pre}.{$key}`" : "`{$key}`";
                    $holders[] = "?";
                    $values[] = $value;
                }
                return array($fields, $holders, $values);
            }
        }
        
        /*
         * inserts data into database table uses array prepared for inserting 
         *  in private method insertArray()
         * @param string $table - the table for inserting data
         * @param array $array - array of database fields and values to be
         *   entered in those fields ( field => value)
         * @return bool
         */
        public function insert($table = NULL, $array = NULL) {
            $preparedArray = $this->insertArray($array);
            if (!empty($table) && !empty($array)) {
                $queryStr = "INSERT INTO `{$table}` (";
                $queryStr .= implode(", ", $preparedArray[0]); // index[0] contains database fields
                $queryStr .= ") VALUES (";
                $queryStr .= implode(", ", $preparedArray[1]); // index[1] contains placeholders(?)
                $queryStr .= ")";
                // index[2] contains values to be inserted
                return $this->execute($queryStr, $preparedArray[2]) ? true : false;
            }
            return false;
        }
        
        /*
         * creates array used in update query with prepared statements
         * @param array $array - array of fields and values to be inserted 
         *   into database
         * @param string $pre - used as letter before database field in 
         *   advanced and complex queries (u.id, u.firstName etc)
         * @return array - the array to be used in the update query index[0] 
         *   contains database fields and index[1] values
         */
        private function updateArray($array = NULL, $pre = NULL) {
            if (!empty($array) && is_array($array)) {
                $fields = array();
                $values = array();
                foreach ($array as $key => $value) {
                    $fields[] = !empty($pre) ? "`{$pre}.{$key}` = ?" : "`{$key}` = ?";
                    $values[] = $value;
                }
                return array($fields, $values);
            }
        }
        
        /*
         * update database table field, uses array prepared for insert in private
         *   method updateArray()
         * @param string $table - table for updating
         * @param array $array - array of database fields and values to be
         *   entered in those fields ( field => value)
         * @param mixed $value - value of condition 
         * @param string $field - field of condition (default is id)
         * @return bool
         */
        public function update($table = NULL, $array = NULL, $value = NULL, $field = 'id') {
            if (!empty($table) && !empty($array) && !empty($value) && !empty($field)) {
                $preparedArray = $this->updateArray($array);
                $queryStr = "UPDATE `{$table}` SET ";
                $queryStr .= implode(", ", $preparedArray[0]); // index[0] contains database fields
                $queryStr .= " WHERE `{$field}` = ?";
                // returned array from updateArray method contains values
                $preparedArray[1][] = $value;
                // binding values to placeholders
                return $this->execute($queryStr, $preparedArray[1]) ? true : false;  
            }
            return false;
        }
        
        /*
         * delete row in database table
         * @param string $table - table
         * @param mixed $value - value of condition
         * @param string $field - field of condition (default is id)
         * @param int $limit - limit in delete SQL query
         */
        public function delete($table = NULL, $value = NULL, $field = 'id') {
            if (!empty($table) && !empty($value) && !empty($field)) {
                $queryStr = "DELETE FROM `{$table}`";
                $queryStr .= " WHERE `{$field}` = ?";
                return $this->execute($queryStr, $value) ? true : false;
            }
            return false;
        }
        
        /*
         * selects one row from database table
         * @param string $table - table name
         * @param mixed $value - value of condition
         * @param string $field - field to check in condition (default is id)
         * @return array - fetched rows from database table 
         */
        public function selectOne($table = NULL, $value = NULL, $field = 'id') {
            if (!empty($table) && !empty($value) && !empty($field)) {
                $queryStr = "SELECT * FROM `{$table}` WHERE `{$field}` = ?";
                if ($this->execute($queryStr, $value)) {
                    return $this->getRows();
                } else {
                    return false;
                }
            }
            return false;
        }
        
        /*
         * creates two-dimensional array, main index in the first dimension of an array must be set
         * @param string $queryStr - SQL query
         * @param string $mainIndex - main index in the first dimension of an array
         * @param array $params - parameters for prepared statements queries (optional argument)
         * @return array
         */
        public function makeMultiDataArray($queryStr, $mainIndex = NULL, $params = NULL) {
            $dataArray = array();
            if (!empty($queryStr)) { 
                if (isset($params) && is_array($params)) { 
                    $this->execute($queryStr, $params);
                } else {
                    $this->execute($queryStr);
                }   
                while ($row = $this->getRows()) {
                    if (isset($mainIndex)) {
                       $dataArray[$row[$mainIndex]] = $row;
                    }
                }
                return $dataArray;
            }
        }
        
        /*
         * creates one-dimensional associative array
         * @param string $queryStr - SQL query
         * @param array $params - parameters for prepared statements queries (optional argument);
         * @return array
         */
        public function makeAssocArray($queryStr, $params = NULL) {
            $dataArray = array();
            if (!empty($queryStr)) {
                if (isset($params) && is_array($params)) {
                    $this->execute($queryStr, $params);
                } else {
                    $this->execute($queryStr);
                }
                while ($row = $this->getRows()) {
                    $dataArray = $row;
                }
                return $dataArray;
            }
        }
        
        /*
         * creates one-dimensional data array from query
         * @param string $queryStr - SQL query
         * @param string $index - indexes for array
         * @param string $value - values for indexes in array
         * @param array $params - parameters for prepared statements queries (optional argument)
         */
        public function makeDataArray($queryStr, $index, $value, $params = NULL) {
            $dataArray = array();
            if (!empty($queryStr)) {
                if (isset($params) && is_array($params)) {
                    $this->execute($queryStr, $params);
                } else {
                    $this->execute($queryStr);
                }
                while ($row = $this->getRows()) {
                    $dataArray[$row[$index]] = $row[$value];
                }
                return $dataArray;
            }
        }
        
        /*
         * gets last inserted id
         */
        public function lastInsertId() {
            return $this->_connection->lastInsertId();
        }
    }