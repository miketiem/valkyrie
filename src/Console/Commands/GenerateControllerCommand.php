<?php

namespace MikeTiEm\Valkyrie\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenerateControllerCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'valkyrie:controller
                            {name : The name of the class}
                            {--m|model : Set the model name for the controller to be generated}
                            {--r|repository : Set the repository name for the controller to be generated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Valkyrie controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = $this->buildReplacements();

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function buildReplacements()
    {
        $modelClass = $this->parse($this->option('model'));
        $repositoryClass = $this->parse($this->option('repository'));

        return [
            'DummyFullModelClass' => $modelClass,
            'DummyFullRepositoryClass' => $repositoryClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyRepositoryClass' => class_basename($repositoryClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
        ];
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parse($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new \InvalidArgumentException('Class name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace . $model;
        }

        return $model;
    }
}