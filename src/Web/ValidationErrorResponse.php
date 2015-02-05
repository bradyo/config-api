<?php
namespace Api\Web;

use Api\Validation\ValidationError;

class ValidationErrorResponse extends ClientResponse
{
    /**
     * @param string $message
     * @param ValidationError[] $validationErrors
     * @param ClientRequest $request
     */
    public function __construct($message, array $validationErrors, ClientRequest $request)
    {
        $data = [
            'status' => 'error',
            'message' => $message,
        ];
        $validationErrorData = [];
        foreach ($validationErrors as $validationError) {
            $validationErrorData[] = [
                'field' => $validationError->getName(),
                'message' => $validationError->getMessage()
            ];
        }
        if (! empty($validationErrorData)) {
            $data['validationErrors'] = $validationErrorData;
        }
        parent::__construct($data, $request, 400);
    }
}