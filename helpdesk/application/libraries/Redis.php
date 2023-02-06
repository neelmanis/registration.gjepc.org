<?php
    Class redis{
        function config(){
            $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'scanapp-redis-node.kkquph.ng.0001.aps1.cache.amazonaws.com',
            'port'   => 6379,
            // 'database'=> 1
            ]);
            return $client;
        }
    }
?>