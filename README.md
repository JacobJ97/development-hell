# Development Hell

## Current Version
v1 (inital)

## Next Version
v2 (adding user & user roles)

## Description 
A simple CRUD database, using PHP & MySQL, with some help from the [JQuery](https://github.com/jquery/jquery) & [Bootstrap](https://github.com/twbs/bootstrap) libraries. 

## Purpose 
Right now, the purpose of this application is to survey people about a "favourite pony", which can be viewed and updated by anybody. 

## Focus Issues
- The data can be updated by anybody, which can lead to the integrity of the database being ruined. 
- The survey is very specific, and cannot be modified on any scale.

## Solving Focus Issues
- Data can be made more secure if the database could only be edited by certain users.
- Add system to allow survey and it's contents to be changed to whatever.

## Other Issues 
- Needs some configuring to get working.
- Only uses a .htaccess file (no love for nginx)
