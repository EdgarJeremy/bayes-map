<?php
require_once './_head.php';
$stmt = $conn->prepare('SELECT * FROM `tempat` WHERE `id_admin` = :id_admin');
$stmt->execute(['id_admin' => $_SESSION['id_admin']]);
$list_tempat = $stmt->fetchAll(PDO::FETCH_CLASS);
/** Simpan */
if(isset($_POST['btnSubmit'])) {
    if(isset($_POST['nama']) && isset($_POST['latitude']) && isset($_POST['longitude'])) {
        $stmt = $conn->prepare('INSERT INTO `tempat`(`nama`, `deskripsi`, `latitude`, `longitude`, `id_admin`) VALUES (:nama, :deskripsi, :latitude, :longitude, :id_admin)');
        if($stmt->execute([
            'nama' => $_POST['nama'],
            'deskripsi' => isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '',
            'latitude' => $_POST['latitude'],
            'longitude' => $_POST['longitude'],
            'id_admin' => $_SESSION['id_admin']
        ])) {
            redirect('./dashboard.php?success');
        }
    } else {
        redirect('./dashboard.php');
    }
}
/** Edit */
if(isset($_POST['btnEditSubmit'])) {
    if(isset($_POST['id_tempat']) && isset($_POST['nama']) && isset($_POST['latitude']) && isset($_POST['longitude'])) {
        $stmt = $conn->prepare('UPDATE `tempat` SET `nama` = :nama, `deskripsi` = :deskripsi, `latitude` = :latitude, `longitude` = :longitude WHERE `id_tempat` = :id_tempat AND `id_admin` = :id_admin');
        if($stmt->execute([
            'nama' => $_POST['nama'],
            'deskripsi' => isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '',
            'latitude' => $_POST['latitude'],
            'longitude' => $_POST['longitude'],
            'id_tempat' => $_POST['id_tempat'],
            'id_admin' => $_SESSION['id_admin']
        ])) {
            redirect('./dashboard.php?successedit');
        } else {
            redirect('./dashboard.php');
        }
    }
}
/** Ticket */
if(isset($_POST['btnTicketSubmit'])) {
    if(isset($_POST['id_tempat']) && isset($_POST['tanggal']) && isset($_POST['total'])) {
        $stmt = $conn->prepare('SELECT * FROM `kunjungan` WHERE `id_tempat` = :id_tempat AND DATE(`tanggal`) = :tanggal');
        $stmt->execute(['id_tempat' => $_POST['id_tempat'], 'tanggal' => $_POST['tanggal']]);
        $kunjungan = $stmt->fetch(PDO::FETCH_ASSOC);
        if($kunjungan) {
            redirect('./dashboard.php');
        } else {
            $stmt = $conn->prepare('INSERT INTO `kunjungan`(`id_tempat`, `tanggal`, `total`) VALUES(:id_tempat, :tanggal, :total)');
            if($stmt->execute(['id_tempat' => $_POST['id_tempat'], 'tanggal' => $_POST['tanggal'], 'total' => $_POST['total']])) {
                redirect('./dashboard.php?successticket');
            } else {
                redirect('./dashboard.php');
            }
        }
    } else {
        redirect('./dashboard.php');
    }
}
?>

<main role="main" class="container">
    <div id="bar-chart"></div>
    <hr />
    <h4>Tempat wisata anda</h4>
    <hr />
    <?php if(isset($_GET['success'])):?>
        <div class="alert alert-success" role="alert">
            Tempat berhasil ditambah
        </div>
    <?php endif;?>
    <?php if(isset($_GET['successedit'])):?>
        <div class="alert alert-success" role="alert">
            Tempat berhasil diperbarui
        </div>
    <?php endif;?>
    <?php if(isset($_GET['successdelete'])):?>
        <div class="alert alert-success" role="alert">
            Tempat berhasil dihapus
        </div>
    <?php endif;?>
    <?php if(isset($_GET['successticket'])):?>
        <div class="alert alert-success" role="alert">
            Data kunjungan tersimpan
        </div>
    <?php endif;?>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">
        <span class="oi oi-plus"></span> Tambah
    </button>
    <hr />
    <div class="row">
        <div class="col-md-6">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($list_tempat as $tempat):?>
                    <tr>
                        <td>
                            <b><?php echo $tempat->nama; ?></b><br />
                            <?php echo $tempat->deskripsi; ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary edit-btn" data-id="<?php echo $tempat->id_tempat; ?>"><span class="oi oi-pencil"></span></button>
                            <a href="./hapus_tempat.php?id_tempat=<?php echo $tempat->id_tempat; ?>" class="btn btn-danger delete-btn"><span class="oi oi-trash"></span></a>
                            <button type="button" class="btn btn-info ticket-btn" data-data='<?php echo json_encode($tempat); ?>'><span class="oi oi-inbox"></span></button>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php if(count($list_tempat) === 0): ?>
                    <tr>
                        <td colspan="2" class="text-center">Belum ada data</td>
                    </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <div id="preview">
                <div id="overlay">
                    <h3 class="text-center p-5"><span class="oi oi-arrow-left"></span> Pilih tempat</h3>
                </div>
                <div id="map"></div>
                <hr />
                <form method="post">
                    <input type="hidden" name="id_tempat" id="id_tempat">
                    <div class="form-group">
                        <label for="nama">Nama Tempat</label>
                        <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama.." required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3" placeholder="Deskripsi.."></textarea>
                    </div>
                    <input type="hidden" id="editLatitude" name="latitude" />
                    <input type="hidden" id="editLongitude" name="longitude" />
                    <button name="btnEditSubmit" type="submit" class="btn btn-primary">Update data</button>
                    <button type="button" class="btn btn-warning cancel-edit">Batal</button>
                </form>
            </div>
        </div>
    </div>
</main>
<hr />

        <!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Tempat Wisata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama Tempat</label>
                        <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama.." required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3" placeholder="Deskripsi.."></textarea>
                    </div>
                    <hr />
                    <input type="hidden" id="latitude" name="latitude" />
                    <input type="hidden" id="longitude" name="longitude" />
                    <label for="map-add">Lokasi</label>
                    <div id="map-add"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button name="btnSubmit" type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketModalLabel">Input kunjungan tempat wisata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_tempat" id="id_tempat" />
                    <div class="form-group">
                        <label for="nama">Nama Tempat</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama.." disabled />
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="3" placeholder="Deskripsi.." disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input name="tanggal" id="tanggal" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="total">Total Kunjungan</label>
                        <input name="total" id="total" type="number" class="form-control" required/>
                    </div>
                    <hr />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button name="btnTicketSubmit" type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
require_once './_foot.php';
?>