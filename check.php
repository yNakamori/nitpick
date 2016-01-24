<?php
        session_start();
        require('dbconnect.php');

        if(!isset($_SESSION['join'])){
            header('Location: index.php');
            exit();
        }

        if(!empty($_POST)){//登録処理
            $sql=sprintf('INSERT INTO members SET name="%s",userID="%s",password="%s",created="%s"',
                        mysqli_real_escape_string($db,$_SESSION['join']['name']),//ニックネームを無害化
                        mysqli_real_escape_string($db,$_SESSION['join']['userID']),//ユーザIDを無害化
                        mysqli_real_escape_string($db,sha1($_SESSION['join']['password'])),//パスワードを暗号化
                        date('Y-m-d H:i:s')
                        );
            mysqli_query($db,$sql) or die(mysqli_error($db));
            unset($_SESSION['join']);//セッションから入力情報を削除
            header('Location:login.php');
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
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body class="landing">
        <!-- Header -->
        <header id="header">
            <h1><a href="index.php">NitPick</a></h1>
            <nav id="nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <!-- <li><a href="php/fileup.php">FileUP</a></li> -->
                    <!-- <li><a href="filedow.html">FileDOW</a></li> -->
                </ul>
            </nav>
        </header>
        <!-- Banner -->
        <section id="banner">
            <h2>登録内容確認</h2>
            <form action="" method="post">
                <input type="hidden" name="action" value="submit">
                <dl>
                    <!-- ユーザネーム -->
                    <dt>ユーザネーム</dt>
                        <?php echo htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES,'UTF-8'); ?>
                    <!-- ユーザID -->
                    <dt>ユーザID</dt>
                        <?php echo htmlspecialchars($_SESSION['join']['userID'],ENT_QUOTES,'UTF-8'); ?>
                    <!-- パスワード -->
                    <dt>パスワード</dt>
                        【*******】
                </dl>
                <div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> |
                    <input type="submit" value="登録する">
                </div>
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
