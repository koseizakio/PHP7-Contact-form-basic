# PHP7 お問い合わせフォーム 入門

## 環境バージョン

MacOS MAMP ローカル環境

```
PHP 7.4.33
```

```
Webサーバー、Apache
```

```
MySQL 5.7.39
```

データベースの説明

データベース名```contact```

テーブル名```contact```

テーブル作成(MySQL)

```
CREATE TABLE `contact`.`content_2` (`id` INT(11) NOT NULL , `name` VARCHAR(50) NOT NULL , `name_furi` VARCHAR(50) NOT NULL , `age` INT(3) NOT NULL , `email` VARCHAR(100) NOT NULL , `subject` VARCHAR(100) NOT NULL , `body` VARCHAR(1000) NOT NULL , `date` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```
