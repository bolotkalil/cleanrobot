# cleanrobot

Clean robot is imitator of cleaning robot written keep SOLID principles and some pattern designs.           

===============================Clean Robot App comments================================

To implement this application I use PHP7.1 language with lumen framework, I use this framework because It short version of containerized framework laravel and it has beautiful dependency injection implementation.

-------------------------------Robot Service App---------------------------------------

Directory sturctures look like this:

App directory - contains all core classes, also contracts and services which I created. 

Directories and files which I created: 
1. src/app/Contracts - directory which contains abstract class and interfaces to make sure all SOLID principles keep.
2. src/app/Services - directory which contains class who extends and implemets the Contracts.
When I was creating relationship between components I used this pattern designes: 
- Chain of Responsibility - resolved "backoff" problem
- Iterator - implemented to manage all data(visited, cleaned etc)
- State - implemented to make sure that if battery low then change the state and turn off all behavior of robot.
- Factory - implemented to make sure we keep Open/Closed principle, if we want extend our functionality for accept other formats for example xml.
- Facade and Dependency Injection - It already implemented in the lumen I used it for make all relationship between components of robot.

3. src/app/Providers/RobotServiceProvider.php - registers our robot service to container.
4. src/app/Console/Commands/RobotCommand.php - implemeted command line feature to receive data and export result. To run robot make sure you are in root directory and use this command: php artisan robot [path to source file] [path to export result file]
5. src/app/Http/Controllers/RobotContolller.php - api controller to run robot. To run robot via API send param 'data' in json format to this url: http://example.com/api via POST method. I wrote todo marker there for accept file I didn't have enough time to implemet it.
6. src/routes/api.php - handler of api request, if this app will use as microservice we can easily create JWT based middleware for authentication.
7. src/tests/RobotTest.php - it only one test for make sure all relationship of classes work correctly. I wrote there todo marker I didn't have enough time to write tests for all of components separatelly.

-------------------------------Docker directories and files:---------------------------

nginx directory - contains Dockerfile, and server configurations.
php-fpm directory - contains Dockerfile
docker-compose.yml - launch Robot service in Container. You can launch it with this command in your terminal: docker-compose up -d
Note: the nginx use 8080 port.
