# BlogAPI

This is a REST API to handle requests for a blog post, including the ability to create, read, update, and delete posts and post categories. The API documentation is also provided.

## Getting started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

To use this REST API, you need to have the following installed:

- [ ] PHP version 8.0 or higher
- [ ] MySQL or any other supported database management system
- [ ] Composer dependency manager

### Installation

1. Clone or download the source code for the REST API from the GitHub repository.
2. Run ```composer install``` in the project directory to install the required dependencies.
3. Create a new MySQL database and name ti "blog_api_db".
4. Copy the .env.example file to .env file and modify the settings to match your database configuration.
    ```
    DB_HOST= localhost
    DB_NAME= blog_api_db
    DB_USER= <my_app_user>
    DB_PASS= <my_app_password>
    ```
5. Run ```php database/create-db.php``` in the project directory to create the tables for db

## Usage

Run ```php -S localhost:8000 -t public``` in the project directory
This will start a local development server at http://localhost:8000. 
You can use any REST API client, such as Postman or Insomnia, to interact with the API.

### The available endpoints are:

#### Posts
* POST /v1/posts/create: ***Creates a new post.***
* GET /v1/posts: ***Returns a list of all posts.***
* GET /v1/posts/{slug}: ***Returns a specific post by its slug.***
* PUT /v1/posts/update/{slug}: ***Updates an existing post.***
* DELETE /v1/posts/delete/{slug}: ***Deletes an existing post.***

#### Categories
* POST /v1/categories/create: ***Creates a new category.***
* GET /v1/categories: ***Returns a list of all categories.***
* GET /v1/categories/{id}: ***Returns a specific category by its ID.***
* PUT /v1/categories/update/{id}: ***Updates an existing category.***
* DELETE /v1/categories/delete/{id}: ***Deletes an existing category.***

### API Documentation
The API documentation is generated using the Swagger PHP library and is available at http://localhost:8000/api-docs/. 
The documentation includes details on the available endpoints, parameters, and responses.

### Database Table Structure
The tables in the database contain the following fields:

#### Posts
* ***post_id:*** The unique identifier for each post.
* ***title:*** The title of the post.
* ***slug:*** The slug for the post URL.
* ***content:*** The content of the post.
* ***thumbnail:*** The URL of the thumbnail image for the post.
* ***author:*** The author of the post.
* ***posted_at:*** The date and time when the post was posted.

#### Categories
* ***category_id:*** The unique identifier for each category.
* ***name:*** The name of the category.
* ***description:*** The description of the category.

#### Posts Categories
* ***post_id:*** The unique identifier for the post.
* ***category_id:*** The unique identifier for the category.

### Base64 Encoded Image 
This is a picture that you can use for thumbnails:
* iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAIAAADTED8xAAADMElEQVR4nOzVwQnAIBQFQYXff81RUkQCOyDj1YOPnbXWPmeTRef+/3O/OyBjzh3CD95BfqICMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMO0TAAD//2Anhf4QtqobAAAAAElFTkSuQmCC

Example:
```
{
	"title": "title",
	"content": "content",
	"thumbnail": "iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAIAAADTED8xAAADMElEQVR4nOzVwQnAIBQFQYXff81RUkQCOyDj1YOPnbXWPmeTRef+/3O/OyBjzh3CD95BfqICMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMK0CMO0TAAD//2Anhf4QtqobAAAAAElFTkSuQmCC",
	"author": "author",
	"categories": [ 
		{"id": "ab7387d3-fc0f-4950-875f-9ef799aeb0b9"}
	]
}
```

## Conclusion
This REST API provides the necessary functionality for a blog post. 
It includes creating, reading, updating, and deleting posts and post categories. 
With the provided database table structure and API documentation, it is easy to integrate this API with a front-end web application.




