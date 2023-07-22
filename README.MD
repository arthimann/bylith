# Bylith Exam

### HTTP Server monitoring system

---

#### System Requirements

- PHP >= 8.2.6
- Mysql >= 8.0.33
- Composer >= 2.5.4

---

### Migration Option

1. Clone repo
2. Create DB and specify your connection details on `.env` file.
3. In project directory run:
   1. `composer install`
   2. `php artisan migrat`
   3. `php artisan db:seed`
4. Add new cronjob to your system: `* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
   `
5. All project's cronjob available by running command: `php artisan schedule:list`
6. Open new terminal window and run the process `php artisan queue:work` - DON'T KILL IT!
7. Open new terminal window and run `php artisan serve`
8. Make sure that your URL:port is correct in the POSTMAN!

#### DOT ENV FILE DB SECTION:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bylith
DB_USERNAME=root
DB_PASSWORD=
```

---

### Using DB Dump

You DB dump file located in the root project `bylith.sql`

1. Clone repo
2. Create DB and specify your connection details on `.env` file.
3. In project directory run:
    1. `composer install`
4. Add new cronjob to your system: `* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
5. All project's cronjob available by running command: `php artisan schedule:list`
6. Open new terminal window and run the process `php artisan queue:work` - DON'T KILL IT!
7. Open new terminal window and run `php artisan serve`
8. Make sure that your URL:port is correct in the POSTMAN!

---

### Configurations

You can modify number of retries or timeout simply by changing the following values in `.env` file:

```dotenv
WEBSERVICES_TIMEOUT=60
WEBSERVICES_RETRY=3
```

---

### Manually Run

You can run the process manually simple by using two terminal windows.
In the first terminal window make sure that you have running process:
```text
php artisan queue:work
```

In the second window the process manually:

```text
php artisan app:web-services-run
```

This process will add a task to the queue.
