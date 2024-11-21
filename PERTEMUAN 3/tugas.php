<!--Nama      : Arya Ajisadda Haryanto
    NIM       : 24060122140118
    Deskripsi : Pertemuan 3 Pemrosesan Form -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .error {
            color: red;
            font-size: 12px;
        }
        #ekstrakurikuler-section {
            display: none;
        }
    </style>
</head>
<body>

<?php
$ekstrakurikuler_options = ["Pramuka", "Seni Tari", "Sinematografi", "Basket"];
if (isset($_POST['submit'])) {
    // Validasi NIS
    $nis = test_input($_POST['nis']);
    if (empty($nis)) {
        $error_nis = "NIS harus diisi";
    } elseif (!preg_match("/^[0-9]{10}$/", $nis)) {
        $error_nis = "NIS harus 10 angka";
    }

    // Validasi Nama
    $nama = test_input($_POST['nama']);
    if (empty($nama)) {
        $error_nama = "Nama harus diisi";
    }

    // Validasi Jenis Kelamin
    if (empty($_POST['jenis_kelamin'])) {
        $error_jenis_kelamin = "Jenis kelamin harus diisi";
    }

    // Validasi Kelas
    $kelas = $_POST['kelas'];
    if (empty($kelas)) {
        $error_kelas = "Kelas harus diisi";
    } elseif ($kelas == "X" || $kelas == "XI") {
        // Validasi Ekstrakurikuler
        if (!isset($_POST['ekstrakurikuler'])) {
            $error_ekstrakurikuler = "Pilih minimal 1 ekstrakurikuler";
        } else {
            $ekstrakurikuler = $_POST['ekstrakurikuler'];
            if (count($ekstrakurikuler) < 1 || count($ekstrakurikuler) > 3) {
                $error_ekstrakurikuler = "Pilih minimal 1 dan maksimal 3 ekstrakurikuler";
            }
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<div class="container mt-3 ms-2"> 
    <div class="row ">
        <div class="col-md-6"> 
            <div class="card"> 
                <div class="card-header">
                    <p class="mb-0">Form Input Siswa</p> 
                </div>
                
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="on">
                        <!-- NIS -->
                        <div class="form-group mb-3">
                            <label for="nis">NIS: </label>
                            <input type="text" class="form-control" id="nis" name="nis" maxlength="10" value="<?php echo $nis; ?>">
                            <div class="error"><?php if(isset($error_nis)) echo $error_nis; ?></div>
                        </div>

                        <!-- Nama -->
                        <div class="form-group mb-3">
                            <label for="nama">Nama: </label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                            <div class="error"><?php if(isset($error_nama)) echo $error_nama; ?></div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <label>Jenis Kelamin: </label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="Pria" <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Pria') echo 'checked'; ?>>Pria
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="Wanita" <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Wanita') echo 'checked'; ?>>Wanita
                            </label>
                        </div>
                        <div class="error"><?php if(isset($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>

                        <!-- Kelas -->
                        <div class="form-group mb-3">
                            <label for="kelas">Kelas:</label>
                            <select id="kelas" name="kelas" class="form-control" onchange="toggleEkstrakurikuler()">
                                <option value="">Pilih Kelas</option>
                                <option value="X" <?php if($kelas == 'X') echo 'selected'; ?>>X</option>
                                <option value="XI" <?php if($kelas == 'XI') echo 'selected'; ?>>XI</option>
                                <option value="XII" <?php if($kelas == 'XII') echo 'selected'; ?>>XII</option>
                            </select>
                            <div class="error"><?php if(isset($error_kelas)) echo $error_kelas; ?></div>
                        </div>

                        <!-- Ekstrakurikuler (hanya untuk kelas X dan XI) -->
                        <div id="ekstrakurikuler-section">
                            <label>Ekstrakurikuler:</label>
                            <?php foreach ($ekstrakurikuler_options as $option): ?>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="<?php echo $option; ?>" 
                                        <?php if (isset($_POST['ekstrakurikuler']) && in_array($option, $_POST['ekstrakurikuler'])) echo 'checked'; ?>>
                                        <?php echo $option; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            <div class="error"><?php if(isset($error_ekstrakurikuler)) echo $error_ekstrakurikuler; ?></div>
                        </div>

                        <br>

                        <!-- Submit dan Reset buttons -->
                        <button type="submit" class="btn btn-success" name="submit" value="submit">Submit </button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>  

    <?php
    if (isset($_POST["submit"]) && empty($error_nama) && empty($error_email) && empty($error_alamat) && empty($error_kota) && empty($error_jenis_kelamin) && empty($error_minat)) {
        echo "<h3>Your Input:</h3>";
        echo 'NIS = ' . $nis . '<br />';
        echo 'Nama = ' . $nama . '<br />';
        echo 'Jenis Kelamin = ' . $_POST['jenis_kelamin'] . '<br />';
        echo 'Kelas = ' . $kelas . '<br />';
        
        if (!empty($_POST['ekstrakurikuler'])) {
            echo 'Ekstrakurikuler yang dipilih: ';
            foreach ($_POST['ekstrakurikuler'] as $minat_item) {
                echo '<br />' . $minat_item;
            }
        }
    }
    ?>
</div>

<!-- Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
<script>
    function toggleEkstrakurikuler(){
        var kelas = document.getElementById("kelas").value;
        var ekstrakurikulerSection = document.getElementById("ekstrakurikuler-section");

        if (kelas === "X" || kelas === "XI"){
            ekstrakurikulerSection.style.display = "block";
        } else {
            ekstrakurikulerSection.style.display = "none";
        }
    }

    window.onload = function(){
        toggleEkstrakurikuler();
    }
</script>
</body>
</html>