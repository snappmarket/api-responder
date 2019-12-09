<?php


namespace SnappMarket\ApiResponder;

use Emyoutis\WhiteHouseResponder\Response as WhiteHouseResponse;

class Response extends WhiteHouseResponse
{
    /**
     * Returns a success response based on the specified details.
     *
     * @param array $results
     * @param array $metadata
     * @param array $messages
     *
     * @return array
     */
    public function success(array $results, array $metadata = [], array $messages = [])
    {
        $completeMetadata = array_merge($metadata, compact('messages'));

        return parent::success($results, $completeMetadata);
    }



    /**
     * Returns an error response for the client errors based on the specified error code.
     *
     * @param string $errorCode
     * @param array  $replaces
     * @param array  $errors
     *
     * @return array
     */
    public function clientError(string $errorCode, array $replaces = [], $errors = [])
    {
        $parentResult = parent::clientError($errorCode, $replaces);

        return array_merge($parentResult, compact('errors'));
    }



    /**
     * Returns an error response for the server errors based on the specified error code.
     *
     * @param string $errorCode
     * @param array  $replaces
     * @param array  $errors
     *
     * @return array
     */
    public function serverError(string $errorCode, array $replaces = [], $errors = [])
    {
        $parentResult = parent::serverError($errorCode, $replaces);

        return array_merge($parentResult, compact('errors'));
    }


    /**
     * Returns an error response for the errors based on the specified error code and status.
     *
     * @param string $errorCode
     * @param int    $status
     * @param array  $replaces
     * @param array  $errors
     *
     * @return array
     */
    public function error(string $errorCode, int $status, array $replaces = [], $errors = [])
    {
        $parentResult = parent::error($errorCode, $status, $replaces);

        return array_merge($parentResult, compact('errors'));
    }
}
