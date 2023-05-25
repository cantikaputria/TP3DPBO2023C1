<?php

class Film extends DB
{
    function getFilmJoin()
    {
        $query = "SELECT * FROM film JOIN genre ON film.id_genre = genre.id_genre JOIN sutradara ON film.id_sutradara = sutradara.id_sutradara ORDER BY film.id_film";
        return $this->execute($query);
    }

    function getFilm()
    {
        $query = "SELECT * FROM film";
        return $this->execute($query);
    }

    function getFilmById($id)        
    {
        $query = "SELECT * FROM film JOIN genre ON film.id_genre=genre.id_genre JOIN sutradara ON film.id_sutradara=sutradara.id_sutradara WHERE id_film=$id";
        return $this->execute($query);
    }

    function searchFilm($keyword)
    {
        $query = "SELECT * FROM film JOIN genre ON film.id_genre=genre.id_genre JOIN sutradara ON film.id_sutradara=sutradara.id_sutradara WHERE judul_film Like '%" . $keyword . "%'";
        return $this->execute($query);
    }

    function filterAsc()
    {
        $query = "SELECT * FROM film JOIN genre ON film.id_genre=genre.id_genre JOIN sutradara ON film.id_sutradara=sutradara.id_sutradara ORDER BY judul_film ASC";
        return $this->execute($query);
    }

    function filterDesc()
    {
        $query = "SELECT * FROM film JOIN genre ON film.id_genre=genre.id_genre JOIN sutradara ON film.id_sutradara=sutradara.id_sutradara ORDER BY judul_film DESC";
        return $this->execute($query);
    }

    function addData($data, $file)    
    {
        $judul_film = $data['judul_film'];
        $tahun = $data['tahun'];

        $poster = rand(1000, 1000) . "-" . $_FILES['poster']['name'];
        $tmpImage = $_FILES['poster']['tmp_name'];
        $uploads_dir = './assets/';

        move_uploaded_file($tmpImage, $uploads_dir . '/' . $poster);
        
        $id_sutradara = $data['id_sutradara'];
        $id_genre = $data['id_genre'];

        $query = "INSERT INTO film VALUES ('', '$judul_film', '$tahun', '$poster', '$id_sutradara', '$id_genre')";
        
        return $this->executeAffected($query);
    }

    function updateData($idPrev, $data, $file, $image)
    {
        $judul_film = $data['judul_film'];
        $tahun = $data['tahun'];


        $poster = rand(1000, 1000) . "-" . $_FILES['poster']['name'];
        $tmpImage = $_FILES['poster']['tmp_name'];
        $uploads_dir = './assets/';

        move_uploaded_file($tmpImage, $uploads_dir . '/' . $poster);

        $id_sutradara = $data['id_sutradara'];
        $id_genre = $data['id_genre'];
 
        $query = "UPDATE film SET judul_film='$judul_film', tahun='$tahun', poster='$poster', id_sutradara='$id_sutradara', id_genre='$id_genre' WHERE id_film='$idPrev'";
         
        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM film WHERE id_film='$id'";
        return $this->executeAffected($query);
    }
}
