# Laravel 9 + Admin LTE

Project Daftar Kerja Sama dengan AdminLTE v3.

# Bagaimana cara menjalankan project ini?
- Jalankan ```composer install``` (jika tidak memiliki composer)
- Silahkan copy ```.env.example``` menjadi ```.env```. Contoh penggunaan command linux ```cp .env.example .env```
- Silahkan isi yang valid di variabel env pada DB_DATABASE, DB_USERNAME, dan DB_PASSWORD dengan konfigurasi yang kamu punya
- Jalankan ```php artisan key:generate``` untuk membuat unique key aplikasi
- Jalankan ```php artisan storage:link``` untuk membuat symlink direktori.
- Jalankan server dengan ```php artisan serve```
- Jika ingin mengubah nama database, username, password, pada .env, disarankan jalankan ```php artisan config:cache``` dan ```php artisan cache:clear```, untuk mereset ulang konfigurasi

# Setelah saya menjalankan server dengan php artisan serve, css pada AdminLTE saya tidak loading. Apa yang harus saya lakukan?
- Jalankan ```composer require jeroennoten/laravel-adminlte``` untuk melakukan instalasi package laravel-adminlte
- Jalankan ```php artisan adminlte:install```
- Jalankan ```composer require laravel/ui``` untuk instalasi laravel UI
- Jalankan ```php artisan ui bootstrap --auth``` untuk meng-generate file controller dan view blade yang akan menangani otentikasi seperti login, register, forget password, dan lain-lain.
- Lanjutkan dengan ```npm install``` untuk menginstall package npm dan ```npm run dev``` untuk compile
- Buat file webpack.mix.js dan ketik source code dibawah ini
- Jalankan migrasi ```php artisan migrate```
- Ganti view blade login, register, dan lupa password, konfirmasi email ke dalam tampilan blade adminlte ```php artisan adminlte:install --only=auth_views```, kemudian ketik **Yes** jika muncul perintah di bawah ini:
*The authentication views already exists. Want to replace the views? (yes/no) [no]:*

# Saya sudah mengikuti prosedur di bawah ini, tetapi saya tidak bisa melakukan login dan/atau belum memiliki user. Apa yang harus saya lakukan?
- Klik register dan masukkan Nama, Email, Password (min:8) dan Konfirmasi Password.

# Informasi tambahan
- Setelah mengikuti instalasi seperti yang di atas, user wajib menjalankan perintah di bawah ini
```php artisan db:seed ```
- Dengan menjalankan code di atas, maka terdapat sample data yang tertera pada database.
- Fungsi ```MainAccountSeeder``` adalah untuk membuat sample user jika tidak ada data user.

# Pertanyaan Yang Sering Diajukan

# Saat saya login pertama kali, tampilan grafik masih kosong. Mengapa?
- Data Kerjasama saat ini kosong, dan user perlu menambahkan data kerjasama tersebut.

# Apa perbedaan antara role admin dan role user?
- Perbedaannya adalah role admin dapat menambah, edit, dan menghapus semua jenis modul, sedangkan role user dan lainnya, hanya dapat menambahkan data permohonan kerja sama, user tidak dapat menambah user, role, mengedit data yang sudah dibuat. User tidak dapat menghapus file tersebut.

# Saya adalah user yang login menggunakan role user. Mengapa sebagian menu <i>redirect</i> ke halaman 404?
- Tujuannya adalah untuk tidak mengganggu data yang dibuat oleh user lainnya.

# Apakah saya dapat menambahkan role selain admin dan user?
- Ya. Anda dapat menambahkan role lainnya sesuai keinginan anda.

# Saya telah mengupload berkas atau gambar tertentu, tetapi mengapa tidak muncul di halaman index?
- Pastikan file yang Anda upload sesuai dengan requirement yang di atas.

# Saya sudah login sebagai user, ketika saya akses ke halaman permohonan kerjasama, otomatis redirect ke halaman 401. Apa yang harus saya lakukan?
- Anda perlu mengisi semua biodata pada menu ```/change-profile```. Jika setelah disimpan ada satu data yang kosong, maka Anda tidak dapat mengakses ke menu tersebut.

# Saya telah mendownload file, tetapi file tersebut kosong. Mengapa?
- Anda tidak mengupload file, atau file yang Anda upload bersifat <i>corrupted</i>, alias tidak bisa terpakai, atau Anda lupa menjalankan ```php artisan storage:link``` untuk menyimpan berkas yang Anda upload.

# Ketika saya mencoba download file di user guide, file nya kosong. Mengapa?
- Disarankan Anda menjalankan ```php artisan storage:link```, sehingga dapat menampung file yang telah diupload oleh user tersebut.

# Saya telah mengupload file, setelah saya melakukan ```php artisan storage:link```, file saya tidak tersimpan dalam folder public. Mengapa?
- Pada beberapa source code yang menggunakan gambar, ubah ```$path = $request->file('filename')->storeAs('namafolder', $newFilename);``` menjadi ```$path = $request->file('filename')->storeAs('public/namafolder', $newFilename);```, sehingga file tersebut tersimpan pada folder public.

# Apakah saya dapat mengganti logo AdminLTE?
- Ya. Kamu dapat mengganti logo tersebut. Saat ini hanya melalui backend untuk mengganti logo. 

# Saya telah mengganti icon adminlte menjadi logo lain, tetapi logo tersebut masih logo lama. Apa yang harus saya lakukan?
- Pastikan untuk membersihkan semua konfigurasi dengan menjalankan ```php artisan config:cache```, ```php artisan config:clear```, dan ```php artisan config:clear``` untuk mereset konfigurasi tersebut.

# Referensi
[1](https://www.cafeteria.id/2022/02/cara-integrasi-laravel-9-dengan-laravel.html)
[2](https://github.com/zaLabs02/Laravel-9-AdminLTE/blob/master/README.md?plain=1)
