<?php
namespace Api\Account;

use Api\Web\ClientRequest;

class PostAccountRequest extends ClientRequest
{
    /**
     * @param ClientRequest $request
     */
    public function __construct(ClientRequest $request)
    {
        parent::__construct($request, $request->getClient());
    }

    public function getNewAccount()
    {
        $data = $this->getData();

        return new NewAccount(
            $data['name'],
            $data['contact_email_address']
        );
    }
}