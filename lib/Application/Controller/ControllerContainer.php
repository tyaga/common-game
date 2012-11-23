<?

namespace Application\Controller;

class ControllerContainer {

	private $buffer = [];
	private $app;

	public function __construct($app) {
		$this->app = $app;
	}

	public function put() {
		$this->buffer[] = func_get_args();
	}

	public function run() {
		$result = [];

		$i = 0;
		while ($i < count($this->buffer)) {
			$item = $this->buffer[$i];

			$controller_name_raw = $item[0];
			$method_name_raw = $item[1];
			$in = isset($item[2]) ? $item[2] : false;

			$controller_name = '\\Application\\Controller\\'.ucfirst($controller_name_raw)."Controller";
			$method_name = 'execute'.ucfirst($method_name_raw);

			try {
				/** @var $controller \Application\Controller\ControllerBase */
				$controller = new $controller_name($this->app, $in);
				$result[$controller_name_raw . "->" . $method_name_raw] = $controller->$method_name();

				$controller->processAnnotations($method_name);
			}
			catch (\Exception $e) {
				//
			}
			$i++;
		}
		return $result;
	}

}