@extends('adminlte::page')
@section('title', 'FAQ')
@section('content_header')
    <h1 class="m-0 text-dark">Pertanyaan Yang Sering Diajukan</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5><b>Q : Bagaimana cara saya melakukan registrasi?</b></h5>
                    <h5>A : Anda dapat melakukan registrasi dengan klik Register pada halaman awal. Masukkan Nama, Email, Password (minimal 8), dan Konfirmasi Password.</h5><br>
                    <h5><b>Q : Apa saja role yang terdapat pada aplikasi ini?</b></h5>
                    <h5>A : Saat ini hanya role Admin dan role User yang ada pada aplikasi ini.</h5><br>
                    <h5><b>Q : Apa perbedaan antara role Admin dan role User?</b></h5>
                    <h5>A : Role Admin dapat melihat semua data yang diinput oleh user, mengelola semua data, 
                            sedangkan user hanya melihat data yang diinput oleh user sendiri, tidak dapat melihat data yang diisi user lainnya.</h5><br>
                    <h5><b>Q : Saat registrasi selesai, apakah role saya otomatis?</b></h5>
                    <h5>A : Ya, saat ini setelah registrasi, secara otomatis role anda adalah user.</h5><br>
                    <h5><b>Q : Apakah saya dapat melihat data yang diupload oleh user lainnya (Role user)?</b></h5>
                    <h5>A : Tidak. Demi mencegah manipulasi data, saat ini anda hanya dapat melihat data yang diupload oleh anda sendiri. Anda tidak dapat melihat data inputan user lain.</h5><br>
                    <h5><b>Q : Apakah saya dapat mengubah password?</b></h5>
                    <h5>A : Ya. Anda dapat mengubah password di menu Ubah Password. Masukkan password lama, password baru (minimal 8), dan konfirmasi password.
                            Password baru tidak bisa sama dengan password lama.</h5><br>
                    <h5><b>Q : Saya login sebagai role user, ketika saya buka halaman Permohonan Kerjasama, halamannya adalah 401. Mengapa?</b></h5>
                    <h5>A : Anda harus mengisi semua data pada menu ubah profil. Jika salah satu data ada yang kosong, baik dalam kondisi apapun, anda tidak dapat mengakses menu ini.</h5><br>
                    <h5><b>Q : Saya lupa password saya. Bagaimana saya bisa mereset password?</b></h5>
                    <h5>A : Klik "I forgot my password" di halaman login, kemudian masukkan email yang valid untuk reset passowrd.
                        Setelah menerima link, klik link yang diterima dari email untuk mengubah password tersebut.</h5><br>
                    <h5><b>Q : Saat menambah atau mengedit file, file apa saja yang diperbolehkan untuk diupload?</b></h5>
                    <h5>A : Semua jenis file yang tidak membahayakan, disarankan upload file berupa PDF. Batas maksimal file adalah 4 MB.</h5><br>
                    <h5><b>Q : Saya mencoba buka beberapa menu, tetapi redirect ke halaman 404. Mengapa?</b></h5>
                    <h5>A : Beberapa menu hanya dikhususkan buat untuk role admin, yang dimana role user tidak dapat melihat, menambah, atau mengedit data yang role nya admin,
                            demi mencegah manipulasi data.</h5><br>
                    <h5><b>Q : Apakah saya bisa mengimport dan mengekspor data ke dalam Excel?</b></h5>
                    <h5>A : Ya. Anda dapat mengimport dan mengekspor data ke dalam Excel. Saat ini hanya role admin yang dapat melakukannya.</h5><br>
                    <h5><b>Q : Saat mengedit data, terdapat menu upload berkas. Apakah saya dapat mengupdate data dengan berkas terbaru atau tanpa berkas?</b></h5>
                    <h5>A : Ya. Anda dapat mengupdate berkas atau mengupdate data tanpa berkas jika tidak ada perubahan data yang mau diupdate.</h5><br>
                    <h5><b>Q : Saya telah mengimport data, tetapi saya menemukan pesan error <span class="text-danger">"floor(): Argument #1 ($num) must be of type int|float, string given".</span> Mengapa?</b></h5>
                    <h5>A : Sebelum mengupload, pastikan format data sesuai contoh format saat Anda mengekspor, dan format tanggal adalah mm/dd/YYYY di file Excel yang akan diimport.</h5><br>
                    <h5><b>Q : Saya telah mendownload PDF, tetapi mengapa data saya berbeda pada data aslinya atau hanya sebagian data yang tertera saat buka file PDF?</b></h5>
                    <h5>A : Demi mencegah <i>table overlay</i>, hanya format kolom yang penting saja yang tertampil pada PDF.</h5><br>
                    <h5><b>Q : Saya login sebagai role user, apakah saya dapat mengimport dan mengekspor excel dan mencetak PDF?</b></h5>
                    <h5>A : Tidak. Saat ini user hanya role admin yang dapat mengimport dan mengekspor excel dan mencetak PDF.</h5><br>
                    <h5><b>Q : Saya login sebagai role admin, melihat notifikasi terlalu banyak. Apakah saya dapat <i>mark as read</i> untuk notifikasi tertentu atau <i>mark all as read</i> semua notifikasi?</b></h5>
                    <h5>A : Ya. Anda dapat menandai satu, sebagian atau semua notifikasi yang belum terbaca menjadi sudah terbaca.</h5><br>
                    <h5><b>Q : Apa fungsi tombol "Show", dan apa perbedaanya?</b></h5>
                    <h5>A : Tombol Show berfungsi untuk melihat rincian salah satu data yang sudah diinput oleh user.</h5><br>
                    <h5><b>Q : Apakah saya dapat mengupdate status kerjasama dan status permohonan kerjasama?</b></h5>
                    <h5>A : Ya. Kamu dapat mengupdate status kerjasama dan status permohonan kerjasama dengan klik tombol Approve atau Cancel pada bagian menu Opsi. Role user tidak dapat mengupdate status, hanya dapat melihat status kerjasama tersebut.</h5><br>
                    <h5><b>Q : Mengapa grafik pada saat data tertentu kosong tidak muncul?</b></h5>
                    <h5>A : Untuk menampilkan grafik pada halaman dashboard, minimal ada 1 data yang terinput.</h5><br>
                    <h5><b>Q : Pada halaman Kerjasama dan Permohonan Kerjasama, disebelah kanan terdapat menu Status. Apakah saya bisa mengubah status tanpa harus masuk ke halaman edit?</b></h5>
                    <h5>A : Ya. Kamu dapat mengubah status kerjasama dan permohonan kerjasama dengan menekan tombol <i>approve</i> atau <i>cancel</i> yang tertera pada menu tersebut, tetapi hanya berlaku untuk role admin.</h5><br>
                    <h5><b>Q : Mengapa warna notifikasi berbeda-beda dan apa klasifikasi warna tersebut?</b></h5>
                    <h5>A : Tujuan membedakan warna adalah untuk memberikan keterangan ketika user melakukan CRUD atau register. 
                            Warna abu-abu adalah registrasi oleh user, warna biru adalah <i>create</i> data, warna kuning adalah <i>update</i> data, warna merah adalah status kerjasama dan permohoan kerjasama perlu direvisi
                            warna hijau adalah status data kerjasama dan permohonan kerjasama sudah di acc.</h5><br>
                    <h5><b>Q : Apakah saya dapat melihat <i>value</i> dari grafik tersebut, dan bagaimana cara melihat nya?</b></h5>
                    <h5>A : Ya. Kamu dapat melihat <i>value</i> dari grafik tersebut, dengan mengarahkan atau klik pada warna grafik tersebut.</h5><br>
                    <h5><b>Q : Apakah saya dapat membuat user dengan 1 email tapi lebih banyak akun?</b></h5>
                    <h5>A : Tidak bisa. Satu email hanya untuk satu akun saja.</h5><br>
                </div>
            </div>
        </div>
    </div>
@stop