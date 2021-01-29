## About Application

It's project manager web application for manging projects, clients, invoices, tasks etc for individual to small business. It's Developed using Laravel v7.15.0. 

###### Completed

- User/Client Login Module 
- Admin Contacts Management Module
- Admin User Management Module
- Admin Role Management Module
- Admin Role Permision Management Module
- Admin Store/Business Mangement Module
- Project Category Mangement Module
- Project Management Module

###### In-Progress

- Bug fixing in existing features and testing

###### To-do

- Project Tasks Management Module - To-do 
- Project Milestones Management Module - To-do
- Customer Notification Management Module
- Announcement/Blog/News Management Module
- Support and Contact Module

###### Summary of completed modules 

Two differenet roles Admin/User will automatically added in system and both Admin and User have differnet dashboard according to assiged permissions in roles. Admin can add client users by email and assign them to projects.

## Installation Procedure

Pull Latest code: 

`https://github.com/lpkapil/projectmanager.git`

- Create Virtual Host & Host Entry in apache configuration and host file and restart apache server

```
<VirtualHost *:80>
        ServerAdmin webmaster@example.com
        ServerName projectmanager.com
        ServerAlias projectmanager.com
        DocumentRoot /var/www/html/projectmanager/public/
        <Directory /var/www/html/projectmanager>
                AllowOverride all
                Require all granted
        </Directory>
</VirtualHost>
```

`127.0.0.1 projectmanager.com`

`service apache2 restart`

- Run below command after navigating to application root for refreshing application key & installing database

`php artisan key:generate`

`php artisan migrate:refresh --seed`

`cd public`

`rm -rf storage`

`cd ..`

`php artisan storage:link`

- Storage:link command needs to be run first time, and it's used when application using media upload feature, it created symlink of internal image folder to public folder, so images can access via url from internal app stoage folder.

- Open application using URL

`http://projectmanager.com`

## Login Details

#### Admin #### 

Username: admin@example.com
Password: admin

#### User/Seller ####

Username: user@example.com
Password: user

## Demo Screens

Coming soon...

## Donate and Support

<div class='pm-button'><a href='https://www.payumoney.com/paybypayumoney/#/3FF0BB83F2A6D7DD27A53BC12E4AE109' target="_blank"><img src='https://www.payumoney.com/media/images/payby_payumoney/new_buttons/21.png' /></a></div> 
