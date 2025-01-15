# YOUTH Platform

Youth Oriented Unified Transparency Hub Platform

---
## Development Setup
Here are the steps to set up the development environment for this project:

1. Open Windows Powershell (run as administrator) and copy then paste this command:
    ```sh
    Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
    ```

    the command above is to install the PHP, Composer, and the Laravel installer on Windows, you should restart your terminal.

2. Download and install
   [XAMPP](https://www.apachefriends.org/download.html)
   and [NodeJS](https://nodejs.org/en/),
   if you haven't already.

3. Start Apache and MySQL through XAMPP if not already running.

4. Clone or download this repository to your XAMPP **htdocs** folder.
   The final path should be `path_to/xampp/htdocs/youth`.

5. Copy [**`app/config/database.example.php`**](app/config/database.example.php)
   to **`app/config/database.php`**, then modify the database connection settings in the new file.

6. Inside [phpMyAdmin](http://localhost/phpmyadmin),
   create a MySQL database named `youth` and import [youth.sql](youth.sql) into it.

7. Open the terminal and navigate to the project directory **youth**.

8. Execute the following commands to install the required dependencies:
   ```sh
   npm install
   ```

9. Compile and run the development server with hot reloading:
   ```sh
   npm run dev
   ```

10. Open your web browser and access <http://localhost:5173> to view the application.
---

### Writing Tests
To write your tests, simply add your **Unit Tests** to the
[tests/**unit**](tests/unit) directory
and your ***Feature Tests*** to the
[tests/**feature**](tests/feature) directory.

### Running Tests
1. Open a terminal window and navigate to the root directory of the project.
2. Run the following command to execute your tests:

   - *all tests*
   ```shell
   phpunit
   ```
   - *unit tests only*
   ```shell
   phpunit --testsuite unit
   ```
   - *feature tests only*
   ```shell
   phpunit --testsuite feature
   ```
   
   If `phpunit` command does not work, try running `vendor\bin\phpunit` instead.


---

## License

The YOUTH platform software is licensed under the [MIT license](https://opensource.org/licenses/MIT).
