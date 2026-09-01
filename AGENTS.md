# AGENTS.md

## Purpose
Legacy text randomizer and ad generator project with two runtimes:
- WordPress plugin mode.
- Standalone CLI mode.

## Repository Role
- Category: legacy utility / WordPress plugin.
- Main plugin entrypoint: `ad-generator.php`.
- Main CLI entrypoint: `ad-generator-cli.php`.

## WordPress Plugin Mode
- Plugin shortcode: `[ad_generator]`.
- Core randomization engine: `includes/Randomizer.php` (+ `includes/Node.php`).
- Current compatibility baseline: WordPress 7.0 or newer and PHP 8.3 or newer.
- Localization files are in `languages/`.

## CLI Mode
- Usage example: `php ad-generator-cli.php -n 300 -f template.txt -o result.txt`.
- Required argument: template file via `-f` / `--file`.
- Optional arguments:
  - `-n` / `-N` number of variants (default `300`).
  - `-o` / `--out` output file (default `result-N.txt`).
  - `-h` / `--help` help.

## Syntax Contract
- Alternatives: `{a|b|c}`.
- Optional block: `{|text}`.
- Permutations: `[a|b|c]`.
- Permutations with delimiter: `[+,+a|b|c]`.
- Random digit: `%rand%`.
- Escaping: `\{`, `\}`, `\|`, `\[`, `\]`, `\+`, `\\`.

## AI Working Notes
- Treat the parser and its public syntax as legacy: avoid broad refactors unless explicitly requested.
- Keep randomization syntax backward-compatible (plugin and CLI share same engine).
- Keep shortcode name `[ad_generator]` unchanged for existing WP pages.
- Preserve CLI argument compatibility and output defaults to avoid breaking existing scripts.
