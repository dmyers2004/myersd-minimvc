<?php

class dbController extends basePublicController {

	public function indexAction() {
		echo '<pre>';
		var_dump(Database::$data);
	}

	public function createAction() {
		echo '<pre>';

		$mPeople = new mPeople;

		$mPeople->keyword_id = mt_rand(1, 9999);
		$mPeople->hash = md5($mPeople->keyword_id);
		$mPeople->create();

		print_r($mPeople);

		var_dump($mPeople->count());
	}

	public function existsAction($id=0) {
		echo '<pre>';

		$mPeople = new mPeople();
		$mPeople->debug();
		$c = $mPeople->exists($id);
		var_dump($c);

		$mPeople = new mPeople();
		$mPeople->debug();
		$mPeople->read(64);
		$c = $mPeople->exists();
		var_dump($c);
	}

	public function updateAction() {
		echo '<pre>';
		$mPeople = new mPeople();
		$mPeople->create();

		$mPeople->debug();
		$mPeople->hash = 'updated';
		$mPeople->update();
		print_r($mPeople);
	}

	public function deleteAction() {
		echo '<pre>';

		$mPeople = new mPeople();
		$mPeople->debug();
		$mPeople->create();

		echo 'id = '.$mPeople->id.chr(10);
		print_r($mPeople);

		$mPeople->delete();

		print_r($mPeople);
	}

	public function readAction() {
		echo '<pre>';

		$mPeople = new mPeople();
		$mPeople->debug();
		$mPeople->read(64);

		echo 'id = '.$mPeople->id.chr(10);
		print_r($mPeople);
	}

	public function readOneAction() {
		echo '<pre>';

		$mPeople = new mPeople();
		$mPeople->debug();
		$mPeople->readOne(array('hash'=>array('like','%73%')));

		echo 'id = '.$mPeople->id.chr(10);
		print_r($mPeople);
	}

	public function paginateAction() {
		echo '<pre>';

		$mPeople = new mPeople();
		$mPeople->debug();

		$mPeople->paginate(NULL,1);
		foreach ($mPeople->records() as $record) {
			echo $record->id.chr(10);
		}

		$mPeople->paginate(NULL,2);
		foreach ($mPeople->records() as $record) {
			echo $record->id.chr(10);
		}

	}

	public function readManyAction() {
		echo '<pre>';

		$mPeople = new mPeople();
		$mPeople->debug();
		$mPeople->readMany(array('hash'=>array('like','%73%')));

		foreach ($mPeople->records() as $index => $record) {
			echo '        id: '.$record->id.chr(10);
			echo '      hash: '.$record->hash.chr(10);
			echo 'keyword_id: '.$record->keyword_id.chr(10).chr(10);
		}
	}

	public function testAction() {
		$unit[] = 'db/create';
		$unit[] = 'db/exists/64';
		$unit[] = 'db/update';
		$unit[] = 'db/delete';
		$unit[] = 'db/read';
		$unit[] = 'db/readone';
		$unit[] = 'db/readmany';
		$unit[] = 'db/paginate';

		View::setUnit($unit);
		View::render('unit_test');
	}

}
