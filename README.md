## Modified version of Mondo License Grinder

## Modifications
- Automatically fills in url tags based on title
- Resolves both decoded and encoded tags
- uses uikit for better interface

### Mondo License Grinder v.0.3+, UBC Custom Edition

#### Notes
The author makes no claim that this is an innovative or complex solution; 
rather this is a pure CRUD (Create/Report/Update/Delete) application. All it
does is provide an interface to a simple database. It doesn't connect to an 
ERM, or pull in license data from a publisher, or anything cool like that.

#### Requirements
MySQL 5+
PHP 5.1+

### Installation notes

There isn't any interactive installation script. So:

1. Create a database (only MySQL has been tested). Note the database name,
   user, and password. Import the file "licenses.sql" to get a blank schema.
   
2. Copy config.php-dist to config.php. Modify the DB* constants to reflect
   the values you recorded in Step 1. If you want to host your own jQuery scripts, 
   go ahead and change the JQUERY and JQUERYUI constants to point at yours
   instead.
   
   Change the BASE_URL define to the Web location of your installation. It 
   doesn't need to have its own domain, but the trailing slash (/) is required.
   
   Create a directory outside of the Web space for storing license documents. This
   should be readable and writable by PHP/the Web server.
   
   Generate a cryptographic key (32 bytes) and put it in a location accessible to PHP
   but outside of the Web root, probably not the same place as thew document store. 
   This will be used to encrypt any uploaded license documents.
   
3. Copy header.inc.php-dist to header.inc.php and footer.inc.php-dist to
   footer.inc.php. Make any modifications you like.

4. Enable simple auth on the staff/ and admin/ directories. There is a sample
   "htaccess-dist" supplied in each directory. 
   
5. You may need to edit the .htaccess file in the site root and/or enable
   mod_rewrite. Currently the site probably won't work without mod_rewrite.

6. If all has gone well, visiting {BASE_URL} will show the public-facing app.

7. Go to {BASE_URL}/admin to begin entering your license data.

8. {BASE_URL}/staff provides more information than the public site.

9. Regarding boilerplate texts -- if you use mailto: links, they will
   automatically be rewritten to have a subject reflecting the current license 
   being displayed, if any. This means that you should not put a subject on the
   link yourself (i.e. <a href="mailto:foo@bar.ca?subject=Licenses">mail us</a>.
   If you don't want this behaviour, please edit the "getHTML" method found
   in db.inc.php.
   
   
