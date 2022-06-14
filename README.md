# OPosts API - Laravel

Posts API, built with `Laravel 9` & `Laravel Sanctum`.

I would appreciate it if you consider giving me a star for this repo ⭐

## Database structure

### Posts

| Field name       | Type     |
|------------------|----------|
| id               | bigint   |
| title            | string   |
| slug             | string   |
| excerpt          | text     |
| body             | text     |
| cover            | text     |
| status           | string   |
| meta_title       | string   |
| meta_description | text     |
| meta_keywords    | text     |
| published_at     | datetime |
| created_at       | datetime |
| updated_at       | datetime |

### Categories

| Field name | Type   |
|------------|--------|
| id         | bigint |
| name       | string |
| slug       | string |
| parent_id  | bigint |

### Tags

| Field name | Type   |
|------------|--------|
| id         | bigint |
| name       | string |
| slug       | string |

### Comments

| Field name | Type     |
|------------|----------|
| id         | bigint   |
| name       | string   |
| phone      | string   |
| email      | text     |
| ip         | text     |
| user_agent | text     |
| status     | string   |
| body       | string   |
| created_at | datetime |
| updated_at | datetime |

### Relationships

- A post belongs to many categories
- A post belongs to many tags
- A post have many comments
- A category belongs to many posts
- A category have one parent
- A category have zero or many child
- A tag belongs to many posts
- A comment belong to one post

## Requirements

- PHP > 8.1
- Laravel 9
- PostgreSQL (or any supported DBMS)

## Installation

- Clone the repository

```
git clone https://github.com/omaghd/oposts-api-laravel-sanctum.git oposts
```

- Change directory to the project

```
cd oposts
```

- Install the dependencies

```
composer install 
```

- Copy .env file

```
cp .env.example .env
```

- Generate new application key

```
php artisan key:generate
```

- **After creating a database (e.g. posts_api)**, change database info in .env file

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=posts_api
DB_USERNAME=postgres
DB_PASSWORD=password
```

- Migrate & Seed the database

```
php artisan migrate:fresh --seed
```

- Run the application

```
php artisan serve
```

## User credentials

After the database seeding, the default user credentials are:

```
Email : user@user
Password : password
```

## Usage

### Postman

If you use Postman, you can
import [this ready collection](https://www.omaghd.com/projects/laravel/oposts/collection.json), I made it for you for
free ;)

Preview:
![Postman Collection](https://www.omaghd.com/projects/laravel/oposts/postman-collection.png "Postman Collection")

### For public routes

You can send the HTTP requests to the [public endpoints](#public-routes) to get responses.

### For protected routes

After [generating a token](#authentication-1), you need to copy the generated token and send it for authorization as a
Bearer token in the request header.

## Routes

### Public Routes

#### Authentication

```
POST            api/v1/auth .................................................... AuthController@auth  
```

#### Posts

```
GET|HEAD        api/v1/posts .................................... posts.index › PostController@index  
GET|HEAD        api/v1/posts/{post} ............................... posts.show › PostController@show  
GET|HEAD        api/v1/post/{id}/categories ......................... PostCategoriesController@index  
GET|HEAD        api/v1/post/{id}/tags ..................................... PostTagsController@index  
GET|HEAD        api/v1/post/{id}/comments ................................... PostCommentsController  
```

#### Comments

```
GET|HEAD        api/v1/comments ........................... comments.index › CommentController@index  
POST            api/v1/comments ........................... comments.store › CommentController@store  
GET|HEAD        api/v1/comments/{comment} ................... comments.show › CommentController@show  
```

#### Tags

```
GET|HEAD        api/v1/tags ....................................... tags.index › TagController@index  
GET|HEAD        api/v1/tags/{tag} ................................... tags.show › TagController@show  
GET|HEAD        api/v1/tag/{id}/posts ..................................... TagPostsController@index  
```

### Protected Routes

#### Authentication

```
POST            api/v1/logout ................................................ AuthController@logout  
```

#### Posts

```
POST            api/v1/posts .................................... posts.store › PostController@store  
PUT|PATCH       api/v1/posts/{post} ........................... posts.update › PostController@update  
DELETE          api/v1/posts/{post} ......................... posts.destroy › PostController@destroy  
GET|HEAD        api/v1/trashed/posts ..................................... PostController@getTrashed  
PATCH           api/v1/restore/post/{id} .................................... PostController@restore  
PATCH           api/v1/post/{postId}/category/{categoryId} ......... PostCategoriesController@attach  
DELETE          api/v1/post/{postId}/category/{categoryId} ......... PostCategoriesController@detach  
PATCH           api/v1/post/{postId}/tag/{tagId} ......................... PostTagsController@attach  
DELETE          api/v1/post/{postId}/tag/{tagId} ......................... PostTagsController@detach  
```

#### Comments

```
DELETE          api/v1/comments/{id} ..................................... CommentController@destroy  
PATCH           api/v1/comments/{id}/approve ............................. CommentController@approve  
PATCH           api/v1/comments/{id}/disapprove ....................... CommentController@disapprove  
```

#### Tags

```
POST            api/v1/tags ....................................... tags.store › TagController@store  
PUT|PATCH       api/v1/tags/{tag} ............................... tags.update › TagController@update  
DELETE          api/v1/tags/{tag} ............................. tags.destroy › TagController@destroy  
PATCH           api/v1/tag/{tagId}/post/{postId} ......................... TagPostsController@attach  
DELETE          api/v1/tag/{tagId}/post/{postId} ......................... TagPostsController@detach  
```

## Author

| Website  | [omaghd.com](https://omaghd.com)             |
|----------|----------------------------------------------|
| LinkedIn | [/in/omaghd](https://linkedin.com/in/omaghd) |
| Twitter  | [/omaghd](https://twitter.com/OmaghD)        |
| GitHub   | [/omaghd](https://github.com/omaghd)         |

## License

This project is [MIT licensed](https://choosealicense.com/licenses/mit/).

Kindly give me a credit if you're going to use this project somewhere ❤️
