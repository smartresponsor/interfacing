Interfacing sketch-17: developer ergonomics

Goal
- Reduce boilerplate for registering screens and actions.
- Provide a small DSL for building specs without verbose constructors.

1) Attribute registration
Add attributes to your screen/action classes:

#[InterfaceAsScreen(
  id: 'category.admin',
  title: 'Category Admin',
  navGroup: 'Catalog',
  navOrder: 10,
)]
final class CategoryAdminScreenDescriptor implements InterfaceScreenDescriptorInterface
{
  public function screenId(): string { return 'category.admin'; }
  public function title(): string { return 'Category Admin'; }
  public function navGroup(): ?string { return 'Catalog'; }
  public function navOrder(): int { return 10; }
  public function isVisible(): bool { return true; }
}

#[InterfaceAsAction(
  screenId: 'category.admin',
  id: 'save',
  title: 'Save',
)]
final class CategoryAdminSaveAction implements InterfaceActionEndpointInterface
{
  public function screenId(): string { return 'category.admin'; }
  public function actionId(): string { return 'save'; }
  public function title(): string { return 'Save'; }
  public function order(): int { return 10; }

  public function handle(InterfaceActionRequest $request): InterfaceActionResult
  {
    return InterfaceActionResult::ok();
  }
}

1) Builders
Use builders to produce specs:

$form = InterfaceFormSpecBuilderService::create('category.edit')
  ->text('name', label: 'Name', required: true)
  ->slug('slug', label: 'Slug', required: true)
  ->select('status', label: 'Status', option: ['draft' => 'Draft', 'live' => 'Live'])
  ->submit('save', label: 'Save')
  ->build();

1) Catalog bootstrap
InterfaceCatalogCompilerPass collects:
- services annotated with InterfaceAsScreen and registers them into InterfaceScreenCatalogService
- services annotated with InterfaceAsAction and registers them into InterfaceActionCatalogService
