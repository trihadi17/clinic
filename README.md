### **Panduan Instalasi**
- Download code pada github, setelah itu extract
- Buka terminal atau Command Line, kemudian arahkan ke folder ***clinic***
- Jalankan perintah:
  ```
  composer install
  ```
- Langkah selanjutnya, jalankan perintah:
  ```
  php -r "copy('.env.example', '.env');";
  ```
- Kemudian, jalankan perintah:
  ```
  php artisan key:generate
  ```
- Buat database dengan nama ***clinic***
- Setelah itu, buka code pada Vscode. Sesuaikan parameter pada file **.env**, seperti berikut:
  ```
  APP_URL=http://localhost

  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=clinic
  DB_USERNAME=root
  DB_PASSWORD=
  ```
- Selanjutnya, jalankan perintah:
  ```
  php artisan migrate --seed
  ```
- Buka command line yang baru, jalankan perintah:
  ```
  php artisan serve
  ```
- Testing API menggunakan Postman
