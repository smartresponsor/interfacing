# Interfacing renderer contract

Interfacing owns the rendering contract that external bridge layers consume.

Current contract:
- `App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface`
- default implementation: `App\Interfacing\Service\Rendering\InterfaceTwigRendererService`

Bridge packages should consume this interface rather than implement rendering logic themselves.
