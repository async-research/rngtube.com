<?php
class DatabaseAdaptor
{
    private $DB;
    public function __construct()
    {
        $db = 'mysql:dbname=RNGTube; charset=utf8; host=127.0.0.1';
		$auth = json_decode(file_get_contents("dbAuth.json"), true);
        $user = $auth['user'];
        $password = $auth['password'];

        try {
            $this->DB = new PDO($db, $user, $password);
            $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo ('Error establishing Connection');
            exit();
        }
    }

    public function getVideoCategories()
    {
        $stmt = $this->DB->prepare("SELECT DISTINCT category FROM videos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getVideos($filter, $limit)
    {
        if ($filter === 'Mix') {
            $stmt = $this->DB->prepare("SELECT * FROM videos ORDER BY RAND() LIMIT ".$limit.";");
        } else {
          $stmt = $this->DB->prepare("SELECT * FROM videos WHERE category = '" . $filter . "' ORDER BY RAND() LIMIT ".$limit.";");

        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 
?>