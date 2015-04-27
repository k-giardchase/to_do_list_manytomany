##Developer
Kyle Giard-Chase & Geoff Winner

##Date
March 23 2015

##Description
An app for a user to create a to-do list. Tasks can have many categories, and categories can have many tasks.


##Technologies Used
PHP <br>
<a href='http://www.postgresql.org/'>PostgreSQL</a> <br>
<a href='https://developers.google.com/speed/libraries/'>jQuery</a> <br>
<a href='http://getbootstrap.com/'>Bootstrap </a>for styling <br>
It uses <a href='https://getcomposer.org/'>Composer</a> to install:
<li>
<a href='http://silex.sensiolabs.org/'>Silex</a>
</li>
<li><a href='http://twig.sensiolabs.org/'>Twig</a></li>
<li><a href='https://phpunit.de/'>PHPUnit</a></li>

##Use and Editing
To view the app,<br>
1. Open your command shell, and clone the repository into your home folder using the command `git clone https://github.com/k-giardchase/to_do_list_manytomany.git`<br>
2. Import the database into PostgreSQL. See the Database section to do so.<br>
3. In the top level of the project folder, run `composer install`<br>
4. Start a php server by changing directories into the web folder `cd to_do_list_manytomany/web`
and start your server `php -S localhost:8000`<br>
5. Open your browser and navigate to your root path: `localhost:8000`

##DATABASE
```sql
CREATE DATABASE to_do;
 \c to_do
CREATE TABLE categories (id serial PRIMARY KEY, name varchar);
CREATE TABLE tasks (id serial PRIMARY KEY, description varchar);
CREATE DATABASE to_do_test WITH TEMPLATE to_do;
```

##Copyright (c) 2015 Kyle Giard-Chase & Geoff Winner
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
