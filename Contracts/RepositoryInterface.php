<?php
namespace Rainsens\Repository\Contracts;

interface RepositoryInterface
{
	/**
	 * @param $id
	 * @param array $columns
	 * @return mixed
	 */
	public function find_($id, $columns = ['*']);
	
	/**
	 * @param $attribute
	 * @param $value
	 * @param array $columns
	 * @return mixed
	 */
	public function findBy_($attribute, $value, $columns = ['*']);
	
	/**
	 * @param array $columns
	 * @return mixed
	 */
	public function all_($columns = ['*']);
	
	/**
	 * @param int $perPage
	 * @param array $columns
	 * @return mixed
	 */
	public function paginate_($perPage = 20, $columns = ['*']);
	
	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create_(array $data);
	
	/**
	 * @param array $data
	 * @param $id
	 * @param string $attribute
	 * @return mixed
	 */
	public function update_(array $data, $id, $attribute = 'id');
	
	/**
	 * @param $id
	 * @return mixed
	 */
	public function delete_($id);
}
