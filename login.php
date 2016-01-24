<?php
        require('dbconnect.php');

        session_start();

        if(isset($_COOKIE['userID'])){////$_COOKIE['userID']に値が入っているかチェック
            //$_POSTに情報を代入
            $_POST['userID'] = $_COOKIE['userID'];
            $_POST['password'] = $_COOKIE['password'];
            $_POST['save'] = 'on';//$_POST['save']に値『on』を設定
        }

        if(isset($_POST['userID'],$_POST['password'])){//ログインボタンが押されたかチェック
            //ログイン処理
            if(!empty($_POST['userID']) && !empty($_POST['password'])){//['userID']・['password']が記入されているかチェック
                    $sql=sprintf('SELECT * FROM members WHERE userID="%s" AND password="%s"',//DBからユーザIDとパスワードを検索
                                mysqli_real_escape_string($db,$_POST['userID']),
                                mysqli_real_escape_string($db,sha1($_POST['password']))
                                );
                    $record=mysqli_query($db,$sql) or die(mysqli_error($db));

                    if($table=mysqli_fetch_assoc($record)){//検索してレコードがあるかチェック
                        //ログイン成功
                        $_SESSION['id']=$table['id'];
                        $_SESSION['time']=time();

                        //ログイン情報を記録
                        if($_POST['save'] == 'on'){//$_POST['save']の値が『on』かチェック
                            setcookie('userID',$_POST['userID'],time()+60*60*24*14);//ユーザID情報を2週間保存
                            setcookie('password',$_POST['password'],time()+60*60*24*14);//パスワード情報を2週間保存
                        }
                        header('Location: index.php');
                        exit();
                    }else{
                        $error['login_feiled']='failed';//DBに登録されていない、パスワードがあっていない→再入力
                    }
            }else{
                $error['login_blank']='blank';//['userID']・['password']に入力されていない→入力
            }
        }
?>

<!----------------------------------------------------------------------------------->


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
                    <li><a href="new.php" class="button special">新規</a></li>
                    <!-- <li><a href="php/fileup.php">FileUP</a></li> -->
                    <!-- <li><a href="filedow.html">FileDOW</a></li> -->
                </ul>
            </nav>
        </header>
        <!-- Banner -->
        <section id="banner">
            <h2>Hello.Please login.</h2>
            <p>ユーザIDとパスワードを入力してください。</p>
            <form action="" method="post">
                <dl>
                    <!-- ユーザID -->
                    <dt>ユーザーID</dt>
                    <dd>
                        <input type="text" name="userID" size="20" maxlength="255" value="<?php if(isset($_POST['userID']))
                        echo htmlspecialchars($_POST['userID']); ?>">
                        <?php if(isset($error['login_blank'])): ?>
                        <h4 class="error">ユーザIDとパスワードを入力して下さい。</p>
                        <?php endif; ?>
                        <?php if (isset($error['login_feiled'])): ?>
                        <p class="error">ログイン失敗。正しく入力して下さい。</p>
                        <?php endif;?>
                    </dd>
                    <!-- パスワード -->
                    <dt>パスワード</dt>
                    <dd>
                        <input type="password" name="password" size="20" maxlength="255"<?php
                        if(isset($_POST['password']))
                        echo htmlspecialchars($_POST['password']); ?>>
                    </dd>
                    <!-- 自動ログイン -->
                    <dt>ログイン情報記録</dt>
                    <dd>
                        <input name="save" type="checkbox" id="save" value="on">
                        <label for="save">次回から自動ログインする</label>
                    </dd>
                </dl>
                <div>
                 <input type="submit" value="ログイン">
                </div>

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
