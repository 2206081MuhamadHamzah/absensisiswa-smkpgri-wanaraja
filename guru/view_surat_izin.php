<!DOCTYPE html>
<html>
<head>
    <title>Daftar Surat Izin Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .guru-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .judul {
            text-align: center;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        td a {
            text-decoration: none;
            color: #3498db;
        }

        td a:hover {
            text-decoration: underline;
        }

        .approve-button, .reject-button {
            padding: 5px 10px;
            margin: 5px;
            background: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .approve-button:hover, .reject-button:hover {
            background: #258cd1;
        }
    </style>
</head>
<body>
    <div class="guru-container">
        <div class="judul">Daftar Surat Izin Siswa</div>
        <table>
            <tr>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Tanggal Izin</th>
                <th>Alasan Izin</th>
                <th>Bukti Izin</th>
                <th>Status Izin</th>
                <th>Action</th>
            </tr>
            <?php
            // Menghubungkan ke database
            $con = new mysqli("localhost", "root", "", "db_imas");

            if ($con->connect_error) {
                die("Koneksi ke database gagal: " . $con->connect_error);
            }
            session_start();
if (isset($_SESSION['id_siswa'])) {
    $idSiswaLogin = $_SESSION['id_siswa'];

            
    // Query untuk mengambil data surat izin beserta bukti izin sesuai dengan id siswa yang login
    $query = "SELECT si.id_surat_izin, s.nama_siswa, s.nis, si.tanggal_izin, si.alasan_izin, bi.file_path, si.status
    FROM surat_izin si
    INNER JOIN tb_siswa s ON si.id_siswa = s.id_siswa
    LEFT JOIN bukti_izin bi ON si.id_surat_izin = bi.id_surat_izin
    WHERE si.id_siswa = $idSiswaLogin";

$result = $con->query($query);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
  $idSuratIzin = $row["id_surat_izin"];
  $namaSiswa = $row["nama_siswa"];
  $nisSiswa = $row["nis"];
  $tanggalIzin = $row["tanggal_izin"];
  $alasanIzin = $row["alasan_izin"];
  $buktiIzin = $row["file_path"];
  $statusIzin = $row["status"];

  echo "<tr>
          <td>$namaSiswa</td>
          <td>$nisSiswa</td>
          <td>$tanggalIzin</td>
          <td>$alasanIzin</td>
          <td><a href='$buktiIzin' target='_blank'>Bukti Izin</a></td>
          <td>$statusIzin</td>
          <td class='action-buttons'>
              <button class='approve-button' onclick='approveIzin($idSuratIzin)'>Setujui</button>
              <button class='reject-button' onclick='rejectIzin($idSuratIzin)'>Tolak</button>
          </td>
        </tr>";
}
} else {
echo "Tidak ada surat izin yang diajukan.";
}
} else {
echo "Anda harus login sebagai siswa untuk mengakses halaman ini.";
}

// Tutup koneksi ke database
$con->close();
?>
            </table>
    </div>
</body>
</html>
