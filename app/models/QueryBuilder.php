<?php

namespace app\models;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder

{
    protected $pdo;
    protected $queryFactory;

    public function __construct(PDO $pdo, QueryFactory $qf)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $qf;
    }

    /**
     * @param $table
     * @param null $limit
     * @return array
     */
    public function getAll($table, $limit = null): array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->limit($limit);

        $stmt = $this->pdo->prepare($select->getStatement());
        $stmt->execute($select->getBindValues());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWhere($id, $table, $idCol = 'id', $limit = null): array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where($idCol . ' = :' . $idCol)
            ->bindValue($idCol, $id)
            ->limit($limit);

        $stmt = $this->pdo->prepare($select->getStatement());
        $stmt->execute($select->getBindValues());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWhereOrder($id, $table, $order_by, $idCol = 'id', $limit = null): array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where($idCol . ' = :' . $idCol)
            ->bindValue($idCol, $id)
            ->orderBy($order_by)
            ->limit($limit);

        $stmt = $this->pdo->prepare($select->getStatement());
        $stmt->execute($select->getBindValues());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @param $data
     * @param $table
     * @param $join1
     * @param $order_by
     * @param string $idCol
     * @param string $idColEasy
     * @param null $limit
     * @return array
     */
    public function getColumnsJoinWhereOrder($id, $data, $table, $join1, $order_by, $idCol = 'id', $idColEasy = 'id', $limit = null): array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols($data)
            ->from($table)
            ->join($join1[0], $join1[1], $join1[2])
            ->where($idCol . ' = :' . $idColEasy)
            ->bindValue($idColEasy, $id)
            ->orderBy($order_by)
            ->limit($limit);

        $stmt = $this->pdo->prepare($select->getStatement());
        $stmt->execute($select->getBindValues());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $data
     * @param $table
     * @param $join1
     * @param $join2
     * @param $order_by
     * @param null $limit
     * @return array
     */
    public function getColumnsJoin2Order($data, $table, $join1, $join2, $order_by, $limit = null): array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols($data)
            ->from($table)
            ->join($join1[0], $join1[1], $join1[2])
            ->join($join2[0], $join2[1], $join2[2])
//            ->where($idCol . ' = :' . $idColEasy)
//            ->bindValue($idColEasy, $id)
            ->orderBy($order_by)
            ->limit($limit);

        $stmt = $this->pdo->prepare($select->getStatement());
        $stmt->execute($select->getBindValues());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @param $data
     * @param $table
     * @return string
     */
    public function insert($data, $table)
    {

        $insert = $this->queryFactory->newInsert();
        $insert
            ->into($table)                   // INTO this table
            ->cols($data);

        // prepare the statement
        $sth = $this->pdo->prepare($insert->getStatement());

        // execute with bound values
        $sth->execute($insert->getBindValues());
        return $this->pdo->lastInsertId();

    }

    /**
     * @param $data
     * @param $table
     * @param $bindValues
     * @param string $idCol
     */
    public function update($data, $table, $bindValues, $idCol = 'id')
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($data)           // AND WHERE these conditions
            ->where($idCol . ' = :' . $idCol)
            ->bindValues($bindValues);

        // prepare the statement
        $sth = $this->pdo->prepare($update->getStatement());

        // execute with bound values
        $sth->execute($update->getBindValues());

    }

    /**
     * @param $id
     * @param $table
     * @param string $idCol
     */
    public function delete($id, $table, $idCol = 'id')
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)                   // FROM this table
            ->where($idCol . ' = :' . $idCol)           // AND WHERE these conditions
            ->bindValue($idCol, $id);

        // prepare the statement
        $sth = $this->pdo->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues());
    }

    /**
     * @param $id
     * @param $table
     * @param string $idCol
     * @return mixed
     */
    public function getOne($id, $table, $idCol = 'id')
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where($idCol . ' = :' . $idCol)           // AND WHERE these conditions
            ->bindValue($idCol, $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $data
     * @param $table
     * @param $join1
     * @param $join2
     * @param null $limit
     * @return array
     */
    public function getColumnsJoin2($data, $table, $join1, $join2, $limit = null)

    {
        $select = $this->queryFactory->newSelect();

        $select->cols($data)
            ->from($table)
            ->join($join1[0], $join1[1], $join1[2])
            ->join($join2[0], $join2[1], $join2[2])
            ->limit($limit);


        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        //меняем тип вывода массива в зависимости от количества аргументов (столбцов)
        if (count($data) > 1) {
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        }

        return $result;
    }

    public function getColumnsJoin2Where($id, $data, $table, $join1, $join2, $idCol = 'id', $idColEasy = 'id', $limit = null)

    {
        $select = $this->queryFactory->newSelect();

        $select->cols($data)
            ->from($table)
            ->join($join1[0], $join1[1], $join1[2])
            ->join($join2[0], $join2[1], $join2[2])
            ->where($idCol . ' = :' . $idColEasy)
            ->bindValue($idColEasy, $id)
            ->limit($limit);


        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        if (count($data) > 1) {
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        }

        return $result;
    }

    public function getColumnsJoin2Where2($id1, $id2, $data, $table, $join1, $join2, $idCol1, $idCol2, $idCol1Easy, $idCol2Easy, $limit = null)

    {
        $select = $this->queryFactory->newSelect();

        $select->cols($data)
            ->from($table)
            ->join($join1[0], $join1[1], $join1[2])
            ->join($join2[0], $join2[1], $join2[2])
            ->where($idCol1 . ' = :' . $idCol1Easy)
            ->where($idCol2 . ' = :' . $idCol2Easy)
            ->bindValues([$idCol1Easy => $id1, $idCol2Easy => $id2])
            ->limit($limit);


        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        if (count($data) > 1) {
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        }

        return $result;
    }

    public function getColumnsJoinWhere($data, $table, $join1, $postID)

    {
        $select = $this->queryFactory->newSelect();

        $select->cols($data)
            ->from($table)
            ->join($join1[0], $join1[1], $join1[2])
            ->where('postID = :postID')           // AND WHERE these conditions
            ->bindValue('postID', $postID);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        if (count($data) > 1) {
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        }

        return $result;
    }

    public function getColumns($data, $table)

    {
        $select = $this->queryFactory->newSelect();

        $select->cols($data)
            ->from($table);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        if (count($data) > 1) {
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        }


        return $result;
    }

    public function getNameById($name, $id, $table)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols($name)
            ->from($table)
            ->where('id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_COLUMN);
    }

    /*    public function newestPosts ($name, $id, $table)
        {
            $select = $this->queryFactory->newSelect();

            $select->fromSubSelect("SELECT * FROM `posts` ORDER BY ID DESC LIMIT 5","");

            $sth = $this->pdo->prepare($select->getStatement());

            $sth->execute($select->getBindValues());

            return $sth->fetch(PDO::FETCH_COLUMN);
        }*/


}
