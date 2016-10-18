<?php
namespace NYPL\API;

use NYPL\API\Model\Response\ErrorResponse;

class ErrorHandler
{
    public static function processError($errorString = '', array $context = [])
    {
        $exception = new APIException($errorString, $context);

        $apiResponse = new ErrorResponse(
            500,
            'error',
            'There was an error processing your request.',
            $exception
        );

        APILogger::addError($errorString, (array) $exception);

        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode($apiResponse, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        die();
    }


    public static function errorFunction($errorNumber, $errorString)
    {
        self::processError($errorString);
    }

    public static function shutdownFunction()
    {
        $error = error_get_last();

        if ($error !== null) {
            self::processError($error['message'], $error);
        }
    }
}