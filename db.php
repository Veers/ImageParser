<?
class db
{
    public static $config = array(
        'user' => 'punk',
        'pass' => '11ctynz,hz',
        'host' => 'localhost',
        'base' => 'tag',
    );

    public $connector;

    function __construct()
    {
        $this->connector = new PDO('mysql:host=localhost;dbname=tag', static::$config['user'], static::$config['pass']);;
        $this->connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connector->exec("set names utf8");
    }

    public function putLinksToBase($links)
    {
        $site_address = $links[0];
        $data = $links[1];
        array_multisort($data);

        $site_address = substr($site_address, 7, strlen($site_address));
        try {
            $statement =$this->connector->prepare("INSERT INTO a_sites (src) VALUES (?)");
            $statement->execute(array($site_address));
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }

        $last_insert_id = $this->connector->lastInsertId('src');

        try {
            $statement = $this->connector->prepare("INSERT INTO a_images (image_link,image_size,site_id) VALUES (:link,:sizeimg,:s_id)");
            foreach ($data as &$value){
                foreach ($value as $key=>$val){
                    $number = (int) $val;
                    $statement->execute(array('link' => $key, 'sizeimg' => $number, 's_id' => $last_insert_id));
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