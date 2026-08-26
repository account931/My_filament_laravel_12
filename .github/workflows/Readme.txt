CI flow for github actions Filament Laravel 12. Runs on every push to main branch.



So far, have 6 jobs:
1. Pest tests and codesniffer (was PhpUnit test in Laravel 6)
2. PhpStan static analysis (was Psalm check in Laravel 6)
3. Run Dokerfile and docker-compose.yml test. We build images -> run containers -> check php/console command/sql connectiom/Pest tests in container.
  NB: Since we run it in github CI, there is no .env, we have to create it manually?. When we start Laravel on Docker in normal way on localhost, there is always an .env.
 ( NB: Following is False now and was True n Laravel 6 only:Info: we do this wierd test, as can not test Dokerfile and docker-compose.yml in normal way on localhost, since Docker in not supported on Win 7 we use.)

4. Pint check in container (was Codesniffer check in Laravel 6)
5. Deploy one file 'last-deploy-info.php' to alwaysdata.com to folder/MyFilament_Laravel12  
6. Job-6 send notification "Deploy successful" to telegram 



NB: manual-deploy-to-run-1-time-only.yml => This deploy to production is run manually and one time only. To be triggered by a button in the GitHub Actions UI.
It includes set-up necessary one time only, like Laravel new application key generate, Passport key generating
