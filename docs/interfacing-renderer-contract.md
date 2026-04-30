# Interfacing renderer contract

Interfacing owns the rendering contract that external bridge layers consume.

Current contract:
- `App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface`
- default implementation: `App\Interfacing\Service\Interfacing\Presentation\TwigInterfacingRenderer`

Bridge packages should consume this interface rather than implement rendering logic themselves.
