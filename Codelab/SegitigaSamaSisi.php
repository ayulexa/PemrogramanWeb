<!DOCTYPE html>
<html>
<head>
    <title>Segitiga Bintang Sama Sisi</title>
    <style>
        pre {
            font-family: monospace;
            font-size: 16px;
            line-height: 1.2;
        }
    </style>
</head>
<body>
    <?php
    function printSegitigaSamaSisi($tinggi) {
        echo "<pre>";
        // Loop untuk setiap baris
        for ($i = 1; $i <= $tinggi; $i++) {
            // Cetak spasi untuk rata tengah
            for ($j = 1; $j <= ($tinggi - $i); $j++) {
                echo " ";
            }
            
            // Cetak bintang
            for ($k = 1; $k <= $i; $k++) {
                echo "* ";
            }
            
            // Pindah ke baris baru
            echo "\n";
        }
        echo "</pre>";
    }

    // Panggil fungsi dengan tinggi 7 baris
    printSegitigaSamaSisi(7);
    ?>
</body>
</html>