<?php

namespace GetCandy\Api\Scaffold;

abstract class BaseService
{
    /**
     * Returns model by a given hashed id
     * @param  string $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByHashedId($id)
    {
        $id = $this->model->decodeId($id);
        $result = $this->model->findOrFail($id);
        return $result;
    }

    /**
     * Get a collection of models from given Hashed IDs
     * @param  array  $ids
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getByHashedIds(array $ids)
    {
        $parsedIds = [];
        foreach ($ids as $hash) {
            $parsedIds[] = $this->model->decodeId($hash);
        }
        return $this->model->find($parsedIds);
    }

    /**
     * Returns the record count for the model
     * @return Int
     */
    public function count()
    {
        return (bool) $this->model->count();
    }

    /**
     * Gets the decoded id for the model
     * @param  string $hash
     * @return int
     */
    public function getDecodedId($hash)
    {
        return $this->model->decodeId($hash);
    }

    /**
     * Returns the record considered the default
     * @return Mixed
     */
    public function getDefaultRecord()
    {
        return $this->model->default()->first();
    }

    /**
     * Gets paginated data for the record
     * @param  integer $length How many results per page
     * @param  int  $page   The page to start
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedData($length = 50, $page = null)
    {
        return $this->model->paginate($length, ['*'], 'page', $page);
    }

    /**
     * Gets a new suggested default model
     * @return Mixed
     */
    public function getNewSuggestedDefault()
    {
        return $this->model->where('default', '=', false)->where('enabled', '=', true)->first();
    }

    /**
     * Sets the passed model as the new default
     * @param Illuminate\Database\Eloquent\Model &$model
     */
    protected function setNewDefault(&$model)
    {
        if ($current = $this->getDefaultRecord()) {
            $current->default = false;
            $current->save();
        }
        $model->default = true;
    }

    /**
     * Determines whether a record exists by a given code
     * @param  string $code
     * @return boolean
     */
    public function existsByCode($code)
    {
        return $this->model->where('code', '=', $code)->exists();
    }

    /**
     * Checks whether a record exists with the given hashed id
     * @param  string $hashedId
     * @return boolean
     */
    public function existsByHashedId($hashedId)
    {
        $id = $this->model->decodeId($hashedId);
        return $this->model->where('id', '=', $id)->exists();
    }

    protected function getDataList()
    {
        return $this->model->get();
    }

    protected function prepareAttributeData($attribute, array $data)
    {
        $structure = [];
        $languagesArray = [];

        // Get our languages
        $languages = app('api')->languages()->getDataList();
        foreach ($languages as $lang) {
            $languagesArray[$lang->code] = '';
        }
        // Get our channels
        $channels = app('api')->channels()->getDataList();
        foreach ($channels as $channel) {
            $structure[$channel->handle] = $languagesArray;
        }

        $structure = array_replace($structure, $data);
        return $structure;
    }
}
