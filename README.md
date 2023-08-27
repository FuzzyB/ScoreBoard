# Notes
Because of that in the requirements was to use in-memory solution, I dropped an idea to create controller and visualisation. 

- The main class is: App\GameManager
- The start game method: 'startGame'
- Finish game method: 'finishGame'
- Update game method: 'updatePoints'
- Get summary games by total points method: 'getSummaryByTotalPoints' (tests: GameManagerTest::summaryString())

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull --wait` to start the project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Docs

1. [Build options](docs/build.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using a Makefile](docs/makefile.md)
8. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.
