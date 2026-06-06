#!/usr/bin/env node
import { existsSync, readFileSync } from 'node:fs';
import { resolve } from 'node:path';

const workspaceRoot = resolve(import.meta.dirname, '..');
const repositoryRoot = resolve(workspaceRoot, '../..');
const mode = process.argv.includes('--public') ? 'public' : 'source';
const errors = [];

function pathFromRoot(path) {
  return resolve(repositoryRoot, path);
}

function read(path) {
  const absolutePath = pathFromRoot(path);

  if (!existsSync(absolutePath)) {
    errors.push(`Missing required file: ${path}`);
    return '';
  }

  return readFileSync(absolutePath, 'utf8');
}

function requireIncludes(content, needle, label) {
  if (!content.includes(needle)) {
    errors.push(`${label} must contain: ${needle}`);
  }
}

function requireMatch(content, pattern, label) {
  if (!pattern.test(content)) {
    errors.push(`${label} does not match ${pattern}`);
  }
}

function parseComponents(content, providerName) {
  const match = content.match(/components:\s*\[([\s\S]*?)\]/m);

  if (!match) {
    errors.push(`${providerName} provider is missing components array.`);
    return [];
  }

  return Array.from(match[1].matchAll(/'([^']+)'/g)).map((componentMatch) => componentMatch[1]);
}

function requireComponents(actual, expected, providerName) {
  const duplicates = actual.filter((component, index) => actual.indexOf(component) !== index);

  if (duplicates.length > 0) {
    errors.push(`${providerName} provider has duplicate components: ${Array.from(new Set(duplicates)).join(', ')}`);
  }

  for (const component of expected) {
    if (!actual.includes(component)) {
      errors.push(`${providerName} provider is missing component: ${component}`);
    }
  }
}

function assertSourceContract() {
  const viteConfig = read('.interfacing/workspace/vite.config.ts');
  const providerAssets = read('templates/shell/partial/provider_assets.html.twig');
  const canonicalProviders = read('.interfacing/workspace/src/provider/canonical-providers.ts');
  const registryEntrypoint = read('.interfacing/workspace/src/provider/provider-registry.ts');
  const runtime = read('.interfacing/workspace/src/provider/runtime.ts');
  const antdProvider = read('.interfacing/workspace/src/provider/providers/antd-pro.tsx');
  const primeProvider = read('.interfacing/workspace/src/provider/providers/primereact.tsx');
  const antdWorkbench = read('.interfacing/workspace/src/provider/component/antd-pro-workbench.tsx');

  for (const inputNeedle of [
    "'provider-registry'",
    "'canonical-providers'",
    'runtime:',
    "'providers/antd-pro'",
    "'providers/primereact'",
    "'canonical-providers.interfacing-interface-ui'"
  ]) {
    requireIncludes(viteConfig, inputNeedle, 'Vite provider input contract');
  }

  for (const assetPath of [
    'provider/canonical-providers.interfacing-interface-ui.css',
    'provider/provider-registry.js',
    'provider/canonical-providers.js',
    'provider/providers/antd-pro.js',
    'provider/providers/primereact.js',
    'provider/runtime.js'
  ]) {
    requireIncludes(providerAssets, assetPath, 'Twig provider asset contract');
  }

  requireIncludes(canonicalProviders, "import './provider-registry'", 'Canonical provider entrypoint');
  requireIncludes(canonicalProviders, "./providers/antd-pro", 'Canonical provider entrypoint');
  requireIncludes(canonicalProviders, "./providers/primereact", 'Canonical provider entrypoint');
  requireIncludes(registryEntrypoint, 'exposeRegistry()', 'Provider registry entrypoint');
  requireIncludes(runtime, 'mountAll(document)', 'Provider runtime entrypoint');

  requireMatch(antdProvider, /export\s+const\s+antdProProvider\s*:/, 'AntD provider export');
  requireIncludes(antdProvider, 'registry.register(antdProProvider)', 'AntD provider registration');
  requireIncludes(antdProvider, "React.lazy(() => import('../component/antd-pro-workbench'))", 'AntD provider lazy workbench split');
  requireComponents(parseComponents(antdProvider, 'AntD'), [
    'navigation-menu',
    'domain-workbench',
    'domain-surface',
    'workbench',
    'provider-handoff'
  ], 'AntD');

  requireMatch(primeProvider, /export\s+const\s+primeReactProvider\s*:/, 'PrimeReact provider export');
  requireIncludes(primeProvider, 'registry.register(primeReactProvider)', 'PrimeReact provider registration');
  requireComponents(parseComponents(primeProvider, 'PrimeReact'), [
    'navigation-menu',
    'domain-diagnostic-card',
    'diagnostic-card',
    'domain-surface',
    'workbench'
  ], 'PrimeReact');

  requireIncludes(antdWorkbench, '@ant-design/pro-components', 'AntD workbench heavy component boundary');
  requireIncludes(antdWorkbench, 'ProTable', 'AntD workbench heavy component boundary');
}

function assertPublicContract() {
  const requiredPublicFiles = [
    'public/provider/manifest.json',
    'public/provider/canonical-providers.interfacing-interface-ui.css',
    'public/provider/provider-registry.js',
    'public/provider/canonical-providers.js',
    'public/provider/providers/antd-pro.js',
    'public/provider/providers/primereact.js',
    'public/provider/runtime.js'
  ];

  for (const path of requiredPublicFiles) {
    if (!existsSync(pathFromRoot(path))) {
      errors.push(`Missing built provider asset: ${path}`);
    }
  }

  const manifestPath = pathFromRoot('public/provider/manifest.json');

  if (!existsSync(manifestPath)) {
    return;
  }

  let manifest = {};

  try {
    manifest = JSON.parse(readFileSync(manifestPath, 'utf8'));
  } catch (error) {
    errors.push(`Provider manifest is not valid JSON: ${error instanceof Error ? error.message : String(error)}`);
    return;
  }

  const emittedFiles = Object.values(manifest)
    .filter((entry) => entry && typeof entry === 'object' && typeof entry.file === 'string')
    .map((entry) => entry.file);

  for (const emittedFile of [
    'provider-registry.js',
    'canonical-providers.js',
    'runtime.js',
    'providers/antd-pro.js',
    'providers/primereact.js'
  ]) {
    if (!emittedFiles.includes(emittedFile)) {
      errors.push(`Provider manifest is missing emitted file: ${emittedFile}`);
    }
  }
}

if (mode === 'public') {
  assertPublicContract();
} else {
  assertSourceContract();
}

if (errors.length > 0) {
  console.error(`Interfacing provider ${mode} contract failed:`);

  for (const error of errors) {
    console.error(`- ${error}`);
  }

  process.exit(1);
}

console.log(`Interfacing provider ${mode} contract passed.`);
