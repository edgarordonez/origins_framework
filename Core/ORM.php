<?php
namespace Core;

class ORM
{
    protected static $table;
    private static $connection;

    public function __construct()
    {
        self::$connection = Database::instance();
    }

    public static function find($id)
    {
        $result = self::where('id', $id);
        return $result[0];
    }

    public static function where($field, $value)
    {
        $objects = null;
        $results = self::$connection->prepare("SELECT * FROM " . static::$table . " WHERE " . $field . " = :value");
        $results->execute(array(':value' => $value));

        if ($results) {
            $class = get_called_class();
            foreach ($results as $index => $obj)
            {
                $objects[] = new $class($obj);
            }
        }
        return $objects;
    }

    public static function all()
    {
        $objects = null;
        $results = self::$connection->prepare("SELECT * FROM " . static::$table);
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
        $nameColumns = $this->columnsObject($this);
        $valueColumns = $this->valuesObject($this);

        if ($this->id) {
            $columns = join(" = ?, ", $nameColumns).' = ?';
            $query = "UPDATE " . static::$table . " SET $columns WHERE id = " . $this->id;
        } else {
            $params = join(", ", array_fill(0, count($nameColumns), "?"));
            $columns = join(", ", $nameColumns);
            $query = "INSERT INTO " . static::$table . " ($columns) VALUES ($params)";
        }

        $result = self::$connection->prepare($query);
        $result->execute($valueColumns);
    }

    private function columnsObject()
    {
        return array_keys($this->dataObject());
    }

    private function valuesObject()
    {
        return array_values($this->dataObject());
    }

    private function dataObject()
    {
        $filtered = null;
        $values = get_object_vars($this);

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