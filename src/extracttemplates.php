<?php
/*
Copyright [2010] [GFZ German Research Centre for Geosciences]
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/
namespace escidoc;
ini_set("include_path",ini_get("include_path").":/var/www/panmetaworks/classes/escidoc/escidocPHP");


require_once 'resources/om/item/Item.php';
require_once 'resources/om/container/Container.php';
require_once 'resources/om/context/Context.php';
require_once 'resources/SearchRetrieveResponse.php';

//minimaler container

$container=new Container(file_get_contents("templates/container.xml"));

//minimaler context
$item=new Item(file_get_contents("templates/item.xml"));


echo "\n\n-------------------get empty MD-Record of an item-----------------\n\n";
echo $item->getMetadataRecords()->get("escidoc");


echo "\n\n-------------------get modified MD-Record -----------------\n\n";
$item->getMetadataRecords()->get("escidoc")->setMdType("mdtype");
$item->getMetadataRecords()->get("escidoc")->setSchema("schema");
$item->getMetadataRecords()->get("escidoc")->setContent("<test>Das ist ein Test</test>");
echo $item->getMetadataRecords()->get("escidoc");


echo "\n\n---------------get empty components-----------------\n\n";
echo $item->getComponents();

echo "\n\n--------------------get modified components----------\n\n";
$item->getComponents()->add(new Component());
echo $item->getComponents();


echo "\n\n---------------------cleared components--------------------------\n\n";
$item->getComponents()->clear();
echo $item->getComponents();

echo "\n\n---------------------the edited item so far----------------------\n\n";
echo $item;


echo "\n\n---------------------reference to an item------------------------\n\n";
echo $item->getReference();

echo "\n\n---------------------item with modified context------------------\n\n";
$context=new Context(file_get_contents("templates/context.xml"));
$item->getProperties()->setContext($context);
$item->getProperties()->setContext($context->getReference());
echo $item;

echo "\n\n---------------------a modified container------------------------\n\n";
$content="<empty/>";
foreach ($item->getComponents()->getArray() as $component)
    $content=$component->getMetadataRecords()->get("escidoc")->getContent();

$container=new Container(file_get_contents("templates/container.xml"));
$mdrecords=$container->getMetadataRecords();
$mdrecords->get("escidoc")->setContent($content);

echo $container;

?>
