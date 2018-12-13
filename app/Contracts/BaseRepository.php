<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseRepository
{
    /**
     * Aplica condições no repositório
     *
     * @param array $conditions
     * @return BaseRepository
     */
    public function where($conditions = array());

    /**
     * Retorna todos os dados do repositório
     *
     * @param array $columns
     * @return Collection
     */
    public function all($columns = array('*'));

    /**
     * Retorna todos os dados do repositório com paginação
     *
     * @param null $limit
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate($limit = null, array $columns = array('*'));

    /**
     * Aplica ordenação
     *
     * @param null $by
     * @param null $order
     * @return BaseRepository
     */
    public function order($by = null, $order = null);

    /**
     * Aplica limite
     *
     * @param int $limit
     * @return BaseRepository
     */
    public function limit($limit);

    /**
     * Retorna um dado
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id, $columns = array('*'));

    /**
     * Salva um dado no repositório
     *
     * @param array $params
     * @return mixed
     */
    public function save(array $params);

    /**
     * Remove dados do repositório
     *
     * @param int $id
     * @return boolean
     */
    public function remove($id = null);
}