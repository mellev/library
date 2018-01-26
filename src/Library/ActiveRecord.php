<?php

namespace Library;

/**
 * Базовый класс для моделей
 *
 * Class ActiveRecord
 * @package Library
 */
abstract class ActiveRecord
{
    /**
     * Поля таблицы
     *
     * @var string[]
     */
    protected $fields = [
        'id'
    ];

    /**
     * Значения полей
     *
     * @var array
     */
    protected $data = [
        'id' => null
    ];

    /**
     * Флаг активации автоматического задания даты при создании записи
     *
     * @var bool
     */
    protected $createDate = false;

    /**
     * Флаг активации автоматического задания даты при обновлении записи
     *
     * @var bool
     */
    protected $lastModify = false;

    /**
     * Возвращает название таблицы
     *
     * @return string
     */
    abstract static public function getTableName();

    /**
     * Создает модель и сохраняет данные в базу данных
     *
     * @param $data
     * @return ActiveRecord
     */
    public static function create($data)
    {
        $item = new static();

        $item->fill($data);
        $item->save();
        $item->setId($item->getDb()->getLastInsertId());

        return $item;
    }

    /**
     * Ищет записи в базе данных и маппит их на модели
     *
     * @param array $condition
     * @return static[]
     */
    public static function find($condition = [])
    {
        /**
         * @var $db Db
         */
        $db = Di::getStaticContainer()->getService('db');

        $query = 'SELECT * FROM ' . static::getTableName();

        if (array_key_exists('where', $condition)) {
            $query .= ' WHERE ' . $condition['where'];
        }

        if (array_key_exists('groupBy', $condition)) {
            $query .= ' GROUP BY ' . $condition['groupBy'];
        }

        if (array_key_exists('having', $condition)) {
            $query .= ' HAVING ' . $condition['having'];
        }

        if (array_key_exists('orderBy', $condition)) {
            $query .= ' ORDER BY ' . $condition['orderBy'];
        }

        if (array_key_exists('limit', $condition)) {
            $query .= ' LIMIT ' . $condition['limit'];
        }

        if (array_key_exists('offset', $condition)) {
            $query .= ' OFFSET ' . $condition['offset'];
        }

        $items = $db->query([
            'query' => $query,
            'bind' => $condition['bind']
        ]);

        $models = [];

        foreach ($items as $item) {
            $model = new static();
            $model->fill($item);

            $models[] = $model;
        }

        return $models;
    }

    /**
     * Ищет одну запись в базе
     *
     * @param array $condition
     * @return ActiveRecord
     */
    public static function findFirst($condition = [])
    {
        /**
         * @var $db Db
         */
        $db = Di::getStaticContainer()->getService('db');

        $query = 'SELECT * FROM ' . static::getTableName();

        if (array_key_exists('where', $condition)) {
            $query .= ' WHERE ' . $condition['where'];
        }

        $query .= ' LIMIT 1';

        $items = $db->query([
            'query' => $query,
            'bind' => $condition['bind']
        ]);

        if (count($items)) {
            $model = new static();
            $model->fill($items[0]);

            return $model;
        }

        return null;
    }

    /**
     * Получение идентификатора записи
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->data['id'];
    }

    /**
     * Задание идентификатора записи
     *
     * @return mixed
     */
    protected function setId($id)
    {
        $this->data['id'] = $id;
    }

    /**
     * Сохранение модели в базу
     *
     * @return mixed
     */
    public function save()
    {
        $db = Di::getStaticContainer()->getService('db');

        if ($this->data['id'] == null) {
            if ($this->createDate) {
                $this->data['create_date'] = date("Y-m-d H:i:s", time());
            }

            if ($this->createDate) {
                $this->data['last_modify'] = date("Y-m-d H:i:s", time());
            }

            $db->execute([
                'query' => 'INSERT INTO ' . static::getTableName() . ' SET ' . $this->buildSetExpressions($this->data),
                'bind' => $this->buildBinds($this->data)
            ]);

            $id = $db->getLastInsertId();

            $this->data['id'] = $id;

        } else {
            if ($this->createDate) {
                $this->data['last_modify'] = date("Y-m-d H:i:s", time());
            }

            $db->execute([
                'query' => 'UPDATE ' . static::getTableName() . ' SET ' . $this->buildSetExpressions($this->data) . ' WHERE id = :id',
                'bind' => $this->buildBinds($this->data)
            ]);
        }
    }

    /**
     * Заполнение полей модели
     *
     * @return mixed
     */
    public function fill($data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * Удаление записи из базы
     */
    public function remove()
    {
        $db = Di::getStaticContainer()->getService('db');

        if ($this->data['id'] != null) {
            $db->execute([
                'query' => 'DELETE FROM ' . static::getTableName() . ' WHERE id = :id',
                'bind' => [
                    ':id' => $this->data['id']
                ]
            ]);

            $this->data['id'] = null;
        }
    }

    private function buildSetExpressions($data)
    {
        $expressions = [];

        foreach ($data as $column => $value) {
            $expressions[] = $column . ' = ' . ':' . $column;
        }

        return implode(',', $expressions);
    }

    private function buildBinds($data) {
        $binds = [];

        foreach ($data as $column => $value) {
            $binds[':' . $column] = $value;
        }

        return $binds;
    }

    protected function getDb()
    {
        return Di::getStaticContainer()->getService('db');
    }
}