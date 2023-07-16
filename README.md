# attendance_management_system
Attendance Management System for College  

To Run this Project: 
1-> Downlaod this Project  
2-> Move it to this location: C:\xampp\htdocs  (i.e. in the htdocs directory of xampp)  
3-> Open this project directory and open database sub-directory  
4-> Copy the database name : database_name.sql  (here name is: finaltest)  
5-> Now open Xampp and start Apache Server and MySQL  
6-> Open Browser and Search for localhost  
7-> Create a new database with the name as above(4)   
8-> Import the database from the project directory  
9->Open this link: http://localhost/attendance_management_system/index.php   
10-> Login Details(can also see in the admin table of the database):  
       Select Login as Administrator:  
       Username: admin01  
       Password: Shiva@123  









For the feature of uploading data through excel files in a new project:  
-> Download and install composer from this link: https://getcomposer.org/Composer-Setup.exe  

->Run and Install the downlaod exe file with default settings  
->Now open command prompt and move to the project directory(in which you want to add this feature(use cd "yourdirectorypath" to move))   
->Now Use composer to install PhpSpreadsheet into your project:  

    composer require phpoffice/phpspreadsheet  

-> if getting any error :  
            1-> Go to C: Drive and Search for php.ini in the SearchBox  
            2-> select php.ini file, open with notepad  
            3-> Press Ctrl+F to search and   
                    a) search for "extension=fileinfo"(with quotes) :   
                        if find something as ";extension=fileinfo" then remove the semicolon';'  
                    b) search for "extension=gd"(with quotes):  
                        if find something as ";extension=gd" then remove the semicolon';'  
            4-> Press Ctrl+S to save  

-> Now again run this command: composer require phpoffice/phpspreadsheet  
-> A vendor directory and composer files might be created in the working directory after running above command  
->DONE  
