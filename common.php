<?php
/**
 * curl 模拟http请求
 */
function curl_get($url, $data = '', $timeout = 5){
    if ($url == ''){
        return false;
    }
    $method = empty($data)?'GET':'POST';

    // 创建一个新的curl资源
    $ch = curl_init();
    // 设置有关curl的选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if ($method == 'POST'){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_TIMEOUT,(int)$timeout);
    // 执行这个curl并抓取他的资源
    $output = curl_exec($ch);
    if ($output === false) {
        echo 'CURL ERROR-->'.curl_error($ch);
    }
    // 关闭curl的资源,并释放系统资源
    curl_close($ch);

    return $output;
}

/**
 * 生成指定位数的随机无意义字符串
 */
function getRandChar($length){
    $str = '';
    $strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $max = strlen($strPol) - 1;
    for ($i = 0; $i < $length; $i++){
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}

/**
 * 生成指定位数的随机数字
 */
function generate_code($length = 5) {
    $min = pow(10 , ($length - 1));
    $max = pow(10, $length) - 1;
    return rand($min, $max);
}

/**
 * pdo连接数据库
 */
function pdoLinkDatabase($dbms, $host, $dbName, $user, $pass, $sql){
    $dbms='mysql';     //数据库类型
    $host='localhost'; //数据库主机名
    $dbName='pay';    //使用的数据库
    $user='root';      //数据库连接用户名
    $pass='root';          //对应的密码
    $dsn="$dbms:host=$host;dbname=$dbName";

    try {
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        echo "连接成功<br/>";
        // 你还可以进行一次搜索操作
        echo '<pre>';
        foreach ($dbh->query('SELECT * from ep_users') as $row) {
            print_r($row); //你可以用 echo($GLOBAL); 来看到这些值
        }
        $dbh = null;
    } catch (PDOException $e) {
        die ("Error!: " . $e->getMessage() . "<br/>");
    }

    $res = $dbh->query($sql);
    return $res;
}
