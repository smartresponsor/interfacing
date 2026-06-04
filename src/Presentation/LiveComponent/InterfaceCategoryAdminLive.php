<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\LiveComponent;

use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\Dto\InterfaceCategoryFormInput;
use App\Interfacing\Contract\Ui\InterfaceUiErrorInterface;
use App\Interfacing\Contract\Ui\InterfaceUiMessageInterface;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\Contract\ValueObject\InterfaceScreenId;
use App\Interfacing\ProviderInterface\Context\InterfaceBaseContextProviderInterface;
use App\Interfacing\Runner\Action\InterfaceScreenActionRunner;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('InterfacingCategoryAdmin', template: 'widget/live/category_admin.html.twig')]
final class InterfaceCategoryAdminLive
{
    #[LiveProp(writable: true)] public string $q = '';
    #[LiveProp(writable: true)] public ?string $cursor = null;
    #[LiveProp] public ?string $nextCursor = null;
    /** @var list<array<string,string>> */ #[LiveProp] public array $item = [];
    #[LiveProp(writable: true)] public string $selectedId = '';
    #[LiveProp] public array $message = [];
    #[LiveProp] public array $error = [];
    #[LiveProp] public array $form = ['id' => '', 'slug' => '', 'name' => '', 'locale' => 'en', 'status' => 'active'];
    public function __construct(private readonly InterfaceScreenActionRunner $runner, private readonly InterfaceBaseContextProviderInterface $contextProvider)
    {
    }

    public function __invoke(): void
    {
    }

    #[LiveAction]
    public function refresh(): void
    {
        $this->runList();
    }

    #[LiveAction]
    public function open(string $id): void
    {
        $this->selectedId = $id;
        $this->runOpen($id);
    }

    #[LiveAction]
    public function save(): void
    {
        $this->runSave();
        $this->runList();
    }

    #[LiveAction]
    public function loadNext(): void
    {
        $this->cursor = $this->nextCursor;
        $this->runList();
    }

    private function runList(): void
    {
        $res = $this->runner->run(InterfaceScreenId::of('category-admin'), InterfaceActionId::of('category.list'), ['q' => $this->q, 'cursor' => $this->cursor, 'limit' => 25], $this->contextProvider->provide());
        $this->applyResult($res);
        if ($res->isOk()) {
            $this->item = (array) ($res->data()['item'] ?? []);
            $this->nextCursor = isset($res->data()['nextCursor']) ? (string) $res->data()['nextCursor'] : null;
        }
    }

    private function runOpen(string $id): void
    {
        $res = $this->runner->run(InterfaceScreenId::of('category-admin'), InterfaceActionId::of('category.open'), ['id' => $id], $this->contextProvider->provide());
        $this->applyResult($res);
        if ($res->isOk()) {
            $data = (array) ($res->data()['category'] ?? []);
            $model = new InterfaceCategoryFormInput();
            $model->fillFromArray($data);
            $this->form = $model->toPayload();
        }
    }

    private function runSave(): void
    {
        $res = $this->runner->run(InterfaceScreenId::of('category-admin'), InterfaceActionId::of('category.save'), ['payload' => $this->form], $this->contextProvider->provide());
        $this->applyResult($res);
        if ($res->isOk()) {
            $data = (array) ($res->data()['category'] ?? []);
            $model = new InterfaceCategoryFormInput();
            $model->fillFromArray($data);
            $this->form = $model->toPayload();
            $this->selectedId = $model->id;
        }
    }

    private function applyResult(InterfaceActionResult $res): void
    {
        $this->message = array_map(static fn (InterfaceUiMessageInterface $m): array => ['level' => $m->type(), 'text' => $m->text()], $res->messageList());
        $this->error = array_map(static fn (InterfaceUiErrorInterface $e): array => ['field' => $e->path(), 'message' => $e->text()], $res->error());
    }
}
