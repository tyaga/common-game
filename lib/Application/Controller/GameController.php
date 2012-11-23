<?

namespace Application\Controller;

class GameController extends ControllerBase {

	/**
	 * @return bool
	 *
	 * queue: user|bag
	 */
	public function executeInit() {
		return true;
	}

	public function executeEmpty() {
		return true;
	}

}
