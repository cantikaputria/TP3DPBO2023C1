<?php

include("config/db.php");
include("classes/DB.php");
include("classes/Sutradara.php");
include("classes/Template.php");

$sutradara = new Sutradara($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$sutradara->open();

$dataNavbar = null;
$dataHeader = null;
$dataContent = null;
$dataForm = null;
$title = "Sutradara";

if (!isset($_GET['id_update'], $_GET['id_delete']))
{
    $inputTitle = "Add Director";
    $dataForm = "
            <div class='mb-3'>
              <label for='nama_sutradara' class='form-label'>Nama Sutradara</label>
              <input type='text' class='form-control' id='nama_sutradara' name='nama_sutradara' placeholder='Input Director Name' required />
            </div>
            <div class='float-end'>
                <button type='submit' class='btn btn-custom' name='btn-submit' id='btn-submit'>Submit</button>
            </div>
    ";

    if (isset($_POST['btn-submit']))
    {
        $nama_sutradara = $_POST['nama_sutradara'];

        if($sutradara->addSutradara($nama_sutradara)>0)
        {
            echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'sutradara.php';
                </script>
                ";
        }
        else
        {
            echo "
                <script>
                    alert('Data Gagal ditambahkan!');
                    document.location.href = 'sutradara.php';
                </script>
                ";
        }
        
    }
}

if (isset($_GET['id_update']))
{
    $id_update = $_GET['id_update'];

    $sutradara->getDetailSutradara($id_update);
    $row = $sutradara->getResult();

    $inputTitle = "Edit Director";
    $dataForm = "
            <div class='mb-3'>
              <input type='hidden' class='form-control' id='id_sutradara' name='id_sutradara' value='". $row['id_sutradara'] ."' />
              <label for='nama_sutradara' class='form-label'>Nama Sutradara</label>
              <input type='text' class='form-control' id='nama_sutradara' name='nama_sutradara' value='". $row['nama_sutradara'] ."' placeholder='Masukan Nama Sutradara...' required />
            </div>
            <div class='float-end'>
                <button type='submit' class='btn btn-custom' name='btn-edit' id='btn-edit'>Submit</button>
                <button type='reset' class='btn btn-secondary' name='btn-reset' id='btn-reset'>Reset</button>
            </div>
    ";

    if (isset($_POST['btn-edit']))
    {
        $id_sutradara = $_POST['id_sutradara'];
        $nama_sutradara = $_POST['nama_sutradara'];

        if($sutradara->updateSutradara($id_sutradara, $nama_sutradara)>0)
        {
            echo "
            <script>
            alert('Data berhasil diubah!');
            document.location.href = 'sutradara.php';
            </script>
            ";
        }else 
        {
            echo "
            <script>
            alert('Data Gagal diubah!');
            document.location.href = 'sutradara.php';
            </script>
            ";
        }
    }
}

if (isset($_GET['id_delete'])) 
{
    $id_sutradara = $_GET['id_delete'];

    if($id_sutradara > 0)
    {
        if($sutradara->deleteSutradara($id_sutradara)>0)
        {
            echo 
            "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'sutradara.php';
            </script>
            ";
        }else 
        {
            echo 
            "
            <script>
                alert('Data gagal dihapus!');
                document.location.href = 'sutradara.php';
            </script>
            ";
        }
    }
}

$dataHeader .= "
            <th scope='col'>No</th>
            <th scope='col'>Nama Sutradara</th>
            <th scope='col'>Action</th>
";

$sutradara->getSutradara();
$no = 1;

while ($row = $sutradara->getResult()) {
    // create table row
    $dataContent .= '
    <tr>
        <th scope="row">' . $no . '</th>
        <td>' . $row['nama_sutradara'] . '</td>
        <td style="font-size: 22px;">
            <a href="sutradara.php?id_update=' . $row['id_sutradara'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
            <a href="sutradara.php?id_delete=' .$row['id_sutradara'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>
    ';
    $no++;
}

$dataNama="Sutradara";
$sutradara->close();

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