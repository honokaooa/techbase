 <!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
         <?php 
            
            $filename = "mission_3-05.txt";
         
            if(!empty($_POST["editnum"]) && $_POST["password"]=="password"){
                
                $editnum = $_POST["editnum"];
                $password = $_POST["password"];
                
                if(file_exists($filename)){
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                
                    foreach($lines as $line){
                       
                       $word = explode("<>",$line);
                    
                       if($word[0] == $editnum){
                          
                          $editname = $word[1];
                          $editcomment = $word[2];
                          }
                    }  } }
        ?>
        
        
        
      
        【投稿フォーム】<br>
        <form action="" method="post">
            <input type="text" name="str" placeholder="名前" value= "<?php if(!empty($editname)) {echo $editname;} ?>" >
            <input type="text" name="comment" placeholder="コメント" value= "<?php if(!empty($editcomment)) {echo $editcomment;} ?>" >
            <input type="password" name="password" placeholder="パスワード">　

            <input type="hidden" name="rewrite" value="<?php if(!empty($editnum)) {echo $editnum;} ?>">
            <input type="submit" name="submit">
        </form>
        
        【削除フォーム】<br>
        <form action="" method="post">
            <input type="number" name="deletenum" placeholder="削除対象番号">
            <input type="password" name="password" placeholder="パスワード">　
            <input type="submit" name="delete" value="削除">
        </form>
        
        【編集フォーム】<br>
        <form action="" method="post">
            <input type="number" name="editnum" placeholder="編集対象番号">
            <input type="password" name="password" placeholder="パスワード">
            <input type="submit" name="edit" value="編集">
            　
        </form>
        
        
        <?php
         
            $filename = "mission_3-05.txt";
            
            if( !empty($_POST["str"]) && !empty($_POST["comment"]) && empty($_POST["rewrite"]) && $_POST["password"]=="password"){
                $str = $_POST["str"];
                $comment = $_POST["comment"];
                $date = date ("Y/m/d H:i:s");
                $password = $_POST["password"];

                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $lastline = end($lines);
                if(!empty($lastline)){
                    $word = explode("<>",$lastline);
                    
                    $number = $word[0] + 1;
                }else{
                    $number = 1;
                }

                $sentence = $number . "<>" . $str . "<>" . $comment . "<>" .$date ;
                $fp = fopen($filename, "a");
                fwrite($fp, $sentence.PHP_EOL);
                fclose($fp);



            }elseif( !empty($_POST["deletenum"]) && $_POST["password"]=="password"){
               
                $deletenum = $_POST["deletenum"];
                 $password = $_POST["password"];
                if(file_exists($filename)){
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    $fp = fopen($filename, "w");
                    
            
                    foreach($lines as $line){
                        
                        $word = explode("<>",$line);
                        

                        if($word[0] != $deletenum){
                           
                            fwrite($fp, $line.PHP_EOL);
                        }
                    }
                    
                    fclose($fp);
                }
            
        
        
        
            }elseif( !empty($_POST["rewrite"]) && !empty($_POST["str"]) && !empty($_POST["comment"]) && $_POST["password"]=="password"){
            
                $rewritename = $_POST["str"];
                $rewritecomment = $_POST["comment"];
                $rewrite = $_POST["rewrite"];
                 $password = $_POST["password"];
                
                if(file_exists($filename)){
                    
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    $fp = fopen($filename, "w");
                    
                    foreach($lines as $line){
                        
                        $word = explode("<>",$line);
                        
                    
                        if($word[0] == $rewrite){
                            
                            $word[1] = $rewritename;
                            $word[2] = $rewritecomment;
                            $word[3] = date ("Y/m/d H:i:s");
                            
                     
                            fwrite($fp, $word[0]. "<>" .$word[1]. "<>" .$word[2]. "<>" .$word[3].PHP_EOL);
                        }else{

                            fwrite($fp, $line.PHP_EOL);    
                        }
                    }
                    
                    fclose($fp);
                } }

            if( file_exists($filename) ){
        
                    
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $word = explode("<>",$line);
                        echo $word[0]. "<>" . $word[1] . "<>" . $word[2] . "<>" . $word[3], "<br>";}}
                    
       
        ?>
        
        
    </body>
    

</html>
