Installation
============

  1. Add this bundle and Kris Wallsmith's Buzz library to your project as Git submodules:

        $ git submodule add git://github.com/kriswallsmith/Buzz.git vendor/buzz
        $ git submodule add git://github.com/juliendidier/BuzzProfilerBundle.git vendor/bundles/Buzz/Bundle/ProfilerBundle

  Or in your deps file:

        [buzz]
            git=http://github.com/kriswallsmith/Buzz.git

        [JMSSecurityExtraBundle]
            git=http://github.com/juliendieir/BuzzProfilerBundle.git
            target=/bundles/Buzz/Bundle/ProfilerBundler


  2. Add the `Buzz` library and this bundle to your project's autoloader bootstrap script:

        // src/autoload.php
        $loader->registerPrefixes(array(
            'Buzz' => array(__DIR__.'/../vendor/buzz/lib', __DIR__.'/../vendor/bundles'),
        ));

  3. Add this bundle to your application's kernel:

        // application/ApplicationKernel.php
        public function registerBundles()
        {
            // ...
            if (in_array($this->getEnvironment(), array('dev', 'test'))) {
                $bundles[] = new Buzz\Bundle\ProfilerBundle\BuzzProfilerBundle();
                // ...
            }
            // ...
        }

Using Buzz Profiler
-------------------

To log your Buzz clients in the DataCollector, you have to decorate the ClientInterface object with a new DebugClient object,
like that :

        $request    = new Message\Request('GET', '', 'http://www.google.fr');
        $response   = new Message\Response();
        $client     = new Client\Curl();

        if ($this->has('buzzprofiler.client_registry')) {
            $client = new DebugClient($client);
            $this->get('buzzprofiler.client_registry')->register($client);
        }

        $client->send($request, $response);

The service `buzzprofiler.client_registry` is only built on dev/test environement.