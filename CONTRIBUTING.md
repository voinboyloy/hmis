# Contributing

Thank you for your interest in contributing!

Quick local checks
- PHP 8.1+ recommended
- composer install
- Run code style: ./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --dry-run
- Run static analysis: ./vendor/bin/phpstan analyse -c phpstan.neon
- Run tests: ./vendor/bin/phpunit

Branching & PRs
- Create a feature branch: git checkout -b feat/short-description
- Run the checks above locally and include any relevant test(s)
- Open a Pull Request targeting main (or master)
- Use a descriptive title and include the motivation and testing performed

PR checklist
- [ ] Tests added (where applicable)
- [ ] Code follows PSR-12 / php-cs-fixer rules
- [ ] Static analysis passes (or attach note about suppressed issues)
- [ ] CI is green

Roadmap & issues
- If you plan to work on a larger change, open an issue first to discuss.
