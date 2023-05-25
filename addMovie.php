<?php

include("config/db.php");
include("classes/DB.php");
include("classes/Sutradara.php");
include("classes/Genre.php");
include("classes/Film.php");
include("classes/Template.php");

$film = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$film->open();

$updateImg = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$updateImg->open();

$sutradara = new Sutradara($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$sutradara->open();

$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre->open();

$genre->getGenre();
$sutradara->getSutradara();

$dataSutradara = null;
$dataGenre = null;
$posterUpdate = "";
$judulUpdate = "";
$tahunUpdate = "";
$sutradaraUpdate = "";
$genreUpdate = "";

$tpl = new Template("templates/skinForm.html");

if (!isset($_GET['edit']))
{
    if (isset($_POST['btn-submit']))
    {
        if($film->addData($_POST, $_FILES)>0)
        {
            echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'index.php';
                </script>
                ";
        }
        else
        {
            echo "
                <script>
                    alert('Data Gagal ditambahkan!');
                    document.location.href = 'formFilm.php';
                </script>
                ";
        }
    }
    
    while ($row =  $sutradara->getResult())
    {
        $dataSutradara .= "
            <option value='". $row['id_sutradara'] ."'>". $row['nama_sutradara']."</option>
        ";
    }

    while ($row = $genre->getResult())
    {
        $dataGenre .= "
            <option value='". $row['id_genre'] ."'>". $row['genre_film'] ."</option>
        ";
    }
    $title = "Add Movie";
    $tpl->replace("DATA_TITLE", $title);

}
else if (isset($_GET['edit']))
{
    $idPrev = $_GET['edit'];
    $updateImg->getFilm();
    $updateImg->getFilmById($idPrev);
    $updtImg = $updateImg->getResult();
    $imgNew = $updtImg['poster'];
    
    if (isset($_POST['btn-submit']))
    {
        if($film->updateData($idPrev, $_POST, $_FILES, $imgNew)>0)
        {
            echo "
            <script>
            alert('Data berhasil diubah!');
            document.location.href = 'index.php';
            </script>
            ";
        }
        else
        {
            echo "
            <script>
            alert('Data Gagal diubah!');
            document.location.href = 'formFilm.php';
            </script>
            ";
        }
    }
    $film->getFilmById($idPrev);
    $row = $film->getResult();
    $posterUpdate = $row['poster'];
    $judulUpdate = $row['judul_film'];
    $tahunUpdate = $row['tahun'];
    $sutradaraUpdate = $row['id_sutradara'];
    $genreUpdate = $row['id_genre'];

    $sutradara->getSutradara();
    while ($row = $sutradara->getResult())
    {
        $selected = ($row['id_sutradara'] == $sutradaraUpdate) ? 'selected' : '';
        $dataSutradara .= "<option value='". $row['id_sutradara'] ."' $selected>". $row['nama_sutradara']."</option>";
    }

    $genre->getGenre();
    while ($row = $genre->getResult())
    {
        $selected = ($row['id_genre'] == $genreUpdate) ? 'selected' : '';
        $dataGenre .= "<option value='". $row['id_genre'] ."' $selected>". $row['genre_film'] ."</option>";
    }

    $title = "Update Movie";
    $tpl->replace("DATA_TITLE", $title);

}

$film->close();
$genre->close();
$sutradara->close();

$tpl->replace("DATA_JUDUL", $judulUpdate);
$tpl->replace("DATA_TAHUN", $tahunUpdate);
$tpl->replace("DATA_POSTER", $posterUpdate);
$tpl->replace("DATA_SUTRADARA", $dataSutradara);
$tpl->replace("DATA_GENRE", $dataGenre);
$tpl->write();

?>