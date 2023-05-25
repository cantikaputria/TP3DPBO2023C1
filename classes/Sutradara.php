<?php

class Sutradara extends DB
{
    function getSutradara()
    {
        $query = "SELECT * FROM sutradara";
        return $this->execute($query);
    }

    function getDetailSutradara($id_sutradara)
    {
        $query = "SELECT * FROM sutradara WHERE id_sutradara='$id_sutradara'";
        return $this->execute($query);
    }

    function addSutradara($nama_sutradara) 
    {
        $query = "INSERT INTO sutradara VALUES (null, '$nama_sutradara')";
        return $this->executeAffected($query);
    }

    function updateSutradara($id_sutradara, $nama_sutradara) 
    {
        $query = "UPDATE sutradara SET nama_sutradara='$nama_sutradara' WHERE id_sutradara='$id_sutradara'";
        return $this->executeAffected($query);
    }

    function deleteSutradara($id_sutradara) 
    {
        $query = "DELETE FROM sutradara WHERE id_sutradara='$id_sutradara'";
        return $this->executeAffected($query);
    }
}
?>