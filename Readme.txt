
--------------------download or clone--------------------

Clone this repository to your specific folder 
eg: transfermate 

-----------------Requirements-------------------
PHP 7.5 and above 
Postgres


----------------CONFIGURATIONS---------------

-------------------Create your database-----------------
1. utf8 is important to save Cyrilic symbols 
CREATE DATABASE <yourdatabasename>
    WITH ENCODING = 'UTF8'
    LC_COLLATE = 'en_US.UTF-8'
    LC_CTYPE = 'en_US.UTF-8'
    TEMPLATE = template0
    OWNER <user>;

  where <yourdatabasename> : Name of your database
  		<user> : user of database 

2.  Once created edit environment.php 
     - this contains credentials for your db connection and parameters
     - save the file after updating 
3. run cli (commmand line ) php migrate.php 
	- this will generate two tables authors and books

----------------------XML------------------------------------
1. XMl files and storage  (books_xml)
	- xml file is under "books_xml"
	- you may create subdirectories and save xml to that folder 
	- books_xml is public available , this is to display the xml file in result page 

2. run cli ( command line) php cron.php 
	- this will read the xml file in "books_xml"

3. XML sample also provided in the books_xml 
	- assumption
		- XML has author / name 
		- any metadata / object will be save as json 


---------------------FINAL------------------------------

5. visit index.php eg: localhost/index.php
   search: click search after entering keywords 
   Pagination: applied pagination to limit request in the db sequel, To avoid large data execution
   	LIMIT: 10 per pages 
   	 you may adjust number of items to display in index.php 


-----------------REVISION----------------------------

1. PSR formatting
2. Refactor 
3. Code beautifier fixer using phpbcf
