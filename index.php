<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Film.php');
include('classes/Genre.php');
include('classes/Sutradara.php');
include('classes/Template.php');

$listFilm = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$listFilm->open();
$listFilm->getFilmJoin();

if (isset($_POST['btn-cari'])) {
  $listFilm->searchFilm($_POST['cari']);
} else if (isset($_POST['btn-asc'])) {
  $listFilm->filterAsc();
}else if (isset($_POST['btn-desc'])) {
  $listFilm->filterDesc();
} else {
  $listFilm->getFilmJoin();
}

$data = null;

while ($row = $listFilm->getResult())
{
  $data .= '<div class="col-md-3 mb-4 d-flex justify-content-center">' .
  '<div class="card pt-4 px-2 film-thumbnail">
  <a href="detail.php?id=' . $row['id_film'] . '">
      <div class="row justify-content-center">
          <img src="assets/' . $row['poster'] . '" class="card-img-top" alt="' . $row['poster'] . '">
      </div>
      <div class="card-body">
          <p class="card-text film-nama fw-bold my-0" style="font-size: 1.1em;">' . $row['judul_film'] . '</p>
          <p class="card-text genre-nama " style="font-size: 1em; color: rgb(20, 51, 79);">' . $row['genre_film'] . '</p>
          <p class="card-text sutradara-nama " style="font-size: 1em; color: rgb(43, 20, 145);">' . $row['nama_sutradara'] . '</p>
      </div>
  </a>
</div>    
</div>';
}

$listFilm->close();
$home = new Template('templates/index.html');
$home->replace('DATA_TABLE', $data);
$home->write();
