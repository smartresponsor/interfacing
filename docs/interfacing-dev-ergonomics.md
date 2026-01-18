Interfacing sketch-17: developer ergonomics

Goal
- Reduce boilerplate for registering screens and actions.
- Provide a small DSL for building specs without verbose constructors.

1) Attribute registration
Add attributes to your screen/action classes:

#[AsInterfacingScreen(
  id: 'category.admin',
  title: 'Category Admin',
  navGroup: 'Catalog',
  navOrder: 10,
)]
final class CategoryAdminScreenDescriptor implements ScreenDescriptorInterface
{
  public function screenId(): string { return 'category.admin'; }
  public function title(): string { return 'Category Admin'; }
  public function navGroup(): ?string { return 'Catalog'; }
  public function navOrder(): int { return 10; }
  public function isVisible(): bool { return true; }
}

#[AsInterfacingAction(
  screenId: 'category.admin',
  id: 'save',
  title: 'Save',
)]
final class CategoryAdminSaveAction implements ActionEndpointInterface
{
  public function screenId(): string { return 'category.admin'; }
  public function actionId(): string { return 'save'; }
  public function title(): string { return 'Save'; }
  public function order(): int { return 10; }

  public function handle(ActionRequest $request): ActionResult
  {
    return ActionResult::ok();
  }
}

2) Builders
Use builders to produce specs:

$form = FormSpecBuilder::create('category.edit')
  ->text('name', label: 'Name', required: true)
  ->slug('slug', label: 'Slug', required: true)
  ->select('status', label: 'Status', option: ['draft' => 'Draft', 'live' => 'Live'])
  ->submit('save', label: 'Save')
  ->build();

3) Catalog bootstrap
InterfacingCatalogCompilerPass collects:
- services annotated with AsInterfacingScreen and registers them into ScreenCatalog
- services annotated with AsInterfacingAction and registers them into ActionCatalog
