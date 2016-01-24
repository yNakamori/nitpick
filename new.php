<?php
        require('dbconnect.php');

        session_start();


        if(isset($_POST['name'],$_POST['userID'],$_POST['password'])){//$_POSTの各配列の中身が空でないかをチェック
            //エラー項目の確認
            if($_POST['name']==''){//['name']が空白の場合、$error['name']生成、'blanl'を入れる→未入力
                $error['name']='blank';
            }
            if($_POST['userID']==''){//['userID']が空白の場合、$error['userID']生成、'blanl'を入れる→未入力
                $error['userID']='blank';
            }
            if(strlen($_POST['password']) < 4){//『strlen』文字数チェック、4文字未満ならば、$error['password']を生成、'length'を入れる→文字数不足
                $error['password']='length';
            }
            if($_POST['password']==''){//['password']空白の場合、$error['userID']生成、'blanl'を入れる→未入力
                $error['password']='blank';
            }


            //iconファイル
            // $fileName=$_FILES['image']['name'];//ファイル名・一時的にupされたファイル名代入→$_FILES['image']['name']で$fileNameに取り出す
            // if(isset($fileName)){//$fileNameが空でないかチェック
            //     $ext=substr($fileName, -3);//substrファンクションで拡張子を取り出す→$ext(変数)に代入
            //     if($ext != 'jpg' && $ext != 'gif' && $ext != 'png'){//jpg,gif,png以外の拡張子だった場合、$error変数に'type'を代入→拡張子エラー
            //         $error['image'] = 'type';
            //     }
            // }

            //重複チェック
            if(isset($_POST['userID'])){//['userID']が空でないかチェック
                $sql=sprintf('SELECT COUNT(*) AS cnt FROM members WHERE userID="%s"',
                            mysqli_real_escape_string($db,$_POST['userID'])//mysqli_real_escape_string→無害化
                            );//DBにuserIDの件数を探しに行く
                $record=mysqli_query($db,$sql) or die(mysqli_error($db));
                $table=mysqli_fetch_assoc($record);//mysqli_query・mysqli_fetch_assoc→$table変数を取り出す
                if($table['cnt'] > 0){//『COUNT(*) AS』：件数、$table['cnt']で件数を取得→件数が1以上だったら、重複エラー
                    $error['userID_dup']='duplicate';
                }
            }

            if(empty($error)){//入力項目に異常なし

                // //画像up
                // $image = date('YmdHis') . $_FILES['image']['name'];//ファイル名を、ファイルupした時間に変更(画像重複を回避),拡張子をそのまま利用可能

                $_SESSION['join']=$_POST;
                header('Location:check.php');
                exit();
            }
        }

        //書き直し
        if(isset($_REQUEST['action'])){//書き直す場合
            if($_REQUEST['action'] == 'rewrite'){
                $_POST=$_SESSION['join'];//消えたフォーム内容を、$_SESSION['join']で書き戻す
                $error['rewrite']=true;//$error['rewrite']→画像再指定エラーを出すため
            }
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
            <h2>会員登録</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <dl>
                  <!-- ユーザネーム -->
                    <dt>ユーザネーム</dt>
                    <dd>
                        <input type="text" name="name" size="35" maxlength="255" value="<?php
                    if(isset($_POST['name']))
                    echo htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8'); ?>">
                        <?php if (isset($error['name'])): ?>
                            <p class="error">※ユーザネームを入力してください。</p>
                            <?php endif; ?>
                    </dd>
                    <!-- ユーザID -->
                    <dt>ユーザーID</dt>
                    <dd>
                        <input type="text" name="userID" size="35" maxlength="255" value="<?php
                    if(isset($_POST['userID']))
                    echo htmlspecialchars($_POST['userID'],ENT_QUOTES,'UTF-8'); ?>">
                        <?php if (isset($error['userID'])): ?>
                        <h4 class="error">※ユーザーIDを入力してください。</p>
                        <?php endif; ?>
                        <?php if (isset($error['userID_dup'])): ?>
                        <h4 class="error">※このユーザーIDは既に登録済みです。</p>
                        <?php endif; ?>
                    </dd>
                    <!--パスワード------------->
                    <dt>パスワード<span class="required">必須</span></dt>
                    <dd>
                        <input type="password" name="password" size="10" maxlength="20" value="<?php
                        if(isset($_POST['password']))
                        echo htmlspecialchars($_POST['password'],ENT_QUOTES,'UTF-8'); ?>">
                        <?php if (isset($error['password'])): ?>
                        <h4 class="error">※4文字以上のパスワードを入力して下さい。</p>
                        <?php endif; ?>
                    </dd>

                </dl>
                <div>
                    <input type="submit" value="登録" id="completion">
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
