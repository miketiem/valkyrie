<?php

namespace MikeTiEm\Valkyrie\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class GenerateModelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'valkyrie:model
                            {name : The name of the class}
                            {--a|all : Generate a migration, resource controller and repository for the model}
                            {--m|migration : Create a new migration file for the model}
                            {--r|resource : Create a new resource controller for the model}
                            {--d|detail : Specifies if given model is master-detail transaction}
                            {--e|exclude : Generates model outside Model folder }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Valkyrie model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/model.stub';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        if ($this->option('all')) {
            $this->input->setOption('migration', true);
            $this->input->setOption('resource', true);
        }

        if ($this->option('migration')) {
            $this->createMigration();
        }

        if ($this->option('resource')) {
            $this->createResource();
            $this->createRepository();
            $this->createController();
        }
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return $this->setModelFolder() . trim($this->argument('name'));
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a resource file for the model.
     *
     * @return void
     */
    protected function createResource()
    {
        $class = $this->argument('name');

        $this->call('make:resource', [
            'name' => "{$class}Resource"
        ]);
    }

    protected function createRepository()
    {
        $class = $this->argument('name');
        $model = $this->getNameInput();

        $params = [
            'name' => "{$class}Repository",
            '--model' => $model,
            '--resource' => "Http/Resources/{$class}Resource"
        ];

        if ($this->option('detail')) {
            $params = array_merge($params, ['--detail' => true]);
        }

        $this->call('valkyrie:repository', $params);
    }

    protected function createController()
    {
        $class = $this->argument('name');
        $model = $this->getNameInput();

        $this->call('valkyrie:controller', [
            'name' => "{$class}Controller",
            '--model' => $model,
            '--repository' => "Repositories/{$class}Repository"
        ]);
    }

    /**
     * Set the model folder if not excluded.
     *
     * @return string
     */
    protected function setModelFolder(): string
    {
        return (!$this->option('exclude') ? 'Model/' : '');
    }

}