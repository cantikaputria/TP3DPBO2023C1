<?php

include("config/db.php");
include("classes/DB.php");
include("classes/Genre.php");
include("classes/Template.php");

$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre->open();

$dataNavbar = null;
$dataHeader = null;
$dataContent = null;
$dataForm = null;
$title = "Genre";

if (!isset($_GET['id_update'], $_GET['id_delete']))
{
    $inputTitle = "Add Genre";
    $dataForm = "
            <div class='mb-3'>
              <label for='genre_film' class='form-label'>Genre Film</label>
              <input type='text' class='form-control' id='genre_film' name='genre_film' placeholder='Input New Genre Here' required />
            </div>
            <div class='float-end'>
                <button type='submit' class='btn btn-custom' name='btn-submit' id='btn-submit'>Submit</button>
            </div>
    ";

    if (isset($_POST['btn-submit']))
    {
        $genre_film = $_POST['genre_film'];
        if($genre->addGenre($genre_film)>0)
        {
            echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'genre.php';
                </script>
                ";
        } else
        {
            echo "
                <script>
                    alert('Data Gagal ditambahkan!');
                    document.location.href = 'genre.php';
                </script>
                ";
        }
    }
}

if (isset($_GET['id_update']))
{
    $id_update = $_GET['id_update'];

    $genre->getDetailGenre($id_update);
    $row = $genre->getResult();

    $inputTitle = "Edit Genre";
    $dataForm = "
    
            <div class='mb-3'>
              <input type='hidden' class='form-control' id='id_genre' name='id_genre' value='". $row['id_genre'] ."' />
              <label for='genre_film' class='form-label'>Genre Film</label>
              <input type='text' class='form-control' id='genre_film' name='genre_film' value='". $row['genre_film'] ."' placeholder='Masukan Nama Genre...' required />
            </div>
            <div class='float-end'>
                <button type='submit' class='btn btn-custom' name='btn-edit' id='btn-edit'>Submit</button>
            </div>
    ";

    if (isset($_POST['btn-edit']))
    {
        $id_genre = $_POST['id_genre'];
        $genre_film = $_POST['genre_film'];

        if($genre->updateGenre($id_genre, $genre_film)>0){
            echo "
            <script>
            alert('Data berhasil diubah!');
            document.location.href = 'genre.php';
            </script>
            ";
        }else {
            echo "
            <script>
            alert('Data Gagal diubah!');
            document.location.href = 'genre.php';
            </script>
            ";
        }
    }
}

if (isset($_GET['id_delete']))
{
    $id_genre = $_GET['id_delete'];

    if($id_genre > 0)
    {
        if($genre->deleteGenre($id_genre)>0)
        {
            echo 
            "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'genre.php';
            </script>
            ";
        }else 
        {
            echo 
            "
            <script>
                alert('Data gagal dihapus!');
                document.location.href = 'genre.php';
            </script>
            ";
        }
    }
}

$dataHeader .= "
            <th scope='col'>No</th>
            <th scope='col'>Genre Film</th>
            <th scope='col'>Action</th>
";

$genre->getGenre();
$no = 1;

while ($row = $genre->getResult())
{
    $dataContent .= '
    <tr>
        <th scope="row">' . $no . '</th>
        <td>' . $row['genre_film'] . '</td>
        <td style="font-size: 22px;">
            <a href="genre.php?id_update=' . $row['id_genre'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
            <a href="genre.php?id_delete=' .$row['id_genre'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>
    ';
    $no++;
}

$genre->close();
$dataNama = "Genre";

$tpl = new Template("templates/skintable.html");
$tpl->replace("DATA_NAVBAR", $dataNavbar);
$tpl->replace("DATA_TITLE", $title);
$tpl->replace("DATA_INPUT_TITLE", $inputTitle);
$tpl->replace("DATA_INPUT_FORM", $dataForm);
$tpl->replace("DATA_HEADER", $dataHeader);
$tpl->replace("DATA_CONTENT", $dataContent);
$tpl->replace("DATA_NAMA", $dataNama);
$tpl->write();

?>