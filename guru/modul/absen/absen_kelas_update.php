<?php
$kelasMengajar = mysqli_query($con, "SELECT * FROM tb_mengajar
    INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel=tb_master_mapel.id_mapel
    INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas
    INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
    INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
    WHERE tb_mengajar.id_guru='$data[id_guru]' AND tb_mengajar.id_mengajar='$_GET[pelajaran]' AND tb_thajaran.status=1");

while ($d = mysqli_fetch_assoc($kelasMengajar)) {
?>
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs" style="font-weight: bold;">
                <li class="nav-home">
                    <a href="#">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">KELAS (<?= strtoupper($d['nama_kelas']) ?> )</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#"><?= strtoupper($d['mapel']) ?></a>
                </li>
            </ul>
        </div>
        <div class="table-container">
            <form action="" method="post">
			<style>
   body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .table-container {
        max-height: 400px; /* Atur tinggi maksimal sesuai preferensi Anda */
        overflow: auto;
    }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        

</style>
                <input type="hidden" name="pertemuan" class="form-control" value="<?= $pertemuan; ?>">
                <input type="hidden" name="pelajaran" value="<?= $_GET['pelajaran'] ?>">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
$index = 1; // Initialize a counter
$tgl_hari_ini = date('Y-m-d');
$siswa = mysqli_query($con, "SELECT * FROM _logabsensi 
    INNER JOIN tb_siswa ON _logabsensi.id_siswa=tb_siswa.id_siswa 
    WHERE _logabsensi.tgl_absen='$tgl_hari_ini' AND _logabsensi.id_mengajar='$_GET[pelajaran]' 
    ORDER BY _logabsensi.id_siswa ASC");
$jumlahSiswa = mysqli_num_rows($siswa);

if ($jumlahSiswa > 0) {
    foreach ($siswa as $s) {
        ?>
        <tr>
            <td><?= $index++; ?></td> <!-- Display the incremented index -->
            <td>
                <b class="text"><?= $s['nama_siswa']; ?></b>
                <?php if ($s['ket'] == '') {
                    echo "<span class='text-danger'>Belum Absen</span>";
                } ?>
            </td>
            <td>
                <input type="hidden" name="id_siswa[]" value="<?= $s['id_siswa']; ?>">
                <select name="ket[]" class="form-control">
                    <option value="H" <?= ($s['ket'] == 'H') ? 'selected' : ''; ?>>Hadir</option>
                    <option value="I" <?= ($s['ket'] == 'I') ? 'selected' : ''; ?>>Izin</option>
                    <option value="S" <?= ($s['ket'] == 'S') ? 'selected' : ''; ?>>Sakit</option>
                    <option value="A" <?= ($s['ket'] == 'A') ? 'selected' : ''; ?>>Absen</option>
                </select>
            </td>
        </tr>
        <?php
    }
}
?>

                    </tbody>
                </table>
                <center style="margin-top: 20px;">
                    <button type="submit" name="update" class="btn btn-success">
                        <i class="fa fa-check"></i> Update Absensi
                    </button>
                    <a href="javascript:history.back()" class="btn btn-default"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                </center>
            </form>
        </div>
    </div>
<?php
}
?>

<?php
if (isset($_POST['update'])) {
    $total = count($_POST['id_siswa']);
    $pertemuan = $_POST['pertemuan'];
    $hari_sekarang = date('Y-m-d');
    for ($i = 0; $i < $total; $i++) {
        $id_siswa = $_POST['id_siswa'][$i];
        $pelajaran = $_POST['pelajaran'];
        $ket = $_POST['ket'][$i];

        $updte_absen = mysqli_query($con, "UPDATE _logabsensi SET ket='$ket' WHERE id_mengajar='$pelajaran' AND id_siswa='$id_siswa' AND tgl_absen='$hari_sekarang'");

        if ($updte_absen) {
            echo "
            <script type='text/javascript'>
                setTimeout(function () { 
                    swal('Berhasil', 'Absensi Telah berubah', {
                        icon: 'success',
                        buttons: { confirm: { className: 'btn btn-success' } }
                    });
                }, 10);
                window.setTimeout(function(){ 
                    window.location.replace('?page=absen&act=update&pelajaran=$_GET[pelajaran]');
                }, 3000);
            </script>";
        }
    }
}
?>
