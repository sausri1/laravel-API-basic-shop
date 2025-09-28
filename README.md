<h1>Laravel API Basic Shop</h1>

A simple Laravel store API running in Docker containers. The project is divided into 3 main parts
- `collection`- postman requests collection;
- `deploy` - Docker configuration for containerization;
- `project` - Laravel app.
  
The API is a regular online store where you can register as a customer, add products to your cart, and place an order.
  The administrator can add products, modify them, and delete them.
Containers:
- php:8.4.12-fpm
- nginx
- PostgreSQL
- PGAdmin
- redis

<h2>Start with Docker</h2>
- copy from deploy to project;
- in the terminal, in the project folder, write:
    - `docker-compose up -d` (create container);
    - `Docker exec laravel-container cp .env.example .env` (copy from `.env.example` to `.env`);
    - `Docker exec laravel-container composer install`;
    - `Docker exec laravel-container php artisan key:generate`;
    - `Docker exec laravel-container php artisan migrate`;

  After executing these commands, you can go to `http://localhost to make sure everything worked. You will see the Laravel start page.

By default, PostgreSQL in the container is used as the database.

<h2>Working with the API</h2>
To work with the API, you must send requests in JSON format. Applications such as Postman and Bruno are used for this purpose.

To make the automatic recording of the user's token work, create an environment (or add it) with the `TOKEN` variable and use this environment.

The **Postman** query collection can be found in the `collection` folder.

For **Bruno**, import, however, to automate adding the token value, you will have to add it to the environment yourself and **remove all scripts in the requests**

<h3>Filling basic data into the database</h3>
- Users: `php artisan db:seed --class=UserSeeder`
    - Client
        - 'fio': 'Test Client'
        - 'email': 'user@shop.ru'
        - 'password': 'password'
    - Administrator
        - 'fio': 'Test Admin'
        - 'email': 'admin@shop.ru'
        - 'password': 'password'

- Products: php artisan db:seed --class=ProductSeeder

<h3>Create administrator</h3>
Create a new user using a json request, and you should get the user's `id`.
Register in the terminal:
`Docker exec laravel-container php artisan app:adminstatus {id пользователя}, {0 - client, 1 - administrator}`

<h2>Postman collection</h2>
There are 3 roles: guest, client, administrator
Next, the features for each role are written, as well as a request from the postman collection (in the collection folder) in the form of the name of this request.
- Guest can:
    - view products `product_get_all`
    - view a specific product `product_show`
      <br><br>

    - sign up `sign_up`
    - login `login`
      <br><br>

- Client can:
    - the same as the guest (you probably won't need to register again, but it's possible)
      <br><br>

    - logout `logout`
    - update profile `update_profile`
      <br><br>

    - add product to cart  `cart_add_product`
    - view the cart `cart_get`
    - delete any product from the cart `cart_delete`
      <br><br>

    - place an order (the shopping cart will be emptied) `create_order`
    - see the order history `get_orders`
      <br><br>

- Administrator can:
    - the same as the client
      <br><br>
    - add product `product_add`
    - update product `product_update`
    - delete product `product_delete`
