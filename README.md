api link(collection postman):

https://www.getpostman.com/collections/2c3f4a625601f7132500

sql file:
test.sql

relationship 1: users and phone (one to many)

relationship 2: users and properties (many to many)

phones table:
   id,number,type,user_id

users table:
   id,first_name,last_name

property table:  
   id,house_name_number,postcode

pivot table:   
   user_id,property_id,main_owner   
