<?php

namespace App\Repositories\User;

use App\Repositories\Crud\CrudInterface;

interface UserInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
