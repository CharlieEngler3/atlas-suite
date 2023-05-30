# Atlas Suite

This was a project that started as an entry into the Congressional App Challenge and later transitioned into becoming my Extended Learning Opportunity at Exeter High School.

## Getting Started

This is a very simple PHP web application, so the setup will be rather straightforward.

### Prerequisites

- [XAMPP](https://www.apachefriends.org/download.html)

### Installation

  1.) Install XAMPP with the Apache, phpmyadmin, and MySQL addons. The other ones won't be necessary
  
  ![Step 1](https://imgur.com/oDlRwlQ.png)

  2.) Navigate to the "htdocs" folder inside the installation directory
  
  ![Step 2](https://imgur.com/yydEhUd.png)

  3.) Place all of the code from this repository into the htdocs folder
  
  ![Step 3](https://imgur.com/fY3lWN5.png)
  
  4.) Navigate up a directory, create a file named "password.php", and paste the following code into it
  
      <?php
          $servername = "localhost";
          $server_user = "root";
          $serverpassword = "";
      ?>
      
  ![Step 4](https://imgur.com/AryHQse.png)
      
  5.) Open the XAMPP control panel and click "Start" next to the "Apache" and "MySQL" modules
  
  ![Step 5](https://imgur.com/ctEzJxy.png)
  
  6.) Once these services have started, click the "Admin" button for the "MySQL" module and allow the web page to open
  
  ![Step 6](https://imgur.com/aBtKKFF.png)
  
  7.) On the left there will be a list of databases with a button that says "New" at the top of the list. Create the following databases:
  
      connect
      forums
      notifications
      task_manager
      users
      
  ![Step 7](https://imgur.com/gvlDO7a.png)
      
  8.) In the "htdocs" folder, there will be a sub directory labeled "DEV_SQL_DATABASES". Open this and import each of the SQL files into their corresponding databases
  
  - Note: To import the files, you can select each database on the left hand list and then simply drag the file onto the web page, or you can use the "Import" button on the top toolbar.

  ![Step 8](https://imgur.com/T5gozjr.png)
      
  9.) Close the web page with the database configurations and type localhost in a new tab on your web browser
  
  ![Step 9](https://imgur.com/JCCSKOL.png)
  
  10.) The website should be up and running at this point

## Authors

  - **Charlie Engler** - *Website Designer and Programmer* -
    [CharlieEngler3](https://github.com/CharlieEngler3)
    
  - **Sean Cheng** - *Website Designer and Programmer* -
    [sean7391]([https://github.com/CharlieEngler3](https://github.com/sean7391))

## License

MIT
