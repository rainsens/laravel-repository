<?php
namespace Rainsens\Repository\Eloquent;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Rainsens\Repository\Contracts\RepositoryInterface;
use Rainsens\Repository\Exceptions\RepositoryException;

abstract class RepositoryAbstract implements RepositoryInterface
{
	/**
	 * @var Container
	 */
	private $app;
	/**
	 * @var Model | Builder
	 */
	protected $model;
	
	/**
	 * RepositoryAbstract constructor.
	 * @param Container $container
	 * @throws RepositoryException
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	public function __construct(Container $container)
	{
		$this->app = $container;
		$this->makeModel();
	}
	
	public abstract function model();
	
	/**
	 * @return Model|mixed
	 * @throws RepositoryException
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	protected function makeModel()
	{
		$model = $this->app->make($this->model());
		if (! $model instanceof Model) {
			throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
		}
		return $this->model = $model;
	}
	
	/**
	 * @param $id
	 * @param array $columns
	 * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|mixed|null
	 */
	public function find_($id, $columns = ['*'])
	{
		return $this->model->find($id, $columns);
	}
	
	/**
	 * @param $attribute
	 * @param $value
	 * @param array $columns
	 * @return Builder|Model|mixed|object|null
	 */
	public function findBy_($attribute, $value, $columns = ['*'])
	{
		return $this->model->where($attribute, '=', $value)->first($columns);
	}
	
	/**
	 * @param array $columns
	 * @return Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
	 */
	public function all_($columns = ['*'])
	{
		return $this->model->get($columns);
	}
	
	/**
	 * @param int $perPage
	 * @param array $columns
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
	 */
	public function paginate_($perPage = 20, $columns = ['*'])
	{
		return $this->model->paginate($perPage, $columns);
	}
	
	/**
	 * @param array $data
	 * @return Builder|Model|mixed
	 */
	public function create_(array $data)
	{
		return $this->model->create($data);
	}
	
	/**
	 * @param array $data
	 * @param $id
	 * @param string $attribute
	 * @return int|mixed
	 */
	public function update_(array $data, $id, $attribute = 'id')
	{
		return $this->model->where($attribute, '=', $id)->update($data);
	}
	
	/**
	 * @param $id
	 * @return int|mixed
	 */
	public function delete_($id)
	{
		return $this->model::destroy($id);
	}
}
