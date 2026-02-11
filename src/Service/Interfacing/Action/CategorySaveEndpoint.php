<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Action;

use App\Domain\Interfacing\Model\ActionRequest;
use App\Domain\Interfacing\Model\ActionResult;
use App\Domain\Interfacing\Model\CategoryFormModel;
use App\Domain\Interfacing\Model\UiMessage;
use App\Domain\Interfacing\Value\ActionId;
use App\Service\Interfacing\Validator\ValidatorErrorMapper;
use App\ServiceInterface\Interfacing\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\CategoryApiClientInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 *
 */

/**
 *
 */
final class CategorySaveEndpoint implements ActionEndpointInterface
{
    /**
     * @param \App\ServiceInterface\Interfacing\CategoryApiClientInterface $api
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @param \App\Service\Interfacing\Validator\ValidatorErrorMapper $mapper
     */
    public function __construct(
        private readonly CategoryApiClientInterface $api,
        private readonly ValidatorInterface         $validator,
        private readonly ValidatorErrorMapper       $mapper
    ) {}

    /**
     * @return \App\Domain\Interfacing\Value\ActionId
     */
    public function id(): ActionId { return ActionId::of('category.save'); }

    /**
     * @param \App\Domain\Interfacing\Model\ActionRequest $request
     * @return \App\Domain\Interfacing\Model\ActionResult
     */
    public function handle(ActionRequest $request): ActionResult
    {
        $payload = $request->payload()['payload'] ?? [];
        if (!is_array($payload)) {
            return ActionResult::domainError([UiMessage::warning('Invalid payload.')]);
        }

        $model = new CategoryFormModel();
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
            return ActionResult::validationError($this->mapper->map($violations), [UiMessage::warning('Fix validation errors.')]);
        }

        $id = $model->id !== '' ? $model->id : 'new';

        try {
            return ActionResult::ok([UiMessage::success('Saved.')], ['category' => $this->api->save($id, $model->toPayload())]);
        } catch (\Throwable $e) {
            return ActionResult::domainError([UiMessage::error('Save failed: '.$e->getMessage())]);
        }
    }
}
