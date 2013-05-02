MatMar10 TODO Twitter Demo
==========================

Overview
--------
This is a social task applicastion that tweets tasks when you check them off.

What it Has
----------
* Login or Register with Twitter
* Create tasks in your browser
* Tasks are automatically tweeted
* Bootstrap UI makes thinks look decent
* Authentication uses a request listener pattern; other types of authentication providers or error listeners can be added 

What is Missing
---------------
* Tasks are not persisted
* No logout
* No checking if Twitter session is still valid
* No validation to speak of
* Much, much more. 

Installation Instructions
-------------------------
1. Download to a directory, e.g. ::install_dir::
2. Set up a new Apache VirtualHost
3. Point the new VirtualHost to ::install_dir::
4. Download composer.phar from http://getcomposer.org/download/ to ::install_dir::
5. Navigate to ::install_dir::
6. Run `php composer.phar install`
7. Update the database settings within app/config/parameters.yml such that the user will hve CREATE privelege 
8. Run `php app/console doctrine:database:create`
9. Run `php app/console doctrine:schema:create`
10. Point your browser at the hostname you set up in Apache and enjoy

Testing Notes
-------------

Tested only in Chrome v26 on OSX

No unit tests have been written.

Other Notes
----------
There is a lot of cruft under the hood. Generally TODOs have been put in the code where stuff is crusty.

NOTE: Presently tasks are not persisted. Only authentication is persisted. 


Problem Statement
-----------------
> Build a social TODO List web application that uses the Twitter to
authenticate and handle the following use case:
>
> 1. An anonymous user opens the application
> 2. The application prompts the user to connect/signin with Twitter
> 3. The user goes to twitter and allows the app, then returns to the app
> 4. A user account is created for the authenticating user using the
> details (name, username, etc) in their twitter account.
> 5. The user is able to create a TODO lists, each containing multiple
> TODO items, each with an "Is completed" checkbox.
> 6. The user is able to add items to the TODO list, and on the "new
> TODO item" screen, there's a checkbox that allows you to cross post
> your new TODO as a Tweet on Twitter.
> 7. The app will automatically post a tweet when you "check off" an
item like "John Smith just complete 'Mow the Lawn'!"
> 8. You should have fun building the app. :)
>
> The application should have all normal fundamentals for input
> validation, error handling, edge case handling, etc. and should be
> deployed somewhere that you can send us a simple URL to view and use
> it, you should also be prepared to send us the full source code for
> review.
>
> Language/environment doesn't matter, use whatever tools you'd like.
>
> We know that not everyone's a designer, so no worries here. We're
> looking at the functionality first and foremost, but extra points for
> any other awesome ideas, design polish or functionality you decide to
> add

