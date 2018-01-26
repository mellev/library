<?php

namespace Library;

/**
 * Class BooksController
 * @package Library
 */
class BooksController extends Controller
{
    /**
     * Страница со списком книг
     */
    public function index()
    {
        $this->renderView('/index.php', [
            'items' => Books::find(),
            'title' => 'Библиотека книг'
        ]);
    }

    /**
     * Удаление книги
     */
    public function remove()
    {
        $id = $this->urlParams['id'];

        $item = Books::findFirst(
            [
                'where' => 'id = :id',
                'bind' => [
                    'id' => $id
                ]
            ]
        );

        if ($item) {
            $item->remove();
        }

        $this->redirectToRoute('index');
    }

    /**
     * Страница с подробной информацией о книге
     */
    public function get()
    {
        $id = $this->urlParams['id'];

        $item = Books::findFirst(
            [
                'where' => 'id = :id',
                'bind' => [
                    'id' => $id
                ]
            ]
        );

        $this->renderView('/book.php', [
            'item' => $item,
            'title' => $item ? $item->getName() : null
        ]);
    }

    /**
     * Создание книги
     */
    public function create()
    {
        $this->viewData['title'] = 'Добавление книги';

        if ($this->method == 'POST') {
            $item = Books::create($this->getRequestData(['name', 'author', 'pages_count', 'release_date']));

            $validationResult = true;

            if ($item && ! $item->getName()) {
                $this->viewData['error'] = 'Поле "Название" должно быть заполнено';
                $validationResult = false;
            }

            if ($item && $validationResult) {
                $this->redirectToRoute('book',[
                    'id' => $item->getId()
                ]);
            } else if (! $item) {
                $this->viewData['error'] = 'Ошибка создания книги';
            }
        }

        $this->renderView('/create.php');
    }

    /**
     * Редактирование книги
     */
    public function edit()
    {
        $id = $this->urlParams['id'];

        $item = Books::findFirst(
            [
                'where' => 'id = :id',
                'bind' => [
                    'id' => $id
                ]
            ]
        );

        $error = null;

        if ($this->method == 'POST') {
            $item->fill($this->getRequestData(['name', 'author', 'pages_count', 'release_date']));

            $validationResult = true;

            if ($item && ! $item->getName()) {
                $error = 'Поле "Название" должно быть заполнено';
                $validationResult = false;
            }

            if ($validationResult) {
                $item->save();

                $this->redirectToRoute('book', [
                    'id' => $item->getId()
                ]);
            }

        }

        $this->renderView('/edit.php', [
            'item' => $item,
            'title' => 'Редактирование книги',
            'error' => $error
        ]);
    }

    /**
     * Обработчик 404 ошибки
     */
    public function notFound()
    {
        $this->renderView('/notFound.php');
    }
}