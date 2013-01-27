<?php
//    include_once 'init.php';
//    include_once 'manage.php';
//    include_once 'view.php';

ini_set('display_errors', 1);

$mc = new Memcache();
$mc->addServer('localhost');

if(isset($_GET['f']) && $_GET['f'] == 1) {
    $mc->flush();
//    die('flush');
}
        
if(isset($_GET['r']))
{
    $step = 'get_cache';
    
    $dbg = array(
        'get' => 0,
        'try_to_lock' => 0,
        'sleep' => 0,
    );
    
    $key = 'test';
    $key_ttl = 9;
    $lock_key = 'lock_'.$key;
    $lock_key_ttl = 5;
    $locked = false;
    
    $now_time = time();
    $now_mtime = microtime(true);
    
    $on_wait = false;
    
    while($step != 'return') {
        switch($step) {
            case 'get_cache':
                $dbg['get']++;
                $data = $mc->get($key);
                if(false !== $data && $data['timeout'] > $now_time) {
                    $dbg['from_cache'] = 1;
                    $step = 'return';
                } else {
                    $step = 'try_lock';
                }
                break;
            case 'get_old':
                $dbg['old'] = 1;
                $dbg['old_time_get'] = time();
                $step = 'return';
                break;
            case 'get_real':
                try {
                    if($locked) {
                        $sum=0;
                        for($i=0; $i<5000000; $i++) {
                            $sum += $i;
                        }
                        $real = $sum+microtime(true);
                        $dbg['IN_BLACK_BOX'] = 1;
                        $step = 'set_cache';
                    } else {
                        $step = 'try_lock';
                    }
                } catch(Exception $e) {
                    echo 'can not get real data<pre>';
                    var_dump($e->getMessage());
                    echo '</pre>';
                    die();
                }
                break;
            case 'try_lock':
                $dbg['try_to_lock']++;
                try {
                    if(($locked = $mc->add($lock_key, 1, 0, $lock_key_ttl)) !== false) {
                        if($on_wait) {
                            $step = 'get_cache';
                            $on_wait = false;
                            $mc->delete($lock_key);
                        } else {
                            $step = 'get_real';
                        }
                    } else {
                        $on_wait = true;
                        if($data !== false) {
                            $step = 'get_old';
                        } else {
                            if(microtime(true) - $now_mtime < (float)5) {
                                $dbg['sleep']++;
                                usleep(10000);
                            } else {
                                throw new Exception('too long');
                            }
                        }
                    }
                } catch(Exception $e) {
                    if($data !== false) {
                        $step = 'get_old';
                    }
                    echo 'can not lock<pre>';
                    var_dump($e->getMessage());
                    echo '</pre>';
                    die();
                }
                break;
            case 'set_cache':
                $data = array('data' => $real, /*'locked' => false,*/ 'timeout' => time() + $key_ttl);
                // save result in memcache
                $mc->set($key, $data);
                $mc->delete($lock_key);
                $step = 'return';
                break;
        }
    }
    
    echo '<pre>';
    var_dump($data);
    var_dump($locked);
    var_dump($dbg);
    echo '</pre>';
    die();
    
    $key = 'test';
//    $key_ttl = 20;
    $lock_key = 'lock_'.$key;

    $first_time = false;
    
    $lock = false;
    $lock_ttl = 20;
    $try = 0;
    $max_try = 1000;

    $mc = new Memcache();
    $mc->addServer('localhost');
//$mc->flush();die;
    // get old result
    $res = $mc->get($key);
    //if no key at all ( first time or very old )
    if($res === false || (microtime(true) - $res['tags']['tag1']) > 25) {
        echo '<pre>';
        var_dump($res);
        echo '</pre>';
        while($lock === false && $try < $max_try) {

            // add return false if key already exist
            $lock = $mc->add($lock_key, 1, 0, $lock_ttl);

            $try++;
            // wait
            if(!$lock) {
                usleep(100*($try%($max_try/10)));
            }
        }
    }
    
    if($lock) {
        $sum=0;
        for($i=0; $i<5000000; $i++) {
            $sum += $i;
        }
        $res = array('data' => $sum+microtime(true), 'tags' => array('tag1' => microtime(true)));
        // save result in memcache
        $mc->set($key, $res);

        echo '<pre>';
        var_dump('IN BLACK BOX');
        echo '</pre>';

        // delete lock
        $mc->delete($lock_key);
    }

    echo '$res<pre>';
    var_dump($res['data']);
    echo '</pre>';
    echo '$try<pre>';
    var_dump($try);
    echo '</pre>';
}
else
{

?>
<html>
    <head>
        
    </head>
    <body>
        <iframe src="./?r=1" width="260" height="260"></iframe>
        <iframe src="./?r=2" width="260" height="260"></iframe>
        <iframe src="./?r=3" width="260" height="260"></iframe>
        <iframe src="./?r=4" width="260" height="260"></iframe>
        <iframe src="./?r=5" width="260" height="260"></iframe>
        <iframe src="./?r=6" width="260" height="260"></iframe>
        <iframe src="./?r=7" width="260" height="260"></iframe>
        <iframe src="./?r=8" width="260" height="260"></iframe>
        <iframe src="./?r=9" width="260" height="260"></iframe>
        <iframe src="./?r=10" width="260" height="260"></iframe>
        <iframe src="./?r=11" width="260" height="260"></iframe>
        <iframe src="./?r=12" width="260" height="260"></iframe>
        <iframe src="./?r=13" width="260" height="260"></iframe>
        <iframe src="./?r=14" width="260" height="260"></iframe>
        <iframe src="./?r=15" width="260" height="260"></iframe>
        <iframe src="./?r=16" width="260" height="260"></iframe>
        <iframe src="./?r=17" width="260" height="260"></iframe>
        <iframe src="./?r=18" width="260" height="260"></iframe>
        <iframe src="./?r=19" width="260" height="260"></iframe>
        <iframe src="./?r=20" width="260" height="260"></iframe>
        <iframe src="./?r=21" width="260" height="260"></iframe>
    </body>
</html>

<?php 
}
?>