<?php
class MySQLDao {
var $dbhost = null;
var $dbuser = null;
var $dbpass = null;
var $conn = null;
var $dbname = null;
var $result = null;

function __construct() {
$this->dbhost = Conn::$dbhost;
$this->dbuser = Conn::$dbuser;
$this->dbpass = Conn::$dbpass;
$this->dbname = Conn::$dbname;
}

public function openConnection() {
$this->conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
 $this->conn->query("SET NAMES 'utf8'");
if (mysqli_connect_errno())
echo new Exception("Could not establish connection with database");
}

public function getConnection() {
return $this->conn;
}

public function closeConnection() {
if ($this->conn != null)
$this->conn->close();
}

public function getUserDetails($email)
{
$returnValue = array();
$sql = "select * from users where login='" . $email . "'";

$result = $this->conn->query($sql);
if ($result != null && (mysqli_num_rows($result) >= 1)) {
$row = $result->fetch_array(MYSQLI_ASSOC);
if (!empty($row)) {
$returnValue = $row;
}
}
return $returnValue;
}

public function getUserDetailsWithPassword($email, $userPassword)
{
$returnValue = array();
$sql = "select userUID,login from users where login='" . $email . "' and password='" .$userPassword . "'";
$result = $this->conn->query($sql);
if ($result != null && (mysqli_num_rows($result) >= 1)) {
$row = $result->fetch_array(MYSQLI_ASSOC);
if (!empty($row)) {
$returnValue = $row;
}
}
return $returnValue;
}

public function registerUser($email, $password, $userUID)
{
$sql = "insert into users set login=?, password=?, userUID=?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("sss", $email, $password, $userUID);
$returnValue = $statement->execute();

return $returnValue;
}

public function getAllCards()
{
$returnValue = array();
$sql = "SELECT * FROM `main_cards`";

$result = $this->conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	
    	$id = $row["id"];
    	$word = $row["word"];
    	$transcription = $row["transcription"];
    	$correct_answer = $row["correct_answer"];
        $incorrect_answer_1 = $row["incorrect_answer_1"];
        $incorrect_answer_2 = $row["incorrect_answer_2"];
    	$tempArr = array($id, $word, $transcription, $correct_answer, $incorrect_answer_1, $incorrect_answer_2);
    	array_push($returnValue, $tempArr);
    }

return $returnValue;
}
}

public function getCardsByID($id)
{
$returnValue = array();
$sql = "SELECT * FROM `main_cards` WHERE `id` = $id";

$result = $this->conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        $id = $row["id"];
        $word = $row["word"];
        $transcription = $row["transcription"];
        $correct_answer = $row["correct_answer"];
        $incorrect_answer_1 = $row["incorrect_answer_1"];
        $incorrect_answer_2 = $row["incorrect_answer_2"];
        $tempArr = array($id, $word, $transcription, $correct_answer, $incorrect_answer_1, $incorrect_answer_2);
        array_push($returnValue, $tempArr);
    }

return $returnValue;
}
}

public function addUser($userUID, $email, $login)
{
$sql = "insert into users set user_id=?, email=?, login=?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("sss", $userUID, $email, $login);
$returnValue = $statement->execute();

return $returnValue;
}


public function getAllPerks()
{
$returnValue = array();
$sql = "SELECT * FROM `perks` P JOIN users U on P.user_id = U.user_id WHERE P.status = 1";

$result = $this->conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        $id = $row["id"];
        $login = $row["login"];
        $word = $row["word"];
        $transcription = $row["transcription"];
        $correct_answer = $row["correct_answer"];
        $incorrect_answer_1 = $row["incorrect_answer_1"];
        $incorrect_answer_2 = $row["incorrect_answer_2"];
        $tempArr = array($id, $word, $transcription, $correct_answer, $incorrect_answer_1, $incorrect_answer_2, $login);
        array_push($returnValue, $tempArr);
    }

return $returnValue;
}
}


public function getPerksByID($id)
{
$returnValue = array();
$sql = "SELECT * FROM `perks` P JOIN users U on P.user_id = U.user_id WHERE P.id = $id";

$result = $this->conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        $id = $row["id"];
        $login = $row["login"];
        $word = $row["word"];
        $transcription = $row["transcription"];
        $correct_answer = $row["correct_answer"];
        $incorrect_answer_1 = $row["incorrect_answer_1"];
        $incorrect_answer_2 = $row["incorrect_answer_2"];
        $status = $row["status"];
        $tempArr = array($id, $word, $transcription, $correct_answer, $incorrect_answer_1, $incorrect_answer_2, $login, $status);
        array_push($returnValue, $tempArr);
    }
return $returnValue;
}
}


public function addNewPerk($uid,$word,$transcription,$correctA,$incorrectA1,$incorrectA2)
{
$sql = "insert into perks set user_id=?, word=?,transcription=?,correct_answer=?,incorrect_answer_1=?,incorrect_answer_2=?,status=?";
$statement = $this->conn->prepare($sql);
$status = "0";
if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("sssssss", $uid,$word,$transcription,$correctA,$incorrectA1,$incorrectA2, $status);
$returnValue = $statement->execute();

return $returnValue;
}


public function getPerksByUserId($uid)
{
$returnValue = array();
$sql = "SELECT * FROM `perks` WHERE `user_id` = '$uid'";

$result = $this->conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        $id = $row["id"];
        $word = $row["word"];
        $transcription = $row["transcription"];
        $correct_answer = $row["correct_answer"];
        $incorrect_answer_1 = $row["incorrect_answer_1"];
        $incorrect_answer_2 = $row["incorrect_answer_2"];
        $tempArr = array($id, $word, $transcription, $correct_answer, $incorrect_answer_1, $incorrect_answer_2);
        array_push($returnValue, $tempArr);
    }
return $returnValue;
}
}


public function addWord($word, $transcription, $correctA, $falseA1, $falseA2)
{
$sql = "insert into main_cards set word=?, transcription=?, correct_answer=?, incorrect_answer_1=?, incorrect_answer_2=?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("sssss", $word, $transcription, $correctA, $falseA1, $falseA2);
$returnValue = $statement->execute();

return $returnValue;
}

public function deleteWord($word_id)
{
$sql = "DELETE FROM `main_cards` WHERE `id` = ?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("i", $word_id);
$returnValue = $statement->execute();
return $returnValue;
}


public function updateWord($id, $word, $transcription, $correctA, $falseA1, $falseA2)
{
$sql = "UPDATE `main_cards` SET word=?, transcription=?, correct_answer=?, incorrect_answer_1=?, incorrect_answer_2=? WHERE `main_cards`.`id`=?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("sssssi", $word, $transcription, $correctA, $falseA1, $falseA2, $id);
$returnValue = $statement->execute();

return $returnValue;
}



public function addNewPerkByAdmin($word,$transcription,$correctA,$incorrectA1,$incorrectA2)
{
$sql = "insert into perks set user_id=?, word=?,transcription=?,correct_answer=?,incorrect_answer_1=?,incorrect_answer_2=?,status=?";
$statement = $this->conn->prepare($sql);
$status = "1";
$uid = "0";
if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("sssssss", $uid,$word,$transcription,$correctA,$incorrectA1,$incorrectA2, $status);
$returnValue = $statement->execute();

return $returnValue;
}

public function getAllPerksForAdmin()
{
$returnValue = array();
$sql = "SELECT * FROM `perks` P JOIN users U on P.user_id = U.user_id";

$result = $this->conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        $id = $row["id"];
        $login = $row["login"];
        $status = $row["status"];
        $word = $row["word"];
        $transcription = $row["transcription"];
        $correct_answer = $row["correct_answer"];
        $incorrect_answer_1 = $row["incorrect_answer_1"];
        $incorrect_answer_2 = $row["incorrect_answer_2"];
        $tempArr = array($id, $word, $transcription, $correct_answer, $incorrect_answer_1, $incorrect_answer_2, $login, $status);
        array_push($returnValue, $tempArr);
    }


return $returnValue;
}

}


public function updatePerk($id, $word, $transcription, $correctA, $falseA1, $falseA2, $status)
{
$sql = "UPDATE `perks` SET word=?, transcription=?, correct_answer=?, incorrect_answer_1=?, incorrect_answer_2=?, status=? WHERE `perks`.`id`=?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("ssssssi", $word, $transcription, $correctA, $falseA1, $falseA2, $status, $id);
$returnValue = $statement->execute();

return $returnValue;
}

public function deletePerk($word_id)
{
$sql = "DELETE FROM `perks` WHERE `id` = ?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("i", $word_id);
$returnValue = $statement->execute();
return $returnValue;
}

}
?>