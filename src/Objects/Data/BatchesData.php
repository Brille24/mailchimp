<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use Brille24\Mailchimp\Objects\Request\Request;
use ErrorException;

final class BatchesData implements DataInterface
{
    /** @var Request[] */
    private $operations = [];

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Batches data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $operations = array_map(function (Request $request) {
            $bodyParameters = [
                'method' => (string)$request->getMethod(),
                'path' => $request->getPrimaryResource(),
            ];

            if (null !== $request->getQueryParameters()) {
                $bodyParameters['params'] = $request->getQueryParameters()->toRequestBodyArray();
            }

            if (null !== $request->getBodyParameters()) {
                $bodyParameters['body'] = $request->getBodyParameters()->toRequestBody();
            }

            return $bodyParameters;
        }, $this->operations);

        return [
            'operations' => $operations,
        ];
    }

    /**
     * @return array
     */
    public function getOperations(): array
    {
        return $this->operations;
    }

    /**
     * @param array $operations
     */
    public function setOperations(array $operations): void
    {
        $this->operations = $operations;
    }

    /**
     * @param Request $request
     */
    public function addOperation(Request $request): void
    {
        $this->operations[] = $request;
    }

    /**
     * @param Request $request
     */
    public function removeOperation(Request $request): void
    {
        if (($key = array_search($request, $this->operations)) !== false) {
            unset($this->operations[$key]);
        }
    }
}
