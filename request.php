<?php

//one way - but I'd prefer having them all in one class (export to another file in the future...)
//define("UNAUTHORIED_ACCESS", "401");
define("API_KEY", "27b3d62b3dtzv3dwv63dwvh3gv");


/*
 * ------------------------------ MAIN APPLICATION ------------------------------
 */

authentication(); //only continues when successful
//connect to DB
$db = new Database();
$conn = $db->getConnection();

check_for_eggs();

create_RegularUser($conn);

get_specific_RegularUser($conn);

get_specific_Place();




/*
 * ------------------------- FUNCTIONAL SECTION -----------------------------
 */

/*
 * to prevent unallowed access
 */

function authentication() {
    $key = filter_input(INPUT_GET, "key", FILTER_SANITIZE_STRING);
    if ($key != API_KEY) {
        //http_response_code(UNAUTHORIZED_ACCESS);
        http_response_code(HTTP_STATUS_CODES::UNAUTHORIZED);
        echo json_encode(
                array(
                    "message" => "Authentication required"
                )
        );
        die;
    }
}

/*
 * just for fun
 */

function check_for_eggs() {
    if (filter_input(INPUT_GET, "need", FILTER_SANITIZE_STRING) == "coffee") {
        http_response_code(HTTP_STATUS_CODES::TEAPOT);
        echo json_encode(
                array(
                    "message" => "The server refuses the attempt to brew coffee with a teapot."
                )
        );
    }
}

/**
 * Creates new User ignoring any DoS attempts.
 * No security implemented.
 * 
 * @param Database $conn Reference to Database-Object
 */
function create_RegularUser($conn) {
    //get User-Data to register
    $data = json_decode(file_get_contents("php://input"));
    if (empty($data->username) || empty($data->password)) {
        //can't create user
    } else {
        //create user
        $u = new RegularUser($conn);
        $u->setUsername($data->username);
        $u->setPassword($data->password); //hashing
        if ($u->createNewUser()) {
            echo "User created";
        } else {
            //not
        }
    }
}

function get_specific_RegularUser($conn) {
    $userid = filter_input(INPUT_GET, "userid", FILTER_VALIDATE_INT);

    if ($userid != null) {
        //access to user view (id, username, creation_tstmp)
        if ($userid >= 0) {
            $u = new RegularUser($conn);
            $u->getUserByID($userid);
            http_response_code(HTTP_STATUS_CODES::OK);
//            echo json_encode($u);
            $user_arr = array(
                'id' => $u->getUserID(),
                'username' => $u->getUsername(),
                'creation' => $u->getCreation(),
                'last_modified' => $u->getLastModified()
            );
            echo json_encode($user_arr);
        }
        //if user found
        //testdata
        else if ($userid == "-1") {
            http_response_code(HTTP_STATUS_CODES::OK);
            echo json_encode(
                    array(
                        array(
                            "id" => "$userid",
                            "username" => "some fictional user",
                            "created" => "267436276276"
                        )
                    )
            );
        } else {
            http_response_code(404);
            echo json_encode(
                    array(
                        "message" => "User not found."
                    )
            );
        }
    }
}

function get_specific_Place() {
    $placeid = filter_input(INPUT_GET, "placeid", FILTER_VALIDATE_INT);
    if ($placeid != null) {

        http_response_code(200);
        echo json_encode(
                array(
                    array(
                        "id" => "$placeid",
                        "long" => "12.35126352",
                        "lat" => "0.152632123",
                        "title" => "somewhere only we know"
                    )
                )
        );
    }
}

function login($conn) {
    //get User-Data to login
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->username) || !empty($data->password)) {
        //log in
        $u = new RegularUser($conn);
        $u->setUsername($data->username);
        $u->setPassword($data->password); //hashing is needed
        $u->login();
        
        http_response_code(HTTP_STATUS_CODES::OK);
        echo json_encode(array(
            "userid" => $u->getUserID()
        ));
    } else {
        //unable to login
        die;
    }
}

/*
 * ------------------- DATA SECTION -------------------------
 */

/**
 * The below status codes are defined by section 10 of RFC 2616.
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Status HTTP-Status-Codes
 */
class HTTP_STATUS_CODES {

    //Informational responses (100–199)
    //Successful responses (200–299)
    const OK = 200;
    //Redirects (300–399)
    //Client errors (400–499)
    const UNAUTHORIZED = 401;
    const NOT_FOUND = 404;
    const TEAPOT = 418;

    //Server errors (500–599)
}


class RegularUser {

    private $userid;
    private $username;
    private $password;
    private $creation;
    private $last_modified;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserID() {
        return $this->userid;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getCreation() {
        return $this->creation;
    }

    public function getLastModified() {
        return $this->last_modified;
    }

    public function createNewUser() {
        $query = 'INSERT INTO RegularUser(username, pass)' .
                ' VALUES(:username, :pass);';

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":pass", $this->password);

        return $stmt->execute();
    }

    public function getUserByID($id) {
        $query = 'SELECT * FROM RegularUser WHERE userid = :id;';

        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->userid = $rows['userid'];
        $this->username = $rows['username'];
        $this->creation = $rows['creation'];
        $this->last_modified = $rows['last_modified'];
    }

    /**
     * Make sure to set Username and Password attributes before trying
     * to log in.
     */
    public function login() {
        if (($this->username != null) && ($this->password != null)) {
            //test
            $this->userid = -1;
        }
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password; //needs hashing
    }

}

class Database {

    private $local_host = "localhost";
    private $local_db_name = "DiplomaThesis";
    private $local_username = "postgres";
    private $local_password = "postgres";
    
    private $remote_host = "localhost";
    private $remote_db_name = "deudaz15";
    private $remote_username = "deudaz15";
    private $remote_password = "deudaz15";
    
    private $conn;

    public function getConnection() {

        $this->conn = null;

        $host = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);

        try {
            if ($host == 'localhost') {
                $this->conn = new PDO("pgsql:host=" . $this->local_host . ";dbname=" . $this->local_db_name, $this->local_username, $this->local_password, array(
                    PDO::ATTR_PERSISTENT => true //for performance
                ));
            } else {
                $this->conn = new PDO("pgsql:host=" . $this->remote_host . ";dbname=" . $this->remote_db_name, $this->remote_username, $this->remote_password, array(
                    PDO::ATTR_PERSISTENT => true //for performance
                ));
            }
            $this->conn->exec("set names utf8");
            echo "Successfully connected to DB.";
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;

    }

}
?>