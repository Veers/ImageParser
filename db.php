<?
class db
{
    public static $config = array(
        'user' => 'punk',
        'pass' => '11ctynz,hz',
        'host' => 'localhost',
        'base' => 'tag',
    );

    public static function putImages($src, $data)
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=tag', static::$config['user'], static::$config['pass']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("set names utf8");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $src = substr($src, 7, strlen($src));
        echo $src;

        try {
            $stmt = $db->prepare("INSERT INTO a_sites (src) VALUES (?)");
            $stmt -> execute(array($src));
        }
        catch(PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }

        $cnt = $db->lastInsertId('src');

        //$db->exec($query);

        //var_dump($data);

        try{
            $stmt = $db->prepare("INSERT INTO a_images (image_link,image_size,site_id) VALUES (:link,:sizeimg,:s_id)");
            foreach ($data as &$value)
                $stmt -> execute(array('link'=>$value[0], 'sizeimg'=>settype($value[1], 'integer'), 's_id'=>$cnt));
        } catch (PDOException $e) {
            echo 'Error : '.$e->getMessage();
            exit();
        }


        echo $src;
    }

    public static function test()
    {
        return true;
    }
}