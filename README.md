The project is an assignement whose description is at the footer.
To install and set up a Laravel project on your computer, follow these steps:

Prerequisites:

Make sure you have PHP, Composer, and a database (e.g., MySQL, PostgreSQL) installed on your computer.
Ensure that your system meets the minimum requirements to run Laravel. You can find the requirements in the official Laravel documentation.
Install Dependencies:

Open a terminal or command prompt and navigate to the project's root directory.
Run the following command to install the required dependencies using Composer: "composer install"
Generate a new application key by running the following command: "php artisan key:generate"
To create the required database tables, run the database migrations with the following command:"php artisan migrate"
You can use the built-in development server to run the application. Execute the following command:"php artisan serve"



//Task assigned
Laravel Web Application Development Assignment
Description: You are required to build a simple web application using PHP Laravel. The
application will be a basic task management system that allows users to create, read,
update, and delete tasks. The application should follow best practices, including proper code
structure, security measures, and validation.
Instructions:
1. Setup: a. Create a new Laravel project or use an existing one (preferably Laravel 8 or
above). b. Configure the database connection to use MySQL/SQLite/postgres
2. Database: a. Create a migration to create the 'tasks' table with the following columns:
○ id (primary key)
○ title (string)
○ description (text)
○ due_date (datetime)
○ created_at (timestamp)
○ updated_at (timestamp) b. Create a corresponding Eloquent model for the
'tasks' table.
3. Task Management: a. Implement a feature to list all tasks in a paginated manner on
the homepage. b. Create a form to add new tasks with proper validation for required
fields. c. Implement the ability to edit and update existing tasks. d. Add a feature to
delete tasks (use soft deletes to retain data).
4. Authentication and User Management: a. Integrate Laravel's built-in authentication
system. b. Create a user profile page where users can update their profile
information (name and email). c. Ensure that only authenticated users can create,
update, and delete tasks.
5. Front-end: Implement basic CSS to style the web application and make it responsive