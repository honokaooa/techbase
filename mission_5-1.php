<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
    <?php 

    // DB接続設定 
  $dsn='ユーザー名';
  $user='データベース名';
  $password='パスワード';
  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  
       
    // データベース内にテーブルの作成
    $sql = "CREATE TABLE IF NOT EXISTS mission5no1"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);

    // 編集IDが投稿されたとき、フォームに元の名前とコメントを表示する
    if(!empty($_POST["editid"])){
    $editid = $_POST["editid"];
    $sql = 'SELECT * FROM mission5no1 where id='.$editid;
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        $name=$row["name"];
        $comment=$row["comment"];
    }
 }
        ?>
    
<form action="" method="post">
            <input type="text" name="name" placeholder="名前" value= "<?php if(!empty($name)) {echo $name;} ?>" >
            <input type="text" name="comment" placeholder="コメント" value= "<?php if(!empty($comment)) {echo $comment;} ?>" >
            

            <input type="hidden" name="rewrite" value="<?php if(!empty($editid)) {echo $editid;} ?>">
            <input type="submit" name="submit">
        </form>

<form action="" method="post">
        <input type="number" name="deleteid" placeholder="削除対象ID">
        <input type="submit" name="deletesubmit" >

        <input type="number" name="editid" placeholder="編集対象ID">
        <input type="submit" value="編集">
    
</form>

        
 <?php
    
     //新しいデータの入力
     if( !empty($_POST["name"]) && !empty($_POST["comment"])&& empty($_POST["rewrite"])) {
     $sql = $pdo -> prepare("INSERT INTO mission5no1 (name, comment) VALUES (:name, :comment)");
     $sql -> bindParam(':name', $name, PDO::PARAM_STR); 
     $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
     $name = $_POST['name'];
     $comment = $_POST['comment'];
     $sql -> execute();
     }

     //送信されたデータの削除
     elseif( !empty($_POST["deleteid"]) ){
     $id = $_POST['deleteid'];
     $sql = 'delete from mission5no1 where id='.$id;
     $stmt = $pdo->prepare($sql);
     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
     $stmt->execute();
     }

     // 入力されているデータベースの編集
    elseif(!empty($_POST["rewrite"]) && !empty($_POST["name"]) && !empty($_POST["comment"])){
        $editid = $_POST["rewrite"];;
        $id = $editid;
        $name = $_POST['name'];
        $comment = $_POST['comment']; 
        $sql = 'UPDATE mission5no1 SET name=:name,comment=:comment WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        }  


        // 入力したデータレコードを表示し、抽出する
        $sql = 'SELECT * FROM mission5no1';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].'<br>';
        echo "<hr>";
        }
?>

        </body>
    

    </html>