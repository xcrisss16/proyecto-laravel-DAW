# RA8 report

## Server side vs client side

Server side code runs on the web server before the browser receives the response. In this project Laravel builds the HTML, validates forms, checks permissions and reads the database.

Client side code runs in the browser after the page is loaded. In this project JavaScript is used for the AJAX actions so the page can update without a full reload.

## Laravel as server side framework

Laravel is the backend framework that manages routing controllers models validation authentication and database access. It is the part that decides what data is shown and who can edit it.

## Why combine Laravel with JavaScript

Laravel gives structure security and data control. JavaScript improves the user experience by updating dynamic content like task status and delete actions without refreshing the whole page.

## Technologies used

- Laravel
- Blade templates
- HTML
- CSS
- JavaScript

## Web interface

The project includes a landing page login register dashboard list create edit show and delete views. The task list uses pagination search flash messages and role based permissions.

## Validation and interaction

Forms use server side validation with Laravel Form Requests. Validation errors are shown in Blade views. CRUD actions show success and error feedback through flash messages.

## Dynamic content and AJAX

The task list is loaded from the database and filtered with search and pagination. The complete and delete actions are handled with Fetch so they update the interface without a full page reload.

## Authentication and permissions

The app includes custom login and register screens. Users have a role field and admins can manage every task while normal users can manage only their own tasks.