# Bookstore
Fictional e-commerce PHP application

This application was build with purpose of learning PHP OOP, MVC architectural pattern, 
with registry and front controller pattern. The best way of learning is to apply language  
basics into real world project example. It has basic functionalities such as: 

   - register and login users
   - browsing products 
   - browsing authors of the books
   - browsing categories of the product
   - rate and review products
   - rate reviews of the products
   - adding products to the wishlist
   - shopping cart full functionality
   - user's account controll
   - sending emails to administrator via contact form
   - store final orders before payment
   - full admin panel
   
Future modules which will be added:
   - downloadable products
   - payment integration (PayPal, credit cards etc.)
   - some minor additions such as viewing and printing invoices, recently viewed 
     products and details about product publishers
     
Since I'm still working on comprehending payment process, the final stage of the project, for 
now, is storing orders in the database with 'awaiting payment' status. 
SQL dump file for creating appropriate database is in the database folder. Database is 
prepopulated with some data for testing. Users table have few user entries with password: PASSWORD.

In config.php file located in the protected/config folder are database settings. It should be edited 
suitable to yours development enviroment. 
In my opinion, every nowadays pages should use `https` protocol, specially e-commerce sites so it is 
used in this project. For fully testing I'm using self assigned certificate on my localhost 
environment. If you need to use `http` protocol for any reason you should edit main .htaccess file, 
because it forces https protocol through whole application. That means :
  1. deleting   
     `RewriteRule ^(.*)$ https://localhost/bookstore/$1 [R,L]`  
     on line 14 in main .htaccess file
  2. changing registry setting named 'protocol' to `http` on line 36 in index.php file

Free basic template from css-free-templates.com is used and modified for the project needs.
Every comment, criticism and suggestion is very welcome!
