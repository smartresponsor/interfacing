<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\LiveComponent\Interfacing;

use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\Dto\CategoryFormInput;
use App\Interfacing\Contract\Ui\UiErrorInterface;
use App\Interfacing\Contract\Ui\UiMessageInterface;
use App\Interfacing\Contract\ValueObject\ActionId;
use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\Service\Interfacing\ActionRunner;
use App\Interfacing\ServiceInterface\Interfacing\BaseContextProviderInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('InterfacingCategoryAdmin', template: 'component/InterfacingCategoryAdmin.html.twig')]
final class CategoryAdminLive
{

    #[LiveProp(writable: true)] public string $q = '';
    #[LiveProp(writable: true)] public ?string $cursor = null;
    #[LiveProp] public ?string $nextCursor = null;
    /** @var list<array<string,string>> */ #[LiveProp] public array $item = [];
    #[LiveProp(writable: true)] public string $selectedId = '';
    #[LiveProp] public array $message = [];
    #[LiveProp] public array $error = [];
    #[LiveProp] public array $form = ['id' => '', 'slug' => '', 'name' => '', 'locale' => 'en', 'status' => 'active'];

    public function __construct(private readonly ActionRunner $runner, private readonly BaseContextProviderInterface $contextProvider)
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
        $res = $this->runner->run(ScreenId::of('category-admin'), ActionId::of('category.list'), ['q' => $this->q, 'cursor' => $this->cursor, 'limit' => 25], $this->contextProvider->provide());
        $this->applyResult($res);
        if ($res->isOk()) {
            $this->item = (array) ($res->data()['item'] ?? []);
            $this->nextCursor = isset($res->data()['nextCursor']) ? (string) $res->data()['nextCursor'] : null;
        }
    }

    private function runOpen(string $id): void
    {
        $res = $this->runner->run(ScreenId::of('category-admin'), ActionId::of('category.open'), ['id' => $id], $this->contextProvider->provide());
        $this->applyResult($res);
        if ($res->isOk()) {
            $data = (array) ($res->data()['category'] ?? []);
            $model = new CategoryFormInput();
            $model->fillFromArray($data);
            $this->form = $model->toPayload();
        }
    }

    private function runSave(): void
    {
        $res = $this->runner->run(ScreenId::of('category-admin'), ActionId::of('category.save'), ['payload' => $this->form], $this->contextProvider->provide());
        $this->applyResult($res);
        if ($res->isOk()) {
            $data = (array) ($res->data()['category'] ?? []);
            $model = new CategoryFormInput();
            $model->fillFromArray($data);
            $this->form = $model->toPayload();
            $this->selectedId = $model->id;
        }
    }

    private function applyResult(ActionResult $res): void
    {
        $this->message = array_map(static fn (UiMessageInterface $m): array => ['level' => $m->type(), 'text' => $m->text()], $res->messageList());
        $this->error = array_map(static fn (UiErrorInterface $e): array => ['field' => $e->path(), 'message' => $e->text()], $res->error());
    }
}