<?php

class Genre extends DB
{
    function getGenre()
    { 
        $query = "SELECT * FROM genre";
        return $this->execute($query);
    }

    function searchGenre($keyword)
    {
        $query = "SELECT * FROM genre WHERE genre_film Like '%" . $keyword . "%'";
        return $this->execute($query);
    }

    function getDetailGenre($id_genre)
    {
        $query = "SELECT * FROM genre WHERE id_genre='$id_genre'";
        return $this->execute($query);
    }
    
    function addGenre($genre_film)
    {
        $query = "INSERT INTO genre VALUES (null, '$genre_film')";
        return $this->executeAffected($query);
    }
    
    function updateGenre($id_genre, $genre_film)
    {
        $query = "UPDATE genre SET genre_film='$genre_film' WHERE id_genre='$id_genre'";
        return $this->executeAffected($query);
    }
    
    function deleteGenre($id_genre)
    {
        $query = "DELETE FROM genre WHERE id_genre='$id_genre'";
        return $this->executeAffected($query);
    }
}

?>