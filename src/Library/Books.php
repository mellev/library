<?php

namespace Library;

/**
 * Модель книги
 *
 * Class Books
 * @package Library
 */
class Books extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    protected $fields = [
        'id',
        'name',
        'author',
        'pages_count',
        'release_date',
        'create_date',
        'last_modity'
    ];

    /**
     * @inheritdoc
     */
    protected $createDate = true;

    /**
     * @inheritdoc
     */
    protected $lastModify = true;

    /**
     * @return mixed
     */
    public function getLastModify()
    {
        return $this->data['last_modify'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->data['name'] = $name;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->data['author'];
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->data['author'] = $author;
    }

    /**
     * @return mixed
     */
    public function getPagesCount()
    {
        return $this->data['pages_count'];
    }

    /**
     * @param mixed $pagesCount
     */
    public function setPagesCount($pagesCount)
    {
        $this->data['pages_count'] = $pagesCount;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->data['release_date'];
    }

    /**
     * @param mixed $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->data['release_date'] = $releaseDate;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->data['create_date'];
    }

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->data['create_date'] = $createDate;
    }

    /**
     * @inheritdoc
     */
    public static function getTableName()
    {
        return 'books';
    }
}