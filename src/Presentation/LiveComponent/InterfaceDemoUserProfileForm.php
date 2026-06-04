<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent;

use App\Interfacing\Contract\Dto\InterfaceDemoUserProfileInput;
use App\Interfacing\Contract\Error\InterfaceDomainOperationFailed;
use App\Interfacing\Contract\Ui\InterfaceUiMessage;
use App\Interfacing\Contract\Ui\InterfaceUiMessageBag;
use App\Interfacing\MapperInterface\Ui\InterfaceDomainErrorMapperInterface;
use App\Interfacing\MessengerInterface\Ui\InterfaceSessionFlashMessengerInterface;
use App\Interfacing\RunnerInterface\Ui\InterfaceValidationRunnerInterface;
use App\Interfacing\StoreInterface\Demo\InterfaceDemoUserProfileStoreInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_demo_user_profile_form', template: 'widget/live/demo_user_profile_form.html.twig')]
final class InterfaceDemoUserProfileForm
{
    use InterfaceLiveFeedbackTrait;

    #[LiveProp(writable: true)]
    public string $name = '';

    #[LiveProp(writable: true)]
    public string $email = '';

    public function __construct(
        private readonly InterfaceDemoUserProfileStoreInterface $store,
        private readonly InterfaceValidationRunnerInterface $validationRunner,
        private readonly InterfaceDomainErrorMapperInterface $domainErrorMapper,
        private readonly InterfaceSessionFlashMessengerInterface $flash,
    ) {
    }

    public function __invoke(): void
    {
    }

    public function mount(): void
    {
        $data = $this->store->load();
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->clearUiFeedback();
    }

    #[LiveAction]
    public function save(): void
    {
        $this->clearUiFeedback();

        $input = new InterfaceDemoUserProfileInput(trim($this->name), trim($this->email));
        $error = $this->validationRunner->validate($input);

        if ($error->hasAny()) {
            $this->applyUiErrorBag($error);

            return;
        }

        try {
            $this->store->save($input->name, $input->email);
        } catch (InterfaceDomainOperationFailed $e) {
            $this->applyUiErrorBag($this->domainErrorMapper->fromDomainOperationFailed($e));

            return;
        }

        $bag = new InterfaceUiMessageBag();
        $bag->add(new InterfaceUiMessage(InterfaceUiMessage::TYPE_SUCCESS, 'Profile saved.'));
        $this->applyUiMessageBag($bag);

        // Also push into session flash for the next full request.
        $this->flash->push(new InterfaceUiMessage(InterfaceUiMessage::TYPE_SUCCESS, 'Profile saved.'));
    }
}
