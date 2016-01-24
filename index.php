<?php
require('dbconnect.php');
require_once("./sort_func.php");
session_start();
$order = isset($_POST["sort_type"]) ? $_POST["sort_type"] : "";
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    //idにセッションが記録済み・最後の行動から1時間以内かチェック
    //ログイン中
    $_SESSION['time'] = time();// $_SESSION['time']に現時刻を上書き
    $sql=sprintf('SELECT * FROM members WHERE id=%d', //DBから会員情報を検索
                mysqli_real_escape_string($db, $_SESSION['id']));
    $record=mysqli_query($db, $sql) or die(mysqli_error($db));
    $member=mysqli_fetch_assoc($record);
} else {
    //ログインしていない
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>NitPick ~For PG~</title>
  <link rel="shortcut icon" href="images/nitpick.ico" type="image/vnd.microsoft.icon">
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
  <script src="js/jquery.min.js"></script>
  <script src="js/skel.min.js"></script>
  <script src="js/skel-layers.min.js"></script>
  <script src="js/init.js"></script>
  <noscript>
    <link rel="stylesheet" href="css/skel.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/style-xlarge.css" /> </noscript>
</head>

<body class="landing">
  <!-- Header -->
  <header id="header">
    <h1><a href="index.html">NitPick</a></h1>
    <nav id="nav">
      <ul>
        <li><a class="button special"><?php echo htmlspecialchars($member['name']); ?></a></li>
        <li><a href="logout.php" class="button special">Logout</a></li>
      </ul>
    </nav>
  </header>
  <!-- Banner -->
  <section id="banner">
    <h2>Hi. This is NitPick.</h2>
    <p>ファイルをアップロードしNitPickを始めよう</p>
    <ul class="actions">
      <li> <a href="./fileup.php" class="button big">FIleUP</a> </li>
    </ul>
    <form class="" action="./php/filedelete.php" method="post">
      <!-- <input type="submit" name="name" value="全消去"> -->
    </form>
  </section>
  <!-- One -->
  <section id="one" class="wrapper style1 special">
    <div class="container">
      <header class="major">
        <h2>あなたがアップロードしたファイル</h2>
        <form method="post" action="">
            <SELECT name="sort_type">
                <OPTION value="" <?php if ($order === "") echo "selected"; ?>>ソート</OPTION>
                <OPTION value="asc" <?php if ($order === "asc") echo "selected"; ?>>昇順</OPTION>
                <OPTION value="desc"<?php if ($order === "desc") echo "selected"; ?>>降順</OPTION>
            </SELECT>
            <input type="submit" value="送信">
        </form>
      </header>
      <div class="row 150%">
        <?php echo dispFileList($order); ?>
      </div>
    </div>
  </section>
  <!-- Footer -->
  <footer id="footer">
    <div class="container">
      <section class="links">
        <div class="row"> </div>
      </section>
      <div class="row">
        <div class="8u 12u$(medium)">
          <ul class="copyright">
            <li>NitPick. All rights reserved.</li>
          </ul>
        </div>
        <div class="4u$ 12u$(medium)">
          <ul class="icons">
            <li>
              <a class="icon rounded fa-facebook" href="">
                <span class="label">Facebook</span>
              </a>
            </li>
            <li>
              <a class="icon rounded fa-twitter" href="">
                <span class="label">Twitter</span>
              </a>
            </li>
            <li>
              <a class="icon rounded fa-google-plus" href="">
                <span class="label">Google+</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>
