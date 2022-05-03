<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Crud\CrudRepository;

class UserRepository extends CrudRepository implements UserInterface
{
	public function __construct(User $user)
	{
		$this->model = $user;
	}
	public function create($data)
	{
		$detail = $this->model->create($data);
		return $detail;
	}
	public function update($data, $id)
	{
		return $this->model->find($id)->update($data);
	}

	public function storeUser($request)
	{
		$formData = $request->except('publish', 'password_confirmation');

		$formData['publish'] = is_null($request->publish) ? 0 : 1;
		$formData['password'] = bcrypt($request->password);

		return $formData;
	}

	public function updateUser($request)
	{
		$formData = $request->except('publish', 'password', 'password_confirmation');

		$formData['publish'] = is_null($request->publish) ? 0 : 1;

		if ($request->password) {
			$formData['password'] = bcrypt($request->password);
		}

		return $formData;
	}
}
