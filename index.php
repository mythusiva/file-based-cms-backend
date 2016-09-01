<?php

// web/index.php
require_once __DIR__.'/vendor/autoload.php';

use ClientFileEditor\Service\FileService;
use ClientFileEditor\File;
use League\Plates\Engine as TemplatingEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse as APIResponse;

$app = new Silex\Application();

// $app['debug'] = true;
$app['viewsDirectory'] = __DIR__.'/views';

# Config
/**
 * The files should be .html and in a single level folder-structure.
 */
$app['snippetsDirectory'] = '/path/to/html/files';

$app['viewService'] = function() use ($app) {
  return new TemplatingEngine($app['viewsDirectory']);
};

$app['fileService'] = function() use ($app) {
  return new FileService(
    $fileDirectory = $app['snippetsDirectory']
  );
};

$app->get('/', function () use ($app) {

  $app['viewService']->addData([
    'files' => $app['fileService']->getFiles()
  ]);

  return $app['viewService']->render('admin_home');
});

# AJAX requests
$app->post('/saveFile', function (Request $request) use ($app) {

  $fileName     = $request->get('fileName');
  $fileContents = $request->get('fileContents');

  $listOfFiles = $app['fileService']->getFiles();

  try {

    $file = $listOfFiles[$fileName];
    $file->putContents($fileContents);

  } catch (Exception $e) {
    return APIResponse::create([
      'message' => $e->getMessage(),
      'success' => false
    ], APIResponse::HTTP_BAD_REQUEST);
  }

  return APIResponse::create([
    'success' => true
  ], APIResponse::HTTP_OK);

});

$app->run();
