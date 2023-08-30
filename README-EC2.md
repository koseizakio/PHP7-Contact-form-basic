# PHP7 お問い合わせフォーム 入門

## 環境バージョン

### EC2 検証環境

EC2 ```Ubuntu22.04```

PHP ```7.4.33```

Webサーバー```Apache```

MySQL```MariaDB10.6.12```

### Mariadbをインストール

```
sudo apt update
sudo apt install mariadb-server
```

### パスワード設定
※今回のパスワードは「root」

```
ubuntu@ip-172-31-38-255:~$ sudo mysql_secure_installation

NOTE: RUNNING ALL PARTS OF THIS SCRIPT IS RECOMMENDED FOR ALL MariaDB
      SERVERS IN PRODUCTION USE!  PLEASE READ EACH STEP CAREFULLY!

In order to log into MariaDB to secure it, we'll need the current
password for the root user. If you've just installed MariaDB, and
haven't set the root password yet, you should just press enter here.

Enter current password for root (enter for none): 
OK, successfully used password, moving on...

Setting the root password or using the unix_socket ensures that nobody
can log into the MariaDB root user without the proper authorisation.

You already have your root account protected, so you can safely answer 'n'.

Switch to unix_socket authentication [Y/n] n
 ... skipping.

You already have your root account protected, so you can safely answer 'n'.

Change the root password? [Y/n] y
New password: 
Re-enter new password: 
Password updated successfully!
Reloading privilege tables..
 ... Success!


By default, a MariaDB installation has an anonymous user, allowing anyone
to log into MariaDB without having to have a user account created for
them.  This is intended only for testing, and to make the installation
go a bit smoother.  You should remove them before moving into a
production environment.

Remove anonymous users? [Y/n] y
 ... Success!

Normally, root should only be allowed to connect from 'localhost'.  This
ensures that someone cannot guess at the root password from the network.

Disallow root login remotely? [Y/n] y
 ... Success!

By default, MariaDB comes with a database named 'test' that anyone can
access.  This is also intended only for testing, and should be removed
before moving into a production environment.

Remove test database and access to it? [Y/n] y
 - Dropping test database...
 ... Success!
 - Removing privileges on test database...
 ... Success!

Reloading the privilege tables will ensure that all changes made so far
will take effect immediately.

Reload privilege tables now? [Y/n] y
 ... Success!

Cleaning up...

All done!  If you've completed all of the above steps, your MariaDB
installation should now be secure.

Thanks for using MariaDB!

ubuntu@ip-172-31-38-255:~$ mysql -u root -p
Enter password: 
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 39
Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1 Ubuntu 22.04

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> exit;
Bye

ubuntu@ip-172-31-38-255:~$ mysql --version
mysql  Ver 15.1 Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64) using  EditLine wrapper
```

### PHP7.4のインストールの仕方

```
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get install php7.4 php7.4-pdo
sudo apt-get install -y php7.4-cli php7.4-json php7.4-common php7.4-mysql php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath
php -v
```

### PHPのバージョン確認

```
ubuntu@ip-172-31-38-255:~$ php -v
PHP 7.4.33 (cli) (built: Aug 14 2023 06:42:07) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
    with Zend OPcache v7.4.33, Copyright (c), by Zend Technologies
```

### Apacheのバージョン確認

```
ubuntu@ip-172-31-38-255:~$ apachectl -v
Server version: Apache/2.4.52 (Ubuntu)
Server built:   2023-05-03T20:02:51
```

### Webのドキュメントルート

```/var/www/html/ に配置する。```

```
git clone https://github.com/koseizakio/PHP7-Contact-form-basic.git
sudo mv /home/ubuntu/PHP7-Contact-form-basic/* /var/www/html/

// Git cloneしたディレクトリーは削除しておくことをおすすめします。
rm -rf PHP7-Contact-form-basic/
```

### MySQLでテーブル作成

```
// データベース作成
create dabase contact;
// contact使用
use contact;
// テーブル作成
create table contact;
CREATE TABLE `contact`.`contact` (`id` INT(11) NOT NULL , `name` VARCHAR(50) NOT NULL , `name_furi` VARCHAR(50) NOT NULL , `age` INT(3) NOT　NULL , `email` VARCHAR(100) NOT NULL , `subject` VARCHAR(100) NOT NULL , `body` VARCHAR(1000) NOT NULL , `date` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

// IDをAUTO_INCREMENTする。

ALTER TABLE `contact` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
```

### 完成物

構成図

![](https://koseizakio.link/wp-content/uploads/2023/08/diagram-1024x613.png)

お問い合わせフォーム

![](https://koseizakio.link/wp-content/uploads/2023/08/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88-2023-08-30-10.35.12.png)

管理者画面

![](https://koseizakio.link/wp-content/uploads/2023/08/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88-2023-08-30-11.04.42-1024x336.png)

※今回は、メール送信設定をしないことにしました。

## 参考URL

[PHP メールフォームの作り方](https://www.webdesignleaves.com/pr/php/php_contact_form_01.php)

[Apacheの起動・停止・再起動・状態確認](https://ubuntu.perlzemi.com/blog/20200519084454.html)

[MariaDBの起動・停止・再起動・状態確認](https://ubuntu.perlzemi.com/blog/20200417174004.html)

[PHP7 お問い合わせフォーム 入門 (koseizakioのGithub)](https://github.com/koseizakio/PHP7-Contact-form-basic)