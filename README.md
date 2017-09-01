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

You put people in Roles eitheir via Console 
- php bin/console fos:user:promote user role
