<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Action;

use App\Contract\Action\ActionRequest;
use App\Contract\Action\ActionResult;
use App\Contract\Dto\CategoryFormInput;
use App\Contract\Ui\UiMessage;
use App\Contract\ValueObject\ActionId;
use App\Service\Interfacing\Validator\ValidatorErrorMapper;
use App\ServiceInterface\Interfacing\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\CategoryApiClientInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CategorySaveEndpoint implements ActionEndpointInterface
{
    public function __construct(
        private readonly CategoryApiClientInterface $api,
        private readonly ValidatorInterface $validator,
        private readonly ValidatorErrorMapper $mapper,
    ) {
    }

    public function id(): ActionId
    {
        return ActionId::of('category.save');
    }

    public function handle(ActionRequest $request): ActionResult
    {
        $payload = $request->payload()['payload'] ?? [];
        if (!is_array($payload)) {
            return ActionResult::domainError('invalid_payload', 'Invalid payload.');
        }

        $model = new CategoryFormInput();
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
            return ActionResult::validationError($this->mapper->map($violations), [new UiMessage('warning', 'Fix validation errors.')]);
        }

        $id = '' !== $model->id ? $model->id : 'new';

        try {
            return ActionResult::ok(['category' => $this->api->save($id, $model->toPayload())]);
        } catch (\Throwable $e) {
            return ActionResult::domainError('save_failed', 'Save failed: '.$e->getMessage());
        }
    }
}
