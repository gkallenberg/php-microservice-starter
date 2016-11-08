<?php
namespace NYPL\Starter;

use NYPL\Starter\Filter\QueryFilter;
use NYPL\Starter\Model\Source;
use NYPL\Starter\Model\Identity;
use NYPL\Starter\Model\Response\SuccessResponse;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Controller
{
    const TEXT_CONTENT_TYPE = 'text/plain';

    const HTML_CONTENT_TYPE = 'text/html';

    const JSON_CONTENT_TYPE = 'application/json';

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var string
     */
    public $contentType = '';

    /**
     * @var Identity
     */
    public $identity;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->setRequest($request);
        $this->setResponse($response);

        $this->initializeContentType();
        $this->initializeIdentity();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return Identity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param Identity $identity
     */
    public function setIdentity(Identity $identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return string
     * @throws APIException
     */
    public function determineContentType()
    {
        $acceptedContentTypes = $this->getRequest()->getHeaderLine("Accept");

        if (strpos($acceptedContentTypes, self::HTML_CONTENT_TYPE) !== false) {
            return "text/html";
        }

        if (strpos($acceptedContentTypes, self::TEXT_CONTENT_TYPE) !== false) {
            return "text/plain";
        }

        if (strpos($acceptedContentTypes, self::JSON_CONTENT_TYPE) !== false) {
            return "application/json";
        }

        return "application/json";
    }

    public function initializeContentType()
    {
        $this->setContentType($this->determineContentType());

        $this->setResponse($this->getResponse()->withHeader("Content-Type", $this->getContentType()));
    }

    /**
     * @param callable $bufferedFunction
     *
     * @return string
     */
    public function bufferOutput(callable $bufferedFunction)
    {
        ob_start();
        $bufferedFunction();
        $output = ob_get_contents();
        ob_clean();

        return $output;
    }

    /**
     * @return bool
     */
    public function initializeIdentity()
    {
        if ($this->getRequest()->hasHeader(ControllerHandler::getIdentityHeader())) {
            $this->setIdentity(new Identity(
                $this->getRequest()->getHeaderLine(ControllerHandler::getIdentityHeader())
            ));
            return true;
        }

        $this->setIdentity(new Identity());
        return true;
    }


    /**
     * @param Source $source
     *
     * @return string
     */
    protected function generateId(Source $source)
    {
        if ($source->getSourceId()) {
            return $source->getSourceCode() . $source->getSourceId();
        }

        return $source->getSourceCode() . $source->getId();
    }

    /**
     * @param Model $model
     * @param SuccessResponse $response
     * @param Filter|null $filter
     * @param array $queryParameters
     *
     * @return Response
     */
    protected function getDefaultReadResponse(
        Model $model,
        SuccessResponse $response,
        Filter $filter = null,
        array $queryParameters = []
    ) {
        if ($model instanceof ModelSet) {
            if (!$model->isNoDefaultSorting()) {
                if (!$model->getOrderBy()) {
                    $model->setOrderBy('updatedDate');
                }

                if (!$model->getOrderDirection()) {
                    $model->setOrderDirection('DESC');
                }
            }

            $model->setOffset($this->getRequest()->getParam('offset'));
            $model->setLimit($this->getRequest()->getParam('limit'));

            if ($filter) {
                $model->addFilter($filter);
            }

            if ($queryParameters) {
                foreach ($queryParameters as $queryParameter) {
                    $model->addFilter(new QueryFilter($this->getRequest(), $queryParameter));
                }
            }

            $model->read();

            $response->initializeResponse($model->getData());
        } else {
            $model->read($filter->getId());

            $response->initializeResponse($model);
        }

        return $this->getResponse()->withJson($response);
    }
}
