<!DOCTYPE html>
<html>
<head>
    <title>Form Pengajuan Surat Izin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .surat-container {
            max-width: 600px;
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

        .form-content {
            margin-top: 20px;
        }

        .label {
            font-weight: bold;
        }

        .field {
            border-bottom: 1px solid #ccc;
            padding: 5px 0;
        }

        .alasan {
            font-style: italic;
        }

        input[type="date"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            background: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #258cd1;
        }
    </style>
</head>
<body>
    <div class="surat-container">
        <div class="judul">Form Pengajuan Surat Izin</div>
        <div class="form-content">
            <form method="post" action="proses_pengajuan.php" enctype="multipart/form-data">
                <div class="field">
                    <div class="label">Tanggal Izin:</div>
                    <input type="date" name="tanggal_izin" required>
                </div>
                <div class="field">
                    <div class="label">Alasan Izin:</div>
                    <textarea name="alasan_izin" rows="4" class="alasan" required></textarea>
                </div>
                <div class="field">
                    <div class="label">Bukti Surat Izin:</div>
                    <input type="file" name="bukti_izin" accept="image/*, application/pdf" required>
                </div>
                <input type="submit" value="Kirim Pengajuan">
            </form>
        </div>
    </div>
</body>
</html>
