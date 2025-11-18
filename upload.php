<?php
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    // Mendapatkan informasi file
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];

    // Validasi apakah file CSV
    if ($fileType == 'text/csv') {
        // Menyimpan file ke direktori sementara
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadPath = $uploadDir . basename($fileName);
        
        // Memindahkan file ke folder
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            echo "File berhasil di-upload: " . $fileName . "<br>";

            // Membaca file CSV dan menampilkan isinya
            if (($handle = fopen($uploadPath, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    echo 'Nomor WhatsApp: ' . $data[0] . ' - Pesan: ' . $data[1] . '<br>';
                    // Di sini kamu bisa menambahkan logika untuk mengirim pesan via WhatsApp
                }
                fclose($handle);
            }
        } else {
            echo "Terjadi kesalahan saat meng-upload file.";
        }
    } else {
        echo "Hanya file CSV yang diperbolehkan.";
    }
} else {
    echo "File tidak di-upload atau terjadi kesalahan.";
}
?>
