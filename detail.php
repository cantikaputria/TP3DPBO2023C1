<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Sutradara.php');
include('classes/Film.php');
include('classes/Template.php');

$film = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$film->open();

$data = null;

if (isset($_GET['id']))
{
    $id = $_GET['id'];
    if ($id > 0)
    {
        $film->getFilmById($id);
        $row = $film->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail Film ' . $row['judul_film'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/' . $row['poster'] . '" class="img-thumbnail" alt="' . $row['poster'] . '" width="100">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Judul FIlm</td>
                                    <td>:</td>
                                    <td>' . $row['judul_film'] . '</td>
                                </tr>
                                <tr>
                                    <td>Tahun Rilis</td>
                                    <td>:</td>
                                    <td>' . $row['tahun'] . '</td>
                                </tr>
                                <tr>
                                    <td>Stutradara</td>
                                    <td>:</td>
                                    <td>' . $row['nama_sutradara'] . '</td>
                                </tr>
                                <tr>
                                    <td>Genre</td>
                                    <td>:</td>
                                    <td>' . $row['genre_film'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="addMovie.php?edit=' . $row['id_film'] . '"><button type="button" class="btn btn-color text-white">Ubah Data</button></a>
                <a href="detail.php?hapus=' . $row['id_film'] . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

if (isset($_GET['hapus']))
{
    $id = $_GET['hapus'];
    if ($id > 0) 
    {
        if ($film->deleteData($id) > 0) 
        {
            echo 
            "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>
            ";
        } else 
        {
            echo 
            "
            <script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
}

$film->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_FILM', $data);
$detail->write();
