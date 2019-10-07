<?php

namespace MikeTiEm\Valkyrie\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenerateRepositoryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'valkyrie:repository
                            {name : The name of the class}
                            {--m|model : Set the model name for the repository to be generated}
                            {--r|resource : Set the resource name for the repository to be generated}
                            {--d|detail : Specifies if given model is master-detail transaction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Valkyrie repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if (! $this->option('detail'))
            return __DIR__ . '/stubs/repository.stub';
        else
            return __DIR__ . '/stubs/repository.master.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
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
        $replace = $this->buildReplacements();

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function buildReplacements()
    {
        $modelClass = $this->parse($this->option('model'));
        $resourceClass = $this->parse($this->option('resource'));

        return [
            'DummyFullModelClass' => $modelClass,
            'DummyFullResourceClass' => $resourceClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyResourceClass' => class_basename($resourceClass),
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
            throw new \InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace . $model;
        }

        return $model;
    }
}