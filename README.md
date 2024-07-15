<div align="center">
  <img src="https://raw.githubusercontent.com/Gersigno/gersigno.github.io/main/resources/gwp_logo_alpha.PNG" alt="A huge banner logo on my enterprise.">
</div>
<h1 align="center">🧾 ToDoList-<i>PHP</i> 🧾</h1>

# 👋 Introduction

💡This project was made during my <b>web development training</b>, this is <i>my proposal</i> for an exam on <b>PHP</b> 🥇.<br>
🧐The goal was to create a to-do list with a <b>complete CRUD</b> <i>(Create, Read, Update and Delete)</i> for <b>both tasks and users</b>.<br><br>
Don't forget to ⭐ <b>Star</b> ⭐ this repo ! <i>(This documentation and the project took some time to write, it's a simple free reward </i>🤩<i>)</i><br><br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/preview.png">
<br><br>

## 🧩 Features
### Account creation & management :
 - <b>✅ Account Registration</b> <i>(Create part of the exam)</i>
 - <b>🔍 Login</b> <i>(Read part of the exam)</i>
 - <b>✏️ Changeable password</b> <i>(Update part of the exam)</i>
 - <b>❌ Account deletable</b> <i>(Delete part of the exam)</i>
### Tasks
 - <b>✅ Create tasks</b> <i>(Create part of the exam)</i>
 - <b>🔍 Read 5 first tasks/All tasks</b> <i>(Read part of the exam)</i>
 - <b>✏️ Editable</b> <i>(Update part of the exam)</i>
 - <b>❌ Deletable</b> <i>(Delete part of the exam)</i>
 - ⏳ <i>Optional expiration date</i>
 - 🗂️ Filters <i>(Show `All`/`ToDo`/`Done`)</i>

## 📱Responsive
### This project is also fully responsive 

<table>
  <tr>
    <td><img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/responsive_tablette.png"></td>
    <td><img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/responsive_laptop.png"></td>
    <td><img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/responsive_phone.png"></td>
  </tr>
</table>

###### (*Except for the Apple watch* 😔)


### 💭 This project's front part is based on my [Javascript ToDoList using LocalStorage](https://github.com/Gersigno/ToDoList-in-JavaScript-using-localStorage)
<a href="https://github.com/Gersigno/ToDoList-in-JavaScript-using-localStorage">
  <img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/repository-open-graph-todolist.png" width="25%">
</a>
<br><br>

# 🔍 Table of content

### [💡 Documentation](https://github.com/Gersigno/ToDoList-PHP?tab=readme-ov-file#-documentation-1)
- [Technologies](https://github.com/Gersigno/ToDoList-PHP?tab=readme-ov-file#-technologies-)
- [Project's architecture](https://github.com/Gersigno/ToDoList-PHP?tab=readme-ov-file#%EF%B8%8F-projects-architecture--)
- [How does the MVC design pattern work ?](https://github.com/Gersigno/ToDoList-PHP?tab=readme-ov-file#-how-does-the-mvc-design-pattern-work-)
- [How our data is updated without any page reload ?](https://github.com/Gersigno/ToDoList-PHP?tab=readme-ov-file#-how-our-data-is-updated-without-any-page-reload-)

### [🧰 Setup the project](https://github.com/Gersigno/ToDoList-PHP?tab=readme-ov-file#-setup-the-project-1)
- [Create a local server using Wamp](https://github.com/Gersigno/ToDoList-PHP?tab=readme-ov-file#-create-a-local-server-using-wamp)
- [Setup the database connexion](https://github.com/Gersigno/ToDoList-PHP?tab=readme-ov-file#-setup-the-database-connexion)

# 💡 Documentation

## 🧪 Technologies :
<img src="https://img.shields.io/badge/Html5-%23E34F26.svg?style=flat&logo=html5&logoColor=white">
<img src="https://img.shields.io/badge/Css3-%231572B6.svg?style=flat&logo=css3&logoColor=white">
<img src="https://img.shields.io/badge/JavaScript-%23F7DF1E.svg?style=flat&logo=javascript&logoColor=black">
<img src="https://img.shields.io/badge/PHP%208-%23777BB4.svg?style=flat&logo=php&logoColor=white">

### This project use an MVC *([Model–View–Controller](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller))* design pattern.
## 🗂️ Project's architecture : <br>
```yaml
📂 /controllers              #Called whenever the user request an url in our project, the controllers render our views and link informations.
├─📄 Controller.php            : Default controller, define the basics of our controllers, every other controllers extend from this class.
└─📄 TasksController.php       : Will not render any view, this controller is used to fetch our informations from our javascript.
📂 /core                     #"Heart" of our project
├─📄 Database.php              : This class extend from PDO, it will be used to connect our client to our database.
└─📄 Router.php                : Will map user's request to our controllers and controller's functions.
📂 /models                   #(Entities) Everything usefull to interact with our database's table
├─📄 Model.php                 : Default Model, every other Models will extend from this class.
├─📄 Tasks.php                 : Everything usefull to interact with the "Tasks" table.
└─📄 Users.php                 : Everything usefull to interact with the "Users" table.
📂 /public                   #Project's root folder, everything in this folder will be publicly accessible to everyone.
├─📁 /resources                : Project's images like icons etc.
├─📂 /scripts                  : All our javascript files.
│ └─📁 /classes                : All our javascript's classes.
├─📁 /styles                   : All our CSS stylesheet files.
├─📄 .htaccess                 : Apache's configuration file, required for our router !
├─📄 favicon.ico               : Website's icon
└─📄 index.php                 : This file will be the first file to be loaded on our website, it will initialize our Autoloader and our Router !
📂 /views                    #Every interfaces of our website
└─📄 base.php                  : This view is the default one, every other views will be rendered inside this one.
📄 Autoloader.php              : Will auto-include everything required automatically.
```

## 🤔 How does the MVC design pattern work ?
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/MVC_schema.png"> <br>
- Our <b>Client</b> <i>(Web Browser)</i> send an URL to our <b>Router</b>, then the <b>Router</b> try to obtain the intended <b>Controller</b> <i>(it looks for a method in a particular controller depending on the url sent).</i><br>
- Then the <b>Controller</b> will process the information <i>(search in our models for database informations, the models will execute the queries and return the data)</i>.<br>
- Then the <b>Controller</b> will send the informations to a <b>View</b> that should generate the HTML, and return the page to the <b>Client</b> <i>(Web Browser)</i>.

## ⌛ How our data is updated without any page reload ?
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/fetch.png"> <br>

# 🧰 Setup the project

## 📍 Create a local server using [**Wamp**](https://wampserver.aviatechno.net/) 
💡*This demonstration is for Windows environment !* 
<br>
### [**Wamp**](https://wampserver.aviatechno.net/) is a software stack which means installing WAMP installs **Apache**, **MySQL**, and **PHP** on your operating system.
📥You can download it from [**here**](https://wampserver.aviatechno.net/index.php?affiche=install).
<br>
⚠️You may also need the <b><i>`Visual C++ Redistributable Packages`</i></b>, you can download it from [**here** *(learn.microsoft.com)*](https://learn.microsoft.com/en-us/cpp/windows/latest-supported-vc-redist?view=msvc-170)
<br><br>
### 💡 First of all
- Open your file explorer and go to you wamp's `www` folder.<br>
<i>(It should be located at `c:/wamp/www` by default)</i><br>
- Then, clone this project or donwload and extract this project inside the `www` folder<br>
It should look like this :<br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/explorer_default_project.png"><br>
⚠️ <i>From now, the path of the project will be different FOR THIS EXEMPLE ONLY cause of my www path being different than the default one.</i>

### 📟 Setup your virtual host with wamp

First of all, open your web-browser and go to [http://localhost](http://localhost/).<br>
Then, click on `🔧 Add a Virtual Host` from the <b>`Tools`</b> category or [click here directly](http://localhost/add_vhost.php).
<br><br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/vh_add_new.png">
<br>
<br>
Afterward, enter a `name` for your virtual host, the `Path` of the project,<br>
and confirm the creation of the new virtual host by clicking the <b>`Start the creation/modification of the VirtualHost`</b> button at the bottom.
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/vh_add_new_2.png">
<br><br>
<b>⚠️ Make sure to change the route of the virtual host</b> to our <b>`public`</b> folder by editing the `httpd-vhosts.conf` file by <br>
<b>`left-clicking`</b> the wamp's tray icon <br>
└─<b>`Apache`</b><br>
　　└─<b>`httpd-vhosts.conf`</b><br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/vh_edit_conf.png">
- Find your newly created virtual host <br>
- Edit the `DocumentRoot` property by adding the "`/public`" text at the end of it. <br>
📢<i>Make sure to only edit the `DocumentRoot` property and not the `Directory` one !</i>

<b>It should look like this : </b><br>
<i>Before :</i><br>
`"c:/user/admin/dev/www/sites/todolist-php"`<br>
<i>After :</i><br>
`"c:/user/admin/dev/www/sites/todolist-php/public"`<br><br>
⚠️ Then, **restart your wamp's DNS** by <br>
<b>`right-clicking`</b> the wamp's tray icon <br>
└─<b>`Restart from zero`</b><br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/vh_restart_dns.png">
<br><br><br>
## 📍 Setup PhpMyAdmin and mySQL database
### 📚Create our Database
First, go to [http://localhost](http://localhost/) and click on `PhpMyAdmin` <br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/sql_phpmyadmin_1.png"><br>
You will need to connect to the `root` account, the credentials are by default : <br>
Login: `root`<br>
<b>no password</b><br>
<i>Set the `Server choice` to `My SQL` and <b>log in.</b></i><br><br>
Click on the <b>SQL</b> button.<br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/sql_create.png"><br><br>
Then, copy and paste theses instructions to create our database and our tables. :
```SQL
CREATE DATABASE IF NOT EXISTS `ToDoList-PHP`;
USE `ToDoList-PHP`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `users`(
	`id` int PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(20) UNIQUE NOT NULL,
    `pass_hash` varchar(260) NOT NULL
);
CREATE TABLE IF NOT EXISTS `tasks`(
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `owner_id` int NOT NULL,
    `title` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `done` tinyint(1) NOT NULL DEFAULT 0 CHECK(`done` IN(0, 1)),
    `creation_date` datetime NOT NULL,
    `expiration_date` datetime
);
ALTER TABLE `tasks` ADD FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);
```
And then, click the <b>`Go`</b> button.
<br><br>
### 🪪 Create a new user<br>
- First, go back to to the <b>`home page`</b> of <b>PhpMyAdmin</b> by clicking on the `🏠` buttom/icon<br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/sql_newuser_1.png"><br>
- Then, click on `User account`<br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/sql_newuser_2.png"><br><br>
- Click on `Add user account`<br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/sql_newuser_3.png"><br><br>
- Set the <b>User name</b> to `todolist_manage`,<br>
the <b>Host name</b> to `localhost`<br>
and set a strong password <b>⚠️ REMEMBER IT, WE'LL NEED IT LATER. ⚠️</b>
<i>(Re-type it in the `Re-type` section)</i><br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/sql_newuser_4.png"><br><br>
- Scroll down to the `Global privileges` Section and check :
  - `SELECT`
  - `INSERT`
  - `UPDATE`
  - `DELETE`<br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/sql_newuser_5.png"><br><br>
- Finally, scroll down to the bottom of the page and click the <b>`Go`</b> button.
## 📍 Setup the database connexion.
- Open the file `Database.php` file located in the `core` folder (<i>``core\Database.php``</i>)<br>

- Edit the <b>`db_name`</b> constant by replacing it's value by the  previously database's name (<i>"`ToDoList-PHP`"</i>).<br>
- Edit the <b>`dbuser`</b> constant by replacing it's value by the username previously created in <b>PhpMyAdmin</b> (<i>"`todolist_manage`</i>").<br>
- Edit the <b>`dbpass`</b> constant by replacing <b>`YOUR_PASSWORD_HERE`</b> by the strong password you've create in the <b>PhpMyAdmin</b> new user.<br><br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/db_connect_pass.png"><br>
### ✅ You are ready to go !
Click on your virtual host from the [localhost](http://localhost/) page.<br>
<img src="https://raw.githubusercontent.com/Gersigno/ToDoList-PHP/main/repo-resources/setup_done.png"><br>
Check if everything works fine by creating an account and some tasks ! 👍<br>
Don't forget to ⭐ <b>Star</b> ⭐ this repo ! <i>(This documentation and the project took some time to write, it's a simple free reward </i>🤩<i>)</i><br><br>

## 🧐Support

For support, email contact.gersigno@gmail.com or join the ***[discord server](https://discord.gg/kr3mwwg8jR)***.