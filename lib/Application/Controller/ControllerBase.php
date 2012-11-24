<?

namespace Application\Controller;

class ControllerBase {
	private $in;
	protected $app;

	public function __construct($app, $in) {
		$this->app = $app;
		$this->in = $in;
	}

	public function processAnnotations($method) {
		$comment = (new \ReflectionMethod(get_class($this), $method))->getDocComment();
		if (!$comment) return;

		$comment_arr = array_map(function($s) {
			return trim(str_replace(["/**", "*/", "*"], "", $s));
		}, explode("\n", $comment));

		$comment_arr = array_filter($comment_arr, function($it){ return strpos($it, ":") !== false; });

		foreach ($comment_arr as $comment) {
			list($type, $data) = explode(':', $comment);

			switch ($type) {
				case "queue":
					list($controller_name, $method_name) = explode('|', trim($data));

					$this->app['controller_container']->put($controller_name, $method_name);
					break;
			}
		}
	}

}