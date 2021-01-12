<?php
header("Content-Type:text/html; charset=utf-8");
define('DB_Server', 'localhost');       //資料庫主機
define('DB_User', 'root');              //資料庫使用者
define('DB_Password', '');              //資料庫使用者密碼
define('DB_Database', 'final');       //資料庫名稱
//資料庫連接
$link = mysqli_connect(DB_Server, DB_User, DB_Password, DB_Database);
/* 檢查是否連接失敗 */
if (!$link) {
    die("連接失敗" . mysqli_connect_error()); //輸出資料庫連接錯誤
} else {
    // echo "Success!!!<br>";  //輸出資料庫連接成功
}
mysqli_set_charset($link, "utf8");  //設定查詢結果為utf8

$sql_query = "SELECT bill_total, bill_date, bill_uuid FROM bill";
$result = mysqli_query($link, $sql_query);    //執行sql語法
// var_dump($result);

if ($result) {  // 檢查是否有正確執行 sql 查詢 
    if (mysqli_num_rows($result) > 0) {     // 檢查是否有查詢到至少一筆資料
        /* 取出所有的查詢結果，且將其存成「索引型」陣列 */
        $queryData = mysqli_fetch_all($result, MYSQLI_NUM);
        /* 釋放查詢結果所佔用的記憶體空間 */
        mysqli_free_result($result);
        /* 「json_encode()」：此函數會將參數的值轉換成 json 格式回傳  */
        /* 其中的第二個參數是讓 php 判斷是否有「數字」型態資料 */
        /* 若有，則在輸出時，將其轉成「數字」資料 */
        echo json_encode($queryData, JSON_NUMERIC_CHECK);
        /* 若要讓 json_encode() 依指定格式回傳，可以設定底下各種參數
          /* JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS, JSON_NUMERIC_CHECK
         * JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES, JSON_FORCE_OBJECT
         */
    } else {
        echo "沒有資料！";
    }
} else {
    echo "查詢錯誤: " . mysqli_error($db->link); //輸出SQL語法錯誤
}


mysqli_close($link); //關閉資料庫連接
?>