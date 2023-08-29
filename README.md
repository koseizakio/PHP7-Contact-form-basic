# PHP7 お問い合わせフォーム 入門

## 環境バージョン

MacOS MAMP ローカル環境

PHP ```7.4.33```

Webサーバー```Apache```

MySQL```5.7.39```


データベースの説明

データベース名```contact```

テーブル名```contact```

テーブル作成(MySQL)

phpMyAdminでも可能。

```
CREATE TABLE `contact`.`contant` (`id` INT(11) NOT NULL , `name` VARCHAR(50) NOT NULL , `name_furi` VARCHAR(50) NOT NULL , `age` INT(3) NOT NULL , `email` VARCHAR(100) NOT NULL , `subject` VARCHAR(100) NOT NULL , `body` VARCHAR(1000) NOT NULL , `date` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

## git clone してお試しください。

※ <strong>~/htdocs/*</strong>に配置すること

```
git clone https://github.com/koseizakio/PHP7-Contact-form-basic.git
```
## php.iniの設定

```
[mail function]
; For Win32 only.
; http://php.net/smtp
SMTP = smtp.gmail.com
; http://php.net/smtp-port
smtp_port = 587
```

## Macのmain.cfの設定

/private/etc/postfix/main.cf

```
# Gmail on MAMP
#
myorigin = gmail.com
myhostname = smtp.gmail.com
relayhost = [smtp.gmail.com]:587
smtp_sasl_auth_enable = yes
smtp_sasl_password_maps = hash:/private/etc/postfix/アプリパスワード
smtp_sasl_security_options = noanonymous
smtp_sasl_mechanism_filter = plain
inet_protocols = all
smtp_use_tls = yes
smtp_tls_security_level = encrypt
tls_random_source = dev:/dev/urandom
```

次にアプリパスワードファイルの作成

```sample@gmail.com``` を自分のGmailのメアドにする。

https://tech.amefure.com/web-mamp-gmail#head4

## 参考にしたURL

[PHP メールフォームの作り方](https://www.webdesignleaves.com/pr/php/php_contact_form_01.php)

[【MAMP/Gmail】ローカル環境でメールをテスト送信するための設定方法！](https://tech.amefure.com/web-mamp-gmail)
