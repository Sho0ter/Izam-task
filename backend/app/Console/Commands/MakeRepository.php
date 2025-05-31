<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {model}';
    protected $description = 'Create a repository and interface for a model and bind it in AppServiceProvider';

    public function handle()
    {
        $model = $this->argument('model');
        $model = Str::studly($model);
        $interfaceName = "{$model}RepositoryInterface";
        $repositoryName = "{$model}Repository";

        $interfacePath = app_path("Repository/Contracts/{$interfaceName}.php");
        $repositoryPath = app_path("Repository/{$repositoryName}.php");

        // Create directories
        if (!File::exists(app_path('Repository/Contracts'))) {
            File::makeDirectory(app_path('Repository/Contracts'), 0755, true);
        }
        if (!File::exists(app_path('Repository'))) {
            File::makeDirectory(app_path('Repository'), 0755, true);
        }

        // Create Interface
        File::put($interfacePath, <<<PHP
<?php

namespace App\Repository\Contracts;

interface {$interfaceName}
{
    //
}
PHP);

        // Create Repository
        File::put($repositoryPath, <<<PHP
<?php

namespace App\Repository;

use App\Repository\Contracts\\{$interfaceName};

class {$repositoryName} implements {$interfaceName}
{
    //
}
PHP);

        // Add binding to AppServiceProvider
        $providerPath = app_path('Providers/AppServiceProvider.php');
        $providerContent = File::get($providerPath);

        $bindStatement = "\$this->app->bind(\\App\\Repository\\Contracts\\{$interfaceName}::class, \\App\\Repository\\{$repositoryName}::class);";

        if (!Str::contains($providerContent, $bindStatement)) {
            $providerContent = preg_replace(
                '/public function register\(\)\n\s*{\n/',
                "public function register()\n    {\n        {$bindStatement}\n",
                $providerContent
            );

            File::put($providerPath, $providerContent);
        }

        $this->info("Repository and interface for {$model} created and bound successfully.");
    }
}
