<?php include "header.php"; ?>

<?php

if (isset($_POST['bsimpan'])) {
    $tgl = date('Y-m-d');

    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
    $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES);
    $pejabat = htmlspecialchars($_POST['pejabat'], ENT_QUOTES);
    $maksud = htmlspecialchars($_POST['maksud'], ENT_QUOTES);
    $nohp = htmlspecialchars($_POST['nohp'], ENT_QUOTES);

    $simpan = mysqli_query($koneksi, "INSERT INTO ttamu VALUES ('', '$tgl', '$nama', '$alamat', '$pejabat', 
    '$maksud', '$nohp' )");

    if ($simpan) {
        echo "<script>alert('Simpan data Sukses, Terima kasih!')
             ;document.location='?'</script>";
    } else {
        echo "<script>alert('Simpan data Gagal!')
             ;document.location='?'</script>";
    }
}

?>

<div class="head text-center">
    <img src="assets/img/logopindad.png">
    <h2 class="text-white">Sistem Informasi Buku Tamu Digital <br> PT. Pindad Bandung</h2>
</div>
<!-- End Head -->

<!-- Input Data -->
<div class="row mt-2">
    <div class="col-lg-7 mb-3">
        <div class="card shadow bg-gradient-light">
            <div class="card-body">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Identitas Pengunjung</h1>
                </div>
                <!-- Nama Pengunjung -->
                <form class="user" method="POST" action="">
                    <div class="form-group">
                        <input type="text" class="form-control
                                    form-control-user" name="nama" placeholder="Nama Pengunjung" required>
                    </div>
                    <!-- End Nama Pengunjung -->

                    <!-- Alamat Pengunjung -->
                    <div class="form-group">
                        <input type="text" class="form-control
                                    form-control-user" name="alamat" placeholder="Alamat/Instansi Pengunjung" required>
                    </div>
                    <!-- End Alamat Pengunjung -->

                    <!-- Pejabat/Pegawai yang dituju -->
                    <div class="form-group">
                        <input type="text" class="form-control
                                    form-control-user" name="pejabat" placeholder="Pejabat/Pegawai yang dituju"
                            required>
                    </div>
                    <!-- End Pejabat/Pegawai yang dituju -->

                    <!-- Maksud Berkunjung -->
                    <div class="form-group">
                        <input type="text" class="form-control
                                    form-control-user" name="maksud" placeholder="Maksud Berkunjung" required>
                    </div>
                    <!-- End Maksud Berkunjung -->

                    <!-- No HP/WA -->
                    <div class="form-group">
                        <input type="text" class="form-control
                                    form-control-user" name="nohp" placeholder="Nomor HP/WhatsApp" required>
                    </div>
                    <!-- End No HP/WA  -->

                    <!-- Button Simpan -->
                    <button type="submit" name="bsimpan" class="btn btn-primary btn-user btn-block">Simpan Data</button>
                </form>
                <hr>
                <div class="text-center">
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Pengunjung -->
    <div class="col-lg-5 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Statistik Pengunjung</h1>
                </div>
                <?php
                $tgl_sekarang = date('Y-m-d');

                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));

                $seminggu = date('Y-m-d h:i:s', strtotime('-1 week +1 day', strtotime($tgl_sekarang)));

                $bulan_ini = date('m');

                $sekarang = date('Y-m-d h:i:s');

                $tgl_sekarang = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) FROM ttamu where 
                    tanggal like '%$tgl_sekarang%'"));

                $kemarin = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) FROM ttamu where 
                    tanggal like '%$kemarin%'"));

                $seminggu = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) FROM ttamu where 
                    tanggal BETWEEN '$seminggu' and '$sekarang'"));

                $sebulan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) FROM ttamu where 
                month(tanggal) = '$bulan_ini'"));

                $keseluruhan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) FROM ttamu"));

                ?>
                <table class="table table-bordered">
                    <tr>
                        <td>Hari ini</td>
                        <td>:
                            <?= $tgl_sekarang[0] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Kemarin</td>
                        <td>:
                            <?= $kemarin[0] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Minggu ini</td>
                        <td>:
                            <?= $seminggu[0] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Bulan ini</td>
                        <td>:
                            <?= $sebulan[0] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Keseluruhan</td>
                        <td>:
                            <?= $keseluruhan[0] ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Input Data -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung Hari ini [
            <?= date('d-m-Y') ?>]
        </h6>
    </div>
    <div class="card-body">
        <a href="rekapitulasi.php" class="btn btn-success mb-3">
            <i class="fa fa-table"> Rekapitulasi Pengunjung</i></a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nama Pengunjung</th>
                        <th>Alamat</th>
                        <th>Pejabat yang dituju</th>
                        <th>Tujuan</th>
                        <th>No. HP</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nama Pengunjung</th>
                        <th>Alamat</th>
                        <th>Pejabat yang dituju</th>
                        <th>Tujuan</th>
                        <th>No. HP</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $tgl = date('Y-m-d');
                    $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu where tanggal like '%$tgl%' order by id desc");
                    $no = 1;
                    while ($data = mysqli_fetch_array($tampil)) {
                        ?>
                        <tr>
                            <th>
                                <?= $no++ ?>
                            </th>
                            <th>
                                <?= $data['tanggal'] ?>
                            </th>
                            <th>
                                <?= $data['nama'] ?>
                            </th>
                            <th>
                                <?= $data['alamat'] ?>
                            </th>
                            <th>
                                <?= $data['pejabat'] ?>
                            </th>
                            <th>
                                <?= $data['maksud'] ?>
                            </th>
                            <th>
                                <?= $data['nohp'] ?>
                            </th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include "footer.php"; ?>