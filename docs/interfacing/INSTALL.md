Interfacing (sketch-08) install

Requirements (typical):
- PHP 8.2+
- TwigBundle
- Symfony UX LiveComponent + TwigComponent (and Stimulus runtime)

Minimal wiring (app-level):
1) Ensure routes include config/routes/interfacing.yaml
2) Ensure services include config/services/interfacing.yaml
3) Ensure Twig can see /template (singular) by loading config/packages/interfacing-twig.yaml

Verify:
- php bin/console interfacing:doctor
- open /interfacing
