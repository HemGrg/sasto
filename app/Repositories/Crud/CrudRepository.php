<?php

namespace App\Repositories\Crud;

use Carbon\Carbon;

abstract class CrudRepository implements CrudInterface
{
    /**
     * Stores the model used for repository
     * @var Eloquent object
     */
    protected $model;

    public function all()
    {
        return $this->model->all();
    }

    public function first()
    {
        return $this->model->first();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }


    // public function create($inputs) {
    //     return $this->model->creatItem($inputs);
    // }

    // public function update($id, $inputs) {
    //     return $this->model->updateItem($id, $inputs);
    // }

    public function delete()
    {
        return $this->model->delete();
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    public function orderBy($prop, $type = null)
    {
        return $this->model->orderBy($prop, $type);
    }

    public function where($column, $opOrVal, $value = "")
    {
        return $this->model->where($column, $opOrVal, $value);
    }

    public function orWhere($column, $operator, $value)
    {
        return $this->model->orWhere($column, $operator, $value);
    }

    public function orWhereBetween($column, $range)
    {
        return $this->model->orWhereBetween($column, $range);
    }

    public function whereBetween($column, $range)
    {
        return $this->model->whereBetween($column, $range);
    }

    public function where_array($array)
    {
        return $this->model->where($array);
    }

    public function whereIn($column, $array)
    {
        return $this->model->whereIn($column, $array);
    }

    public function whereNotIn($column, $array)
    {
        return $this->model->whereNotIn($column, $array);
    }

    public function whereNull($column)
    {
        return $this->model->whereNull($column);
    }

    public function firstOrNew($array)
    {
        return $this->model->firstOrNew($array);
    }

    public function model()
    {
        return new $this->model;
    }

    public function findOrFail($id = '')
    {
        return $this->model->findOrFail($id);
    }

    public function get()
    {
        return $this->model->get();
    }

    public function latest()
    {
        return $this->model->latest();
    }

    public function oldest()
    {
        return $this->model->oldest();
    }

    public function publish()
    {
        return $this->model->where('publish', 1);
    }

    public function latest__publish() // always call helper functions first then other laravel model methods
    {
        return $this->model->latest()->where('publish', 1);
    }

    public function take($n)
    {
        return $this->model->take($n);
    }

    public function get__current_week()
    {
        return $this->model->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    /**
     * Checks if the given key exists in given config array and returns the val if exists
     * @param array $config list of config values
     * @param string $key the key that may exist in config array
     * @param string $default default value
     * @return string
     */
    protected function getConfigValue($config, $key, $default = "")
    {
        $value = $default;
        if (isset($config[$key])) {
            $value = $config[$key];
        }
        return $value;
    }

    public function get_all($active = false, $limit = '', $exclude = array())
    {
        $model = $this->model;
        if ($active) {
            $model = $model->where('is_active', '=', 1);
        }
        if ($limit) {
            $model = $model->take($limit);
        }
        if (!empty($exclude)) {
            $model = $model->whereNotIn('id', $exclude);
        }
        return $model->get();
    }
    public function groupBy($column)
    {
        return $this->model->groupBy($column);
    }
    public function whereDate($column, $date)
    {
        return $this->model->whereDate($column, $date);
    }
    public function whereMonth($column, $month)
    {
        return $this->model->whereMonth($column, $month);
    }
    public function whereYear($column, $year)
    {
        return $this->model->whereYear($column, $year);
    }
    public function count()
    {
        $this->model->count();
    }
    public function with(array $relationships = [])
    {
        return $this->model->with($relationships);
    }
    public function withCount(array $relationships = [])
    {
        return $this->model->withCount($relationships);
    }

    /*
        @helpers functions
    */
    public function unlink_image($image_name)
    {
        $document_path = public_path('document') . $image_name;
        $main_path = public_path('images/main') . $image_name;
        $listing_path = public_path('images/listing') . $image_name;
        $thumbnail_path = public_path('images/thumbnail') . $image_name;

        $this->find_path__unlink($document_path);
        $this->find_path__unlink($main_path);
        $this->find_path__unlink($listing_path);
        $this->find_path__unlink($thumbnail_path);
    }
    public function find_path__unlink($full_path_to_image)
    {
        if (file_exists($full_path_to_image)) {
            unlink($full_path_to_image);
        }
        return;
    }
}
