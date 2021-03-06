<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
     ->files()
     ->name("*.php")
     ->exclude("node_modules")
     ->exclude("resources")
     ->exclude("database")
     ->exclude("config")
     ->exclude("routes")
     ->exclude("bootstrap")
     ->exclude("storage")
     ->exclude("vendor")
     ->in(__DIR__ ."/app");

return new Sami($iterator, [
     "theme" => "default",
     "title" => "Railrota",
     "build_dir" => __DIR__ . "/docs/build",
     "cache_dir" => __DIR__ . "/docs/cache",
]);
