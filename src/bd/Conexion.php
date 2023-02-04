<?php

    function openConection(){
        $host = "localhost";
        $usuario = "root";
        $clave = "crimson_circle";
        $db = "blog_site";
        return new PDO("mysql:host=$host;dbname=$db", $usuario, $clave);
    }

    function transaction($conex, $query = ''){
        if($query == '')
            return false;
        try {  
            $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
            $conex->beginTransaction();
            $conex->exec($query);
            $conex->commit();
            return true;
          } catch (Exception $e) {
            $conex->rollBack();
            //echo "Failed: " . $e->getMessage();
            return false;
          } 
    }

    function getLastId($conex){
        return $conex->lastInsertId();
    }

    function consultation($conex, $query = ""){
        $registros = [];
        if($query == '')
            return $registros;

        $result = $conex->query($query);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $row;
        }
        return $registros;
    }