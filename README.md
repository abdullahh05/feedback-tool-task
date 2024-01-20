# **Feedback Tool**

A web-based Feedback Tool that allows users to submit and view feedback.

**Prerequisites**

Make sure you have a Laravel environment set up on your system. If Laravel is not installed, you can follow the official documentation for installation instructions.

**Getting Started**

1. Update the composer:

php artisan composer updatee

\*\*Note: Before running the migration, make sure to update your `.env` file with the correct database connection details.\*\*

1. Migrate the database:

php artisan migrate

php artisan migrate

1. Seed the database with initial data:

php artisan db:seed --class=OneTimeSeeder

1. Run the Laravel development server:

php artisan serve

artisan serve

Now, you're ready to use the Feedback Tool.

## Usage

### Register/Login

You can register or login to the system to access the full functionality of the Feedback Tool.

### Feedback Listing

View a paginated list of feedback entries. Each entry displays the feedback title, description, category, and the user who submitted it.

### Add Feedback

To add feedback, click on the "Add Feedback" button, It will take you to login page if not logged In already because you need to be logged in to submit feedback, Fill out the form with the feedback title, description, and select a category.

### View Comments

Click on the "Show Comments" button to view comments on a specific feedback entry. It displays the comment content, the user who added the comment, and the date and time when it was added.

### Add Comment

To add a comment to a feedback entry, click on the "Add Comment" button, It will take you to login page if not logged In already because you need to be logged in to submit comment, The form includes basic text formatting options

### Mention User

While adding a comment if you type '@' in the comment, it will provide a list of users that you can mention in your comment.
