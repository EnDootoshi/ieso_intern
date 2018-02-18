<html>
<head lang = "ja">
<meta http-equiv="Content-Type" charset="utf-8" />
<title>Dancers' com</title>
</head>
<body>
<!-- テーブルでタイトル表示 -->
<table border="2">
  <tr>
    <td>DANCERS'com</td>
  </tr>
</table>

<!-- 編集したい番号が入力されたら -->
<?php
if  (isset($_POST["editNo"])){
  $editNo = $_POST["editNo"];
  $ediCon = file('misson_2.txt');
  for ($j = 0; $j < count($ediCon); $j++) {
    $editData = explode("<>",$ediCon[$j]);
    if ($editData[0] == $editNo) {
?>
  <!-- 編集フォーム -->
  <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
    <input type="hidden" name="id" value="<?= $editData[0] ?>">
    名前：<br />
    <input type="text" name="rename" size="20" value="<?= $editData[2] ?>" /><br />
    コメント: <br />
    <input type="text" name="recomment" size="50" value="<?= $editData[3] ?>" /><br />
    パスワードを入力してください<br/>
    <input type="text" name="editpass" size="10" value=""/><br/>
    <input type="submit" value="編集する" />
  </form>
<?php
    }
  }
}else{
  // 普通の入力
?><!-- 入力フォーム -->
  <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
    名前：<br />
    <input type="text" name="name" size="20" value="" /><br />
    コメント: <br />
    <input type="text" name="comment" size="50" value="" /><br />
    パスワードを入力してください<br/>
    <input type="text" name="pass" size="10" value=""/><br/>
    <input type="submit" value="入力する" />
  </form>
<?php
}
?>
<!-- 削除するフォームを作る -->
<form action="" method="POST">
  削除対象番号(半角)<br/>
 <input type="text" name="deleteNo" size="10" value=""/><br/>
 パスワードを入力してください<br/>
 <input type="text" name="delpass" size="20" value=""/><br/>
 <input type="submit" value="削除する"/><br/>
</form>

<!-- 編集フォームを作る -->
<form action="<?= $_SERVER["PHP_SELF"]; ?>" method="POST">
  編集対象番号(半角)<br/>
 <input type="text" name="editNo" size="10" value=""/><br/>
 <input type="submit" value="編集する"/><br/>
</form>




<table border="5"
  <tr>
    <td>

      <?php
      $filename = 'misson_2.txt';
// もし何も入力されなかったらはじく
// ～～～～～～～～入力～～～～～～～～～～～～～～～～～～～～～～～～～～
      if (isset($_POST["name"]) && isset($_POST["comment"]) && !isset($_POST["id"]) && isset($_POST["pass"])) {
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $pass = $_POST["pass"];
        $fp = fopen($filename, 'a');
        $files = file($filename);
        $lastLine = $files[count($files) - 1];
        $num = explode("<>", $lastLine);
        fwrite($fp, ($num[0]+1)."<>".$pass."<>". $name."<>".$comment."<>".date("Y年m月d日 H時i分s秒")."\n");
        fclose($fp);
        echo '入力しました';
      }elseif (isset($_POST["name"]) && isset($_POST["comment"]) && !isset($_POST["id"]) && !isset($_POST["pass"])) {
        echo 'パスワードを入力してください';

// ～～～～～～～～削除～～～～～～～～～～～～～～～～～～～～～～～～～～
      }elseif (isset($_POST["deleteNo"]) && isset($_POST["delpass"])) {
          $delete = $_POST["deleteNo"];
          $delpass = $_POST["delpass"];
          $delCon = file($filename);
          for ($j = 0; $j < count($delCon); $j++) {
            $delData = explode("<>",$delCon[$j]);
            if (($delData[0] == $delete) && ($delData[1] == $delpass)) {
              array_splice($delCon, $j, 1);
              file_put_contents($filename, implode($delCon));
              echo '削除しました';
            }elseif ($delData[1] != $delpass) {
              echo 'パスワードが間違っています';
            }
          }
      }elseif (isset($_POST["deleteNo"])&& !isset($_POST["delpass"])) {
          echo 'パスワードを入力してください';

// ～～～～～～～～～編集～～～～～～～～～～～～～～～～～～～～～～～～～～
      }elseif (isset($_POST["rename"]) && isset($_POST["recomment"])&& isset($_POST["id"]) && isset($_POST["editpass"])) {
          $editNo = $_POST["id"];
          $edpass = $_POST["editpass"];
          $ediCon = file($filename);
          $rename = $_POST["rename"];
          $recomment = $_POST["recomment"];
          for ($j = 0; $j < count($ediCon); $j++) {
            $editData = explode("<>",$ediCon[$j]);
            if (($editData[0] == $editNo) && ($editData[1] == $edpass)) {
              array_splice($ediCon, $j, 1);
              $ediCon[$j] = $editNo."<>".$edpass."<>". $rename."<>".$recomment."<>".date("Y年m月d日 H時i分s秒")."\n";
              file_put_contents($filename, implode($ediCon));
              echo '編集しました';
            }elseif ($editData[1] != $edpass) {
              echo 'パスワードが間違っています';
            }
          }
      }elseif (isset($_POST["rename"]) && isset($_POST["recomment"])&& isset($_POST["id"])&& !isset($_POST["editpass"])) {
        echo 'パスワードを入力してください';

      }else {
        echo '入力してください';
      }
      ?>
    </td>
  </tr>
</table>

<table border="1"
  <tr>
    <td>書き込み内容：</td>
      <td>
        <?php
        $newFile = file($filename);
        for($i = 0; $i < count($newFile) ; ++$i ) {
        // 配列を順番にばらばらにする
           $filepieces = explode("<>", $newFile[$i]);
           array_splice($filepieces, 1, 1);
           // ばらばらに分けた要素を表示
           for( $e = 0; $e < count($filepieces); ++$e ) {
             echo $filepieces[$e];
           }
           echo "<br>\n";
           echo "<br>\n";
        }
        ?>

    </td>
  </tr>

</table>

</body>
</html>
