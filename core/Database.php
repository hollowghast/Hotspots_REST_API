<?php

require_once dirname(__FILE__) . '/./HTTP_Status_Codes.php';
require_once dirname(__FILE__) . '/./HTTP_Response.php';

/**
 * Class for accessing our DB.
 * It will store the connection for future uses,
 * by persisting it (as we do not use any other modules/plugins
 * which would need such a connection.
 * 
 * After instantiation @method type methodName(type $paramName) Description
 * 
 * @author Daniel
 */
class Database {

    private static $local_host = "localhost";
    private static $local_db_name = "DiplomaThesis";
    private static $local_username = "postgres";
    private static $local_password = "postgres";
    
    private static $remote_host = "localhost";
    private static $remote_db_name = "deudaz15";
    private static $remote_username = "deudaz15";
    private static $remote_password = "deudaz15";
    
    private static $conn;

    public static function getConnection() {

        if(Database::$conn != null){
            return Database::$conn;
        }
        
        Database::$conn = null;

        $host = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);

        try {
            if ($host == 'localhost') {
                Database::$conn = new PDO("pgsql:host=" . Database::$local_host . ";dbname=" . Database::$local_db_name, Database::$local_username, Database::$local_password, array(
                    PDO::ATTR_PERSISTENT => true //for performance
                ));
            } else {
                Database::$conn = new PDO("pgsql:host=" . Database::$remote_host . ";dbname=" . Database::$remote_db_name, Database::$remote_username, Database::$remote_password, array(
                    PDO::ATTR_PERSISTENT => true //for performance
                ));
            }
            Database::$conn->exec("set names utf8");
            //echo "Successfully connected to DB.";
        } catch (PDOException $exception) {
            //echo "Connection error: " . $exception->getMessage();
            http_response_code(HTTP_Status_Codes::INTERNAL_SERVER_ERROR);        
            die;
        }

        return Database::$conn;
    }

}
