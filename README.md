# phpGallery
`phpGallery` is a free and open source images gallery system written in pure PHP (OOP) & MySQL. Frontend is based on Blog HTML Template called `Start Bootstrap` (http://startbootstrap.com).
## Features
- easy to install
- user friendly
- responsive (frontend based on bootstrap)
- multiple user support
- admin panel to upload/manage images, manage users and comments
- easy drag and drop uploads (dropzone.js)
- title, label and long description of images
- comments on images
## Usage
1. Copy all files to root directory on your webserver
2. Import database `gallery_oop.sql` in your MySQL
3. Edit database connection settings in `/admin/includes/db-config.php`
```php
// host
define('DB_HOST', 'localhost');
// username
define('DB_USERNAME', 'root');
// password
define('DB_PASSWORD', '');
// database name
define('DB_NAME', 'gallery_oop');
// charset
define('DB_CHARSET', 'utf8');
```
4. Make the folder `/admin/uploads` writeable
5. Default user is `admin` with password `admin`
## Requirments
- Webserver (Apache recommended)
- PHP (5.3.x or later)
- MySQL
## License
Licensed under the MIT license. (http://opensource.org/licenses/MIT)
Copyright (c) 2017 Dawid Górecki