<?php
/**
 * Created by PhpStorm.
 * User: BoomerOK
 * Date: 10.10.2018
 * Time: 19:02
 */

namespace APP;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    private $pdo;
    private $queryFactory;

    public function __construct()
    {
        // a PDO connection
        $this->pdo = new PDO('mysql:host=127.0.0.1; dbname=test2; charset=utf8;','testuser','testpass');
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function getAll ($table)
    {
      
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table);

// prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

// bind the values and execute
        $sth->execute($select->getBindValues());

// get the results back as an associative array
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insert($data, $table){

        $insert = $this->queryFactory->newInsert();
        $insert
            ->into($table)                   // INTO this table
            ->cols($data);


        // prepare the statement
        $sth = $this->pdo->prepare($insert->getStatement());

        // execute with bound values
        $sth->execute($insert->getBindValues());

    }

    public function update ($data, $id, $table)
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($data)           // AND WHERE these conditions
            ->where('id = :id')
            ->bindValue('id',$id);

        // prepare the statement
        $sth = $this->pdo->prepare($update->getStatement());

        // execute with bound values
        $sth->execute($update->getBindValues());

    }

    public function delete ($id, $table)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)                   // FROM this table
            ->where('id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);

        // prepare the statement
        $sth = $this->pdo->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues());
    }

    public function getOne ($id, $table)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
         ->from($table)
         ->where('id = :id')           // AND WHERE these conditions
         ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getColumns ($data, $table)

    {
        $select = $this->queryFactory->newSelect();

        $select->cols($data)
            ->from($table);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());
        
        //меняем тип вывода массива в зависимости от количества аргументов (столбцов)
        if (count ($data)>1)
        {
            $result = $sth->fetchALL(PDO::FETCH_ASSOC);
        } else $result = $sth->fetchALL(PDO::FETCH_COLUMN);

        return $result;
    }

}