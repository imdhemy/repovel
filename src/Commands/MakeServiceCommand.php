<?php

namespace Imdhemy\Repovel\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceCommand extends GeneratorCommand
{
     /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:service';

     /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

      /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }

        if ($this->option('request')) {
            $this->createRequest();
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('request')) {
            $request = Str::studly(class_basename($this->argument('name')));
            $this->request = "{$request}Request";
            return __DIR__ . '/stubs/service-with-request.stub';
        }
        return __DIR__.'/stubs/service.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace. config('repovel.services.namespace');
    }

    /**
     * Create form request for the service
     *
     * @return void
     */
    protected function createRequest()
    {
        $this->call('make:request', ['name' => $this->request]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service already exists.'],
            ['request', 'r', InputOption::VALUE_NONE, 'Create service class and a request class.'],
        ];
    }
}
