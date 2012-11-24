<?

namespace Application\Controller;

class GameController extends ControllerBase {

	/**
	 * @return bool
	 *
	 * queue: user|conf
	 * queue: user|bag
	 */
	public function executeInit() {
		return true;
	}

	public function executeEmpty() {
		return true;
	}

}
