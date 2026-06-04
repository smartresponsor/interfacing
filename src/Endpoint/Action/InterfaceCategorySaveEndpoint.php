<?php

declare(strict_types=1);

namespace App\Interfacing\Endpoint\Action;

use App\Interfacing\ClientInterface\CategoryApi\InterfaceCategoryApiClientInterface;
use App\Interfacing\Contract\Action\InterfaceActionRequest;
use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\Dto\InterfaceCategoryFormInput;
use App\Interfacing\Contract\Ui\InterfaceUiMessage;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\EndpointInterface\Catalog\InterfaceActionEndpointInterface;
use App\Interfacing\Mapper\Validator\InterfaceValidatorErrorMapper;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class InterfaceCategorySaveEndpoint implements InterfaceActionEndpointInterface
{
    public function __construct(
        private readonly InterfaceCategoryApiClientInterface $api,
        private readonly ValidatorInterface $validator,
        private readonly InterfaceValidatorErrorMapper $mapper,
    ) {
    }

    public function id(): InterfaceActionId
    {
        return InterfaceActionId::of('category.save');
    }

    public function handle(InterfaceActionRequest $request): InterfaceActionResult
    {
        $payload = $request->payload()['payload'] ?? [];
        if (!is_array($payload)) {
            return InterfaceActionResult::domainError('invalid_payload', 'Invalid payload.');
        }

        $model = new InterfaceCategoryFormInput();
        $model->fillFromArray($payload);

        $violations = $this->validator->validate($model, new Assert\Collection([
            'fields' => [
                'id' => new Assert\Optional([new Assert\Type('string')]),
                'slug' => new Assert\Required([new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 128])]),
                'name' => new Assert\Required([new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 200])]),
                'locale' => new Assert\Required([new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 10])]),
                'status' => new Assert\Required([new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 30])]),
            ],
            'allowExtraFields' => true,
            'allowMissingFields' => true,
        ]));

        if (count($violations) > 0) {
            return InterfaceActionResult::validationError($this->mapper->map($violations), [new InterfaceUiMessage('warning', 'Fix validation errors.')]);
        }

        $id = '' !== $model->id ? $model->id : 'new';

        try {
            return InterfaceActionResult::ok(['category' => $this->api->save($id, $model->toPayload())]);
        } catch (\Throwable $e) {
            return InterfaceActionResult::domainError('save_failed', 'Save failed: '.$e->getMessage());
        }
    }
}
