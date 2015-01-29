<?php
/** [TITLE] class file
 * Created on 2013-03-18 at 22:04
 * @copyright Toog SARL (Nantes, France) 2013
 * @author Ronan - @arno_u_loginlux
 * @link http://http://www.toog.fr
 * @license :  see the LICENSE file this source code was distribued with
 * @version //autogentag//
 */

require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Response;

use PhpGpio\Gpio;

$app = new Silex\Application();

$app->get('/blink/{id}', function ($id) use ($app) {
    $msg = exec("sudo -t /usr/bin/php ../blinker $id 90000");
    $code = ("" === trim($msg)) ? 200 : 500;
    return new Response($msg, $code);
});

$app->get('/message/{str}', function ($str) use ($app) {
  $str = '"' . urldecode($str) . '"';
  $msg = exec("sudo -t /usr/bin/php ../number $str");
  $code = ("" === trim($msg)) ? 200 : 500;
  return new Response($msg, $code);
});


$app->get('/', function () use ($app) {
    require_once __DIR__.'/buttons.html';
    return "";
});


$app->get('/input/{id}', function ($id) use ($app) {
  $msg = exec("sudo -t /usr/bin/php ../reader $id");
  $code = ("" === trim($msg)) ? 200 : 500;

  if (!$id) {
    $error = array('message' => 'Must specify an id');
    return $app->json($error, 404);
  }

  return $app->json(array('message' => $msg));
});


$app['debug'] = true;
$app->run();

?>

