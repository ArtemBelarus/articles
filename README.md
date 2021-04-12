<h2>Articles</h2>
<h3>Test project for "Aero Motors"</h3>
<br>
<h4>Requirements: </h4>
<ul>
    <li>(Tested on:) Intel i5-6200U, 16Gb, 128Gb SSD with 2Gb+ free disk space</li>
    <li>Ubuntu 20.04</li>
    <li>PHP 7.4</li>
    <li>PHP extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML</li>
    <li>Nginx or Apache/2</li>
    <li>MySql 8.0</li>
    <li>Composer</li>
</ul>
<br>
<h4>Installation: </h4>
<ul>
    <li>Set up local domain 'articles.test'.</li>
    <li>Create new database 'articles', and new db user 'root' with password 'root'.</li>
    <li>Rename .env-example to .env.</li>
    <li>Open project root in console and run following commands:</li>
    <li>composer install</li>
    <li>composer dump-auto</li>
    <li>php artisan key:generate</li>
    <li>php artisan migrate</li>
    <li>php artisan db:seed (will take approx 15-20 min)</li>
</ul>


