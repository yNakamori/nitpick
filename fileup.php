<?php
$uploaddir = '../upload/';
$uploadfile = $uploaddir.basename(@$_FILES['userfile']['name']);

// echo '<pre>';
if (move_uploaded_file(@$_FILES['userfile']['tmp_name'], $uploadfile)) {
    // echo "File is valid, and was successfully uploaded.\n";
} else {
    // echo "Possible file upload attack!\n";
}

// echo 'Here is some more debugging info:';
// print_r($_FILES);

// print '</pre>';
?>

<?php
        require('dbconnect.php');
        session_start();
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    //idにセッションが記録済み・最後の行動から1時間以内かチェック
            //ログイン中
            $_SESSION['time'] = time();// $_SESSION['time']に現時刻を上書き
            $sql=sprintf('SELECT * FROM members WHERE id=%d', //DBから会員情報を検索
                        mysqli_real_escape_string($db, $_SESSION['id'])
                        );
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
        <title>Nit Pick ~Login~</title>
        <link rel="shortcut icon" href="../images/nitpick.ico" type="image/vnd.microsoft.icon">
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
            <link rel="stylesheet" href="css/style-xlarge.css" />
        </noscript>
        <link rel="stylesheet" href="css/fileup.css.css">
    </head>

    <body class="landing">
        <!-- Header -->
        <header id="header">
            <h1><a href="index.php">NitPick</a></h1>
            <nav id="nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <!-- <li><a href="new.php" class="button special">新規</a></li> -->
                    <!-- <li><a href="php/fileup.php">FileUP</a></li> -->
                    <!-- <li><a href="filedow.html">FileDOW</a></li> -->
                    <li><a class="button special"><?php echo htmlspecialchars($member['name']); ?></a></li>
                </ul>
            </nav>
        </header>
        <!-- Banner -->
        <section id="banner">

          <h2>Hello.Please FileUp.</h2>
          <form enctype="multipart/form-data" action="" method="POST">
              <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
              <input type="file" id="filelabel" name="userfile" /><br>
              <input type="file" id="filelabel" name="userfile" /><br>
              <input type="file" id="filelabel" name="userfile" /><br>
              <input type="submit" value="ファイルを送信" />
          </form>

<!--
                <ul class="actions">
                    <li> <a class="button big">Login</a> </li>
                </ul>
-->
              </form>
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
