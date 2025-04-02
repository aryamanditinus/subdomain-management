# Main Web Application

This project is a web application that allows users to log in, sign up, and create dynamic subdomains. It utilizes HTML, CSS, PHP, and MySQL for its functionality.

## Project Structure

- **public/**: Contains all publicly accessible files.
  - **index.html**: The landing page of the application.
  - **login.php**: Handles user login functionality.
  - **signup.php**: Manages user registration.
  - **dashboard.php**: Displays user-specific information and options for creating subdomains.
  - **css/**: Contains stylesheets for the application.
    - **styles.css**: CSS styles for layout and appearance.
  - **js/**: Contains JavaScript files for client-side functionality.
    - **scripts.js**: JavaScript code for form validation and AJAX requests.

- **config/**: Contains configuration files.
  - **db.php**: Database connection settings.

- **includes/**: Contains reusable PHP scripts.
  - **auth.php**: Functions for user authentication.
  - **create_subdomain.php**: Logic for creating dynamic subdomains.
  - **helpers.php**: Utility functions for various tasks.

- **sql/**: Contains SQL scripts.
  - **schema.sql**: SQL schema for creating necessary database tables.

## Setup Instructions

1. **Clone the repository** to your local machine.
2. **Set up a MySQL database** and import the `sql/schema.sql` file to create the necessary tables.
3. **Configure the database connection** in `config/db.php` with your database credentials.
4. **Set up Apache** to serve the application from the `public` directory.
5. **Enable mod_rewrite** for dynamic subdomain creation.
6. **Access the application** via your web browser at the configured domain.

## Usage Guidelines

- **Sign Up**: Navigate to `signup.php` to create a new account.
- **Log In**: Use `login.php` to access your account.
- **Dashboard**: After logging in, you will be redirected to `dashboard.php`, where you can manage your account and create subdomains. and you  can also attach your custom domain to that subdomain. automatic ssl will be setup for your custom domain. when you hit your custom domain , the request will be routed through proxcy to that subdomain and in your brwoser you will still be there on your custom domain.
- **Newest configuration**: there is a tar file "domain-management.tar.gz" . this one is the newest configuration .

## Notes

- Ensure that your server meets the requirements for running PHP and MySQL.
- Follow best practices for security, especially regarding password storage and user authentication.
