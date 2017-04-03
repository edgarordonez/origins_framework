<?php

namespace Core;

abstract class Origins
{
    public $id;
    protected static $table;
    protected static $foreignKeys = [];

    public function __construct($object = null)
    {
        $this->initObjectFromPost($object);
        foreach (static::$foreignKeys as $foreignKey) {
            $this->foreignKeyInit($foreignKey);
        }
    }

    private function foreignKeyInit($foreignKey)
    {
        $object = $foreignKey['class']::find($this->{$foreignKey['name']});
        $this->{$foreignKey['name']} = $object;
    }

    public static function find($id)
    {
        $result = self::where('id', $id);
        return $result[0];
    }

    public static function where($field, $value)
    {
        $objects = null;
        $query = 'SELECT * FROM ' . static::$table . ' WHERE ' . $field . ' = ?';
        $statement = Database::instance()->prepare($query);
        $statement->bind_param('s', $value);
        $statement->execute();
        $results = $statement->get_result();
        $results = $results->fetch_all(MYSQLI_ASSOC);

        if ($results) {
            $class = get_called_class();
            foreach ($results as $index => $obj) {
                $objects[] = new $class($obj);
            }
        }

        return $objects;
    }

    public static function all()
    {
        $objects = null;
        $statement = Database::instance()->prepare('SELECT * FROM ' . static::$table);
        $statement->execute();
        $results = $statement->get_result();
        $results = $results->fetch_all(MYSQLI_ASSOC);
        if ($results) {
            $class = get_called_class();
            foreach ($results as $index => $obj) {
                $objects[] = new $class($obj);
            }
        }
        return $objects;
    }

    public function delete()
    {
        $results = Database::instance()->prepare('DELETE FROM ' . static::$table . ' WHERE id=' . $this->id);
        $results->execute();
    }

    public function save()
    {
        $nameColumns = $this->columnsObject($this);
        $valueColumns = $this->valuesObject($this);

        foreach ($valueColumns as &$valueColumn) {
            if (is_object($valueColumn)) {
                $valueColumn = $valueColumn->id;
            }
        }

        if (!empty($this->id)) {
            $this->updateQuery($nameColumns, $valueColumns);
        } else {
            $this->insertQuery($nameColumns, $valueColumns);
        }
    }

    protected function initObjectFromPost($object)
    {
        if ($object !== null) {
            foreach ($object as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    private function updateQuery($nameColumns, $valueColumns)
    {
        $columns = join(' = ?, ', $nameColumns) . ' = ?';
        $query = 'UPDATE ' . static::$table . ' SET ' . $columns . ' WHERE id = ' . $this->id;
        echo $query;
        $statement = Database::instance()->prepare($query);

        $this->bindParams($statement, $valueColumns);

        $statement->execute();
    }

    private function insertQuery($nameColumns, $valueColumns)
    {
        $params = join(', ', array_fill(0, count($nameColumns), '?'));
        $columns = join(', ', $nameColumns);
        $query = 'INSERT INTO ' . static::$table . ' ( ' . $columns . ' ) VALUES ( ' . $params . ')';

        $statement = Database::instance()->prepare($query);

        $this->bindParams($statement, $valueColumns);

        $statement->execute();
        $this->id = Database::lastInsertId();
    }

    private function bindParams($statement, $valueColumns)
    {
        $a_params = array();

        $param_type = '';
        $n = count($valueColumns);
        for ($i = 0; $i < $n; $i++) {
            $param_type .= 's';
        }

        $a_params[] = &$param_type;

        for ($i = 0; $i < $n; $i++) {
            /* with call_user_func_array, array params must be passed by reference */
            $a_params[] = &$valueColumns[$i];
        }

        call_user_func_array(array($statement, 'bind_param'), $a_params);
    }

    private function columnsObject($object)
    {
        return array_keys($this->dataObject($object));
    }

    private function valuesObject($object)
    {
        return array_values($this->dataObject($object));
    }

    private function dataObject($object)
    {
        $filtered = null;
        $values = get_object_vars($object);

        foreach ($values as $key => $value) {
            if ($value !== null && $value !== '' && strpos($key, 'obj_') === false && $key !== 'id') {
                if ($value === false) {
                    $value = 0;
                }
                $filtered[$key] = $value;
            }
        }
        return $filtered;
    }
}