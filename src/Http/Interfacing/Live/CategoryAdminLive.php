<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Http\Interfacing\Live;

use App\Domain\Interfacing\Model\ActionResult;
use App\Domain\Interfacing\Model\CategoryFormModel;
use App\Domain\Interfacing\Model\UiErrorBag;
use App\Domain\Interfacing\Model\UiMessage;
use App\Domain\Interfacing\Value\ActionId;
use App\Domain\Interfacing\Value\ScreenId;
use App\Service\Interfacing\ActionRunner;
use App\ServiceInterface\Interfacing\BaseContextProviderInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('InterfacingCategoryAdmin', template: 'component/InterfacingCategoryAdmin.html.twig')]
final class CategoryAdminLive
{
    #[LiveProp(writable: true)]
    public string $q = '';

    #[LiveProp(writable: true)]
    public ?string $cursor = null;

    #[LiveProp]
    public ?string $nextCursor = null;

    /** @var list<array<string,string>> */
    #[LiveProp]
    public array $item = [];

    #[LiveProp(writable: true)]
    public string $selectedId = '';

    #[LiveProp]
    public array $message = [];

    #[LiveProp]
    public array $error = [];

    #[LiveProp]
    public array $form = ['id' => '', 'slug' => '', 'name' => '', 'locale' => 'en', 'status' => 'active'];

    public function __construct(private ActionRunner $runner, private BaseContextProviderInterface $contextProvider) {}

    #[LiveAction]
    public function refresh(): void { $this->runList(); }

    #[LiveAction]
    public function open(string $id): void { $this->selectedId = $id; $this->runOpen($id); }

    #[LiveAction]
    public function save(): void { $this->runSave(); $this->runList(); }

    #[LiveAction]
    public function loadNext(): void { $this->cursor = $this->nextCursor; $this->runList(); }

    private function runList(): void
    {
        $res = $this->runner->run(ScreenId::of('category-admin'), ActionId::of('category.list'),
            ['q' => $this->q, 'cursor' => $this->cursor, 'limit' => 25],
            $this->contextProvider->provide()
        );
        $this->applyResult($res);
        if ($res->isOk()) {
            $this->item = (array)($res->data()['item'] ?? []);
            $this->nextCursor = isset($res->data()['nextCursor']) ? (string)$res->data()['nextCursor'] : null;
        }
    }

    private function runOpen(string $id): void
    {
        $res = $this->runner->run(ScreenId::of('category-admin'), ActionId::of('category.open'),
            ['id' => $id],
            $this->contextProvider->provide()
        );
        $this->applyResult($res);
        if ($res->isOk()) {
            $data = (array)($res->data()['category'] ?? []);
            $model = new CategoryFormModel();
            $model->fillFromArray($data);
            $this->form = $model->toPayload();
        }
    }

    private function runSave(): void
    {
        $res = $this->runner->run(ScreenId::of('category-admin'), ActionId::of('category.save'),
            ['payload' => $this->form],
            $this->contextProvider->provide()
        );
        $this->applyResult($res);
        if ($res->isOk()) {
            $data = (array)($res->data()['category'] ?? []);
            $model = new CategoryFormModel();
            $model->fillFromArray($data);
            $this->form = $model->toPayload();
            $this->selectedId = $model->id;
        }
    }

    private function applyResult(ActionResult $res): void
    {
        $this->message = array_map(static fn(UiMessage $m): array => ['level' => $m->level(), 'text' => $m->text()], $res->messageList());

        $bag = $res->error();
        if ($bag instanceof UiErrorBag) {
            $this->error = array_map(static fn($e): array => ['field' => $e->field(), 'message' => $e->message()], $bag->all());
        } else {
            $this->error = [];
        }
    }
}
