# ra8 report

## server side vs client side

server side execution happens on the server before the page reaches the browser. in this project laravel receives the request checks the session reads the database validates the form and builds the html with blade.

client side execution happens in the browser after the page loads. javascript is used here to improve interaction without reloading the whole page such as toggling a task and deleting a task with fetch.

## role of laravel

laravel works as the server side framework that controls routes controllers validation authentication database access and blade rendering. it keeps the code organized and makes it easy to separate views from business logic.

## laravel plus javascript

using laravel with javascript gives a better user experience. laravel handles the secure data flow and javascript adds speed and interactivity. in this project ajax actions update the interface without a full reload.

## technologies used

- laravel
- blade templates
- html
- css
- javascript

## evidence included in the project

- login and register pages
- task create edit delete and detail views
- server side validation with error messages
- search and pagination on the task list
- ajax toggle and ajax delete without full page reload
- role based access with user and admin