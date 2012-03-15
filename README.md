BuzzProfilerBundle is a Symfony2 bundle which logs Buzz clients, in Profiler.

To log your Buzz clients in the DataCollector, you have to instanciate Buzz client services like that:

        <service id="acme.buzz.client" class="Acme\AcmeBundle\Buzz\Client\Client">
            <tag name="buzz.client" />
        </service>