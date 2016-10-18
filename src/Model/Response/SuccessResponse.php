<?php
namespace NYPL\Starter\Model\Response;

use NYPL\Starter\Model;
use NYPL\Starter\Model\Response;

/**
 * @SWG\Definition(title="Response", type="object")
 */
abstract class SuccessResponse extends Response
{
    /**
     * @SWG\Property
     * @var Model|Model[]
     */
    public $data;

    /**
     * @SWG\Property(format="int32", example=1)
     * @var int
     */
    public $count = 0;

    /**
     * @SWG\Property(format="int32", example=200)
     * @var int
     */
    public $statusCode;

    /**
     * @param Model|Model[] $model
     * @param int $code
     */
    public function __construct($model = null, $code = 200)
    {
        if ($model) {
            $this->intializeResponse($model);
        }

        $this->setStatusCode($code);
    }

    /**
     * @param Model|Model[] $model
     */
    public function intializeResponse($model)
    {
        $this->setData($model);

        if (is_array($model)) {
            $this->setCount(count($model));
        }
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = (int) $statusCode;
    }

    /**
     * @return Model|Model[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param Model|Model[] $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }
}
