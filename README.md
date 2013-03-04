php-blank
=========

php minimal blank application with Tonic, Pimple, Smarty, Monolog, Mongodb

Setup
=========

Monolog
--------
Monolog is a logging framework. Monolog implements Psr interfaces.

* download Monolog from https://github.com/Seldaek/monolog onto folder /lib
* download Psr from https://github.com/php-fig/log onto folder /lib

Pimple
--------
Pimple is a minimal Dependency Injection framework-

* download Pimple from https://github.com/fabpot/Pimple onto folder /lib

Smarty
--------
Smarty is a template engine.

Smarty templates will be placed in folder /views

* download Smarty from http://www.smarty.net/download onto folder /lib

Tonic
--------
Tonic is a small annotation-based MVC framework.

Tonic controllers will be placed in folder /src

* download Tonic from https://github.com/peej/tonic onto folder /lib

Apache mount point
--------

The app will be mounted on the folder /web which includes only a dispatcher to Tonic controllers and a .htaccess to rewrite urls. This folder will include also static resources as javascripts, css, images.