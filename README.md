# BuzzProfileBundle

BuzzProfilerBundle is a Symfony2 bundle which logs [Buzz](http://github.com/kriswallsmith/Buzz) clients, in Profiler.

# How to use

To log your Buzz clients in the DataCollector, you have to instanciate Buzz client services like that:

        <service id="acme.buzz.client" class="Acme\AcmeBundle\Buzz\Client\Client">
            <tag name="buzz.client" />
        </service>

# More resources

* [Licence](http://github.com/juliendidier/BuzzProfilerBundle/blob/master/LICENCE)
* [BuzzBundle, for Symfony2](http://github.com/juliendidier/BuzzBundle)
