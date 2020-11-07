<?php 
    function query_database($query){
        $result = [];
        $serverName = $_ENV['database.default.hostname'];
        $connectionInfo = [
            "Database" => $_ENV['database.default.database'],
            "UID" => $_ENV['database.default.username'],
            "PWD" => $_ENV['database.default.password'],
            'ReturnDatesAsStrings'	=> 1,
            'CharacterSet'		=> 'UTF-8'
        ];
        $conn = sqlsrv_connect($serverName, $connectionInfo);
        sqlsrv_configure('WarningsReturnAsErrors',false);
        print_r(sqlsrv_get_config('WarningsReturnAsErrors'));
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $stmt = sqlsrv_query($conn, $query);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (gettype($stmt) === 'resource') {
           $result = getData($stmt);            
        }

        sqlsrv_free_stmt($stmt);
        return $result;
    }
    function getData($stmt){
        $result = [];
        if(sqlsrv_has_rows($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) $result[] = $row;
            return $result;
        }
        else {
            if (!sqlsrv_next_result($stmt)) return $result;
            return getData($stmt);
        }
        
    }
?>