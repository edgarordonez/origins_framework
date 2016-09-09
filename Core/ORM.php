<?php
namespace Core;

class ORM
{
    protected static $table;
    private static $connection;

    function __construct()
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
        $statement = self::$connection->prepare("SELECT * FROM " . static::$table . " WHERE " . $field . " = :value");
        $results = $statement->execute([$value]);

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
        $statement = self::$connection->prepare("SELECT * FROM " . static::$table);
        $results = $statement->execute();

        if ($results) {
            $class = get_called_class();
            foreach ($results as $index => $obj) {
                $objects[] = new $class($obj);
            }
        }
        return $objects;
    }

    private function save()
    {
        $columns = $this->columnsObject($this);

        if ($this->id) {
            $columns = join(" = ?, ", $columns);
            $columns.= ' = ?';
            $query = "UPDATE " . static::$table . " SET $columns WHERE id = " . $this->id;
        } else {
            $params = join(", ", array_fill(0, count($columns), "?"));
            $columns = join(", ", $columns);
            $query = "INSERT INTO " . static::$table . " ($columns) VALUES ($params)";
        }

        $statement = self::$connection->prepare($query);
        $result = $statement->execute();

        if ($result) {
            $result = array('error' => false, 'message' => self::$connection->lastInserId());
        } else {
            $result = array('error' => true, 'message' => self::$connection->errorInfo());
        }

        return $result;
    }

    private function columnsObject($this)
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
        return array_keys($filtered);
    }
}