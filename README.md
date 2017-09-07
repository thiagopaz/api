API 
========================

The API we are creating in this gist will follow these rules :

- [x] The API only returns JSON responses
- [x] All API routes require authentication

The API will be written in PHP with the Symfony 3 framework. The following SF2 bundles are used :

- https://github.com/FriendsOfSymfony/FOSRestBundle
- https://github.com/FriendsOfSymfony/FOSUserBundle
- https://github.com/FriendsOfSymfony/FOSOAuthServerBundle
- https://github.com/schmittjoh/JMSSerializerBundle
- https://github.com/nelmio/NelmioApiDocBundle

The first step is to download Symfony and the related bundles. I willl use the [Symfony Installer](http://symfony.com/doc/current/quick_tour/the_big_picture.html#installing-symfony) and [Composer (installed globally)](https://getcomposer.org/doc/00-intro.md#globally)


 - composer install 

You can now update your database schema :

```shell
php bin/console doctrine:schema:update --force
```

## Add Oauth2 client

The following step consists in adding a new OAuth2 client. The documentation is not very clear on that point, [the following code can be injected in a command to create new client](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/index.md#creating-a-client). In our case, we need
only one client, so I add the client manually with a simple SQL query :

```sql
INSERT INTO `oauth2_clients` VALUES (NULL, '3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4', 'a:0:{}', '4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k', 'a:1:{i:0;s:8:"password";}');
```



## Create admin user

We are going to use the command `fos:user:create`, provided by `FOSUserBundle` :

```shell
$ php bin/console fos:user:create
Please choose a username:admin
Please choose an email:admin@example.com
Please choose a password:admin
Created user admin


You put people in Roles eitheir via Console 
- php bin/console fos:user:promote user role
