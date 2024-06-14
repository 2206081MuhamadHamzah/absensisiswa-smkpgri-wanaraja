<?php
// Menghubungkan ke database
$con = new mysqli("localhost", "root", "", "db_imas");

if ($con->connect_error) {
    die("Koneksi ke database gagal: " . $con->connect_error);
}

// Periksa apakah data dari formulir telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $tanggalIzin = $_POST["tanggal_izin"];
    $alasanIzin = $_POST["alasan_izin"];

    // Mengambil informasi file bukti izin yang diunggah
    $fileBuktiIzin = $_FILES["bukti_izin"];

    // Periksa apakah file bukti izin telah diunggah
    if ($fileBuktiIzin["error"] == UPLOAD_ERR_OK) {
        // Mendapatkan nama file yang diunggah
        $fileName = $fileBuktiIzin["name"];
        
        // Simpan file bukti izin ke direktori yang diinginkan
        $uploadDirectory = "uploads/";
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
        // Ganti dengan direktori yang sesuai
        $targetFilePath = $uploadDirectory . $fileName;
        move_uploaded_file($fileBuktiIzin["tmp_name"], $targetFilePath);

        // Simpan data surat izin ke tabel surat_izin
        $query = "INSERT INTO surat_izin (id_siswa, tanggal_izin, alasan_izin, status) VALUES (1, '$tanggalIzin', '$alasanIzin', 'Menunggu')"; // Ganti id_siswa sesuai dengan id siswa yang sedang login
        $con->query($query);

        // Simpan data bukti izin ke tabel bukti_izin
        $idSuratIzin = $con->insert_id;
        $query = "INSERT INTO bukti_izin (id_surat_izin, file_path) VALUES ($idSuratIzin, '$targetFilePath')";
        $con->query($query);

        echo "Surat izin berhasil diajukan!";
    } else {
        echo "Gagal mengunggah file bukti izin.";
    }
}

// Tutup koneksi ke database
$con->close();
?>
