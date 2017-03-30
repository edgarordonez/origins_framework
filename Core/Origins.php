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
        $query = 'SELECT * FROM ' . static::$table . ' WHERE ' . $field . ' = :value';
        $results = Database::instance()->prepare($query);
        $results->execute(array(':value' => $value));

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
        $results = Database::instance()->prepare('SELECT * FROM ' . static::$table);
        $results->execute();

        if ($results) {
            $class = get_called_class();
            foreach ($results as $index => $obj) {
                $objects[] = new $class($obj);
            }
        }
        return $objects;
    }

    public function save()
    {
        if (!empty($this->id)) {
            $this->updateQuery();
        } else {
            $this->insertQuery();
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

    private function updateQuery()
    {
        $nameColumns = $this->columnsObject($this);
        $valueColumns = $this->valuesObject($this);
        foreach ($valueColumns as &$valueColumn) {
            if(is_object($valueColumn)) {
                $valueColumn = $valueColumn->id;
            }
        }

        $columns = join(' = ?, ', $nameColumns) . ' = ?';
        $query = 'UPDATE ' . static::$table . ' SET ' . $columns . ' WHERE id = ' . $this->id;

        $result = Database::instance()->prepare($query);

        $result->execute($valueColumns);
    }

    private function insertQuery()
    {
        $nameColumns = $this->columnsObject($this);
        $valueColumns = $this->valuesObject($this);

        $params = join(', ', array_fill(0, count($nameColumns), '?'));
        $columns = join(', ', $nameColumns);
        $query = 'INSERT INTO ' . static::$table . ' ( ' . $columns . ' ) VALUES ( ' . $params . ')';

        $result = Database::instance()->prepare($query);
        $result->execute($valueColumns);
        $this->id = Database::instance()->lastInsertId();
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