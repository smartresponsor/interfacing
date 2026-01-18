<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Http\Interfacing\Live;

use App\Domain\Interfacing\Demo\DemoUserProfileInput;
use App\Domain\Interfacing\Error\DomainOperationFailed;
use App\Domain\Interfacing\Ui\UiMessage;
use App\Domain\Interfacing\Ui\UiMessageBag;
use App\InfraInterface\Interfacing\Demo\DemoUserProfileStoreInterface;
use App\ServiceInterface\Interfacing\Ui\DomainErrorMapperInterface;
use App\ServiceInterface\Interfacing\Ui\SessionFlashMessengerInterface;
use App\ServiceInterface\Interfacing\Ui\ValidationRunnerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_demo_user_profile_form')]
final class InterfacingDemoUserProfileForm
{
    use LiveFeedbackTrait;

    #[LiveProp(writable: true)]
    public string $name = '';

    #[LiveProp(writable: true)]
    public string $email = '';

    public function __construct(
        private readonly DemoUserProfileStoreInterface $store,
        private readonly ValidationRunnerInterface $validationRunner,
        private readonly DomainErrorMapperInterface $domainErrorMapper,
        private readonly SessionFlashMessengerInterface $flash,
    ) {
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

        $input = new DemoUserProfileInput(trim($this->name), trim($this->email));
        $error = $this->validationRunner->validate($input);

        if ($error->hasAny()) {
            $this->applyUiErrorBag($error);
            return;
        }

        try {
            $this->store->save($input->name, $input->email);
        } catch (DomainOperationFailed $e) {
            $this->applyUiErrorBag($this->domainErrorMapper->fromDomainOperationFailed($e));
            return;
        }

        $bag = new UiMessageBag();
        $bag->add(new UiMessage(UiMessage::TYPE_SUCCESS, 'Profile saved.'));
        $this->applyUiMessageBag($bag);

        // Also push into session flash for the next full request.
        $this->flash->push(new UiMessage(UiMessage::TYPE_SUCCESS, 'Profile saved.'));
    }
}
