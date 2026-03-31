Interfacing quick start (sketch-18)

1) Copy into your Symfony app (or include as path repository).
2) Ensure Twig path includes /template (see config/packages/twig.yaml).
3) Import services config:
   - config/services/interfacing.yaml
4) Make sure Symfony UX LiveComponent is installed if you expand UI components.
5) Verify:
   - php bin/console interfacing:doctor
   - open /interfacing/doctor
