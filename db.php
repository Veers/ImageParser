<?
class db
{
    public static $config = array(
        'user' => '',
        'pass' => '',
        'host' => 'localhost',
        'base' => 'tag',
    );

    public $connector;

    function __construct($login, $pass)
    {
        static::$config['user'] = $login;
        static::$config['pass'] = $pass;
        $this->connector = new PDO('mysql:host=localhost', static::$config['user'], static::$config['pass']);
        $isHaveTables = $this->initDatabaseScheme();
        if ($isHaveTables == 1){
            $this->connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connector->exec("set names utf8");
            $this->connector->exec('USE '.static::$config['base']);
        }

    }

    function initDatabaseScheme()
    {
        $return_value = 0;
        $statement = $this->connector->query("SELECT schema_name FROM information_schema.schemata");
        $statement->setFetchMode(PDO::FETCH_NUM);
        while($row = $statement->fetch())
        {
            // check for database in schema
            $s = strcasecmp($row['0'], static::$config['base']);
            if ($s == 0) {
                $return_value = 1;
            } else {
                try {
                    // else create database and tables
                    $createDatabaseAndTablesStatement = $this->connector->prepare
                    (
                        "CREATE DATABASE :dbName;
                        Create table :dbName.'a_sites'('id' int NOT NULL,  'src' varchar(150), primary key ('id'));
                        Create table :dbName.'a_images'('id' int NOT NULL,  'src' varchar(50), 'image_size' int, 'site_id' int, primary key ('id'))"
                    );
                    $createDatabaseAndTablesStatement->execute(array('dbName' => static::$config['base']));
                } catch (PDOException $e) {
                    die("DB ERROR: ".$e->getMessage());
                }
                $return_value = 1;
            }
        }
        return $return_value;
    }

    public function putLinksToBase($links)
    {
        // links - array[address, array[data]]
        $site_address = $links[0];
        $data = $links[1];
        array_multisort($data);
        $site_address = substr($site_address, 7, strlen($site_address));
        try {
            // insert url into db
            $statement =$this->connector->prepare("INSERT INTO a_sites (src) VALUES (?)");
            $statement->execute(array($site_address));
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        $last_insert_id = $this->connector->lastInsertId('src');
        try {
            // insert images into db
            $statement = $this->connector->prepare("INSERT INTO a_images (image_link,image_size,site_id) VALUES (:link,:sizeimg,:s_id)");
            foreach ($data as &$value){
                foreach ($value as $link_image=>$sizeoofimage){
                    $intsizeofimage = (int) $sizeoofimage;
                    $statement->execute(array('link' => $link_image, 'sizeimg' => $intsizeofimage, 's_id' => $last_insert_id));
                }
            }
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }

    }

    public function test()
    {
        return true;
    }
}