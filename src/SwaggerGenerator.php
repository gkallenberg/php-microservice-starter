<?php
namespace NYPL\Starter;

use Slim\Http\Response;

class SwaggerGenerator
{
    public static function generate(array $directory, Response $response)
    {
        ErrorHandler::setIgnoreError(true);

        $swagger = \Swagger\scan($directory);

        return $response->withJson($swagger)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader(
                'Access-Control-Allow-Headers',
                'Content-Type,X-Amz-Date,Authorization,X-Api-Key,X-Amz-Security-Token'
            );
    }
}
