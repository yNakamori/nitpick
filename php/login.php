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
                        header('Location: talk.php');
                        exit();
                    }else{
                        $error['login_feiled']='failed';//DBに登録されていない、パスワードがあっていない→再入力
                    }
            }else{
                $error['login_blank']='blank';//['userID']・['password']に入力されていない→入力
            }
        }
