# Budget Management System

This PHP web application is a simple budget management system designed to track expenses and incomes. It utilizes a MySQL database to store information and provides a user-friendly interface for data entry and visualization.

## Features

- **Database Structure:**
  - The application's information system is based on several tables in a relationship, including `accounting`, `categories`, `payments`, and `transactions`.

- **HTML Forms:**
  - HTML forms are provided for entering data, allowing users to add new transactions with details such as date, amount, description, category, and payment method.

- **Data Storage:**
  - User-entered data is stored in the corresponding tables in the MySQL database.

- **Queries and Display:**
  - The application supports queries on several tables in a relationship, displaying results in tables or graphs.

## Installation

1. Set up a MySQL database and import the provided SQL schema (`database/maarif_alizade.sql`).
2. Update the config file(s) with your database credentials.
3. Host the application on a PHP-enabled server.

## Usage

1. Access the application through a web browser.
2. Use the provided HTML forms to enter new transactions.
3. View and analyze your financial data through the transaction display or graphical representation.

## Technologies Used

- **Frontend:**
  - HTML, CSS
  - JavaScript
  - jQuery UI, Bootstrap

- **Backend:**
  - PHP

- **Database:**
  - MySQL


## Contributing

Contributions are welcome! Feel free to open issues or pull requests for improvements.
