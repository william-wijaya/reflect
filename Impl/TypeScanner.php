<?php
namespace Plum\Reflect\Impl;

use Composer\Autoload\ClassLoader as ComposerLoader;

class TypeScanner
{
    private $loader;

    public function __construct(ComposerLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Scans all types from given namespace
     *
     * @param string $ns
     *
     * @return array
     */
    public function scan($ns)
    {
        $ns = trim($ns, "\\")."\\";
        $prefixes = array_merge(
            $this->loader->getPrefixes(),
            $this->loader->getPrefixesPsr4()
        );
        $paths = [];
        foreach ($prefixes as $prefix => $path) {
            if ($prefix === $ns || strpos($prefix, $ns) === 0) {
                $paths = array_merge($paths, $path);
            } else if (strpos($ns, $prefix) === 0) {
                $trail = trim(substr($ns, strlen($prefix)), "\\");
                $path = array_map(function($p) use ($trail) {
                    return rtrim($p, "/")."/".$trail;
                }, $path);

                $paths = array_merge($paths, $path);
            }
        }

        $paths = array_map(function($path) {
            return new \SplFileInfo($path);
        }, $paths);
        $paths = new \ArrayIterator($paths);
        $paths = new \CallbackFilterIterator(
            $paths, function(\SplFileInfo $file) {
                return $file->isDir() && $file->isReadable();
            }
        );

        $i = new \AppendIterator();
        foreach ($paths as $path) {
            $dir = new \RecursiveDirectoryIterator((string)$path);
            $rec = new \RecursiveIteratorIterator($dir);

            $i->append($rec);
        }
        $filtered = new \CallbackFilterIterator(
            $i, function(\SplFileInfo $file) {
                return $file->getExtension() === "php";
            }
        );
        foreach ($filtered as $file) {
            require_once (string)$file;
        }
        $names = array_merge(
            get_declared_classes(),
            get_declared_interfaces()
        );

        return array_filter($names, function($name) use ($ns) {
            return strpos($name, $ns) === 0;
        });
    }
} 
