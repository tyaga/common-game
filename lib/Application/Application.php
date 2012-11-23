<? namespace Application;

class Application extends \Silex\Application {

	public function __construct($config) {
		parent::__construct();

		$app = $this;

		$app['debug'] = $config['debug'];
		unset($config['debug']);

		$app['config'] = $config;

		$app['controller_container'] = $app->share(function() use($app) {
			return new Controller\ControllerContainer($app);
		});

		$app->match('/run.{format}', function() use ($app) {
			$app['controller_container']->put(
				$app['request']->get('controller'),
				$app['request']->get('method'),
				$app['request']->get('in')
			);
			$result = $app['controller_container']->run();

			return $app->render($result);
		});

		$app->register(new \Silex\Provider\DoctrineServiceProvider(), [
			'db.options' => $config['db.options'],
		]);

	}

	public function render($result) {
		$app = $this;

		switch($app['request']->get('format')) {
			case "debug":
				if (!$app['debug']) return '';
				kintLite($result);
				return '';

			case 'json':
				return $app->json($result);
		}
	}

}
