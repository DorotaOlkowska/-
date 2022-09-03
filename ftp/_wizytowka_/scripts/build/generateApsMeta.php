<?php
$root = dirname(dirname(dirname((dirname(__FILE__)))));

if(!isset($argv[1]) || !isset($argv[2])){
    print "No require parameter [version] [release]\n";
    exit (1);
}

//genrate APP-LIST.xml
$directory = new RecursiveDirectoryIterator ($root);
$iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

$pattern =  '<file sha256="%s" size="%s" name="%s"/>';
$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<files xmlns="http://apstandard.com/ns/1" xmlns:ns2="http://www.w3.org/2000/09/xmldsig#">
    %s
</files>';

$size = 0;
$contentXmlString = '';
foreach($iterator as $name => $object){
    if($object->isFile()){
        $fileName = str_replace($root.'/', '', $name);

        $pathsToSkip = array(
            $root.'/htdocs/vendor',
            $root.'/htdocs/composer.lock',
            $root.'/htdocs/composer.json',
            $root.'/.git',
            $root.'/htdocs/tests',
            $root.'/htdocs/public/captcha/images',
            $root.'/htdocs/data/logs',
        );

        if(!cannotAdd($name, $pathsToSkip)){
//            echo $name."\n";
            $size += $object->getSize();
            $contentXmlString.=sprintf($pattern, hash_file('sha256', $name), $object->getSize(), $fileName);
        }
    }
}
file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))).'/APP-LIST.xml',sprintf($xml, $contentXmlString));
echo "[Genrated] APP-LIST.xml\n";

//genrate APP-META.xml
$version = $argv[1];
$release = $argv[2];

$xmlstring = simplexml_load_file($root.'/APP-META-dist.xml');
$xmlstringnewcontent = sprintf($xmlstring->asXML(), $version, $release, $size);
file_put_contents($root.'/APP-META.xml',$xmlstringnewcontent);

echo "[Genrated] APP-META.xml";
echo "\t[Size]: " .$size."\n";
return true;

function cannotAdd($name, $paths){
    foreach($paths as $path){
        if(0 === strpos($name,$path)){
            return true;
        }
    }
    return false;
}
