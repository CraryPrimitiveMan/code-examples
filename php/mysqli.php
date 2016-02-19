<?php
$host = 'localhost';
$database = 'test';
$username = 'root';
$password = 'root';
$selectName = 'harry';//要查找的用户名，一般是用户输入的信息
$insertName = 'testname';

// 创建对象并打开连接，最后一个参数是选择的数据库名称
$mysqli = new mysqli($host, $username, $password, $database);

// 编码转化为 utf8
if (!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
} else {
    printf("Current character set: %s\n", $mysqli->character_set_name());
}

if (mysqli_connect_errno()) {
    // 诊断连接错误
    die("could not connect to the database.\n" . mysqli_connect_error());
}

$selectedDb = $mysqli->select_db($database);//选择数据库
if (!$selectedDb) {
    die("could not to the database\n" . mysql_error());
}

if ($stmt = $mysqli->prepare("select * from user where name = ?")) {
    /* bind parameters for markers */
    $stmt->bind_param("s", $selectName);
    /* execute query */
    $stmt->execute();
    /* bind result variables */
    $stmt->bind_result($name, $age);

    /* fetch values */
    while ($stmt->fetch()) {
        echo "Name: $name Age: $age \n";
    }
    /* close statement */
    $stmt->close();
}

//添加记录
if ($insertStmt = $mysqli->prepare("insert into user(name, age) values(?, 18)")) {
    /* bind parameters for markers */
    $insertStmt->bind_param("s", $insertName);
    /* execute query */
    $insertStmt->execute();
    echo $insertStmt->affected_rows . "\n";
    /* close statement */
    $insertStmt->close();
}

//更新记录
if ($updateStmt = $mysqli->prepare("update user set age = 19 where name=?")) {
    /* bind parameters for markers */
    $updateStmt->bind_param("s", $insertName);
    /* execute query */
    $updateStmt->execute();
    echo $updateStmt->affected_rows . "\n";
    /* close statement */
    $updateStmt->close();
}

//删除记录
$result = $mysqli->query("delete from user where age = 19");
echo $result . "\n";

$mysqli->close();//关闭连接
