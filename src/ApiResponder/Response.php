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
}
